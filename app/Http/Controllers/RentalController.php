<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RentalController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of rentals for customers
     */
    public function index(Request $request)
    {
        $query = Rental::with(['car', 'user', 'reservation'])
            ->where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rentals = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('rentals.index', compact('rentals'));
    }

    /**
     * Display the specified rental
     */
    public function show(Rental $rental)
    {
        // Ensure user can only view their own rentals (unless admin)
        if (!auth()->user()->isAdmin() && $rental->user_id !== auth()->id()) {
            abort(403);
        }

        $rental->load(['car', 'user', 'createdBy', 'returnedBy', 'reservation']);

        return view('rentals.show', compact('rental'));
    }

    /**
     * Admin: Display all rentals
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('viewAny', Rental::class);

        $query = Rental::with(['car', 'user', 'createdBy', 'returnedBy', 'reservation']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('car', function ($carQuery) use ($search) {
                    $carQuery->where('make', 'like', "%{$search}%")
                             ->orWhere('model', 'like', "%{$search}%")
                             ->orWhere('plate_number', 'like', "%{$search}%");
                })->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        if ($request->filled('overdue')) {
            $query->overdue();
        }

        $rentals = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.rentals.index', compact('rentals'));
    }

    /**
     * Admin: Manage customer returns & receipts.
     */
    public function returnManagement(Request $request)
    {
        $this->authorize('viewAny', Rental::class);

        $baseQuery = Rental::with(['car', 'user', 'reservation'])
            ->where('status', 'returned');

        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($q) use ($search) {
                $q->whereHas('car', function ($carQuery) use ($search) {
                    $carQuery->where('make', 'like', "%{$search}%")
                             ->orWhere('model', 'like', "%{$search}%")
                             ->orWhere('plate_number', 'like', "%{$search}%");
                })->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('verification')) {
            if ($request->verification === 'pending') {
                $baseQuery->whereNull('return_verified_at');
            } elseif ($request->verification === 'approved') {
                $baseQuery->whereNotNull('return_verified_at');
            }
        }

        if ($request->filled('overdue_status')) {
            $status = $request->overdue_status;
            if ($status === 'pending') {
                $baseQuery->where('overdue_payment_status', 'pending');
            } elseif ($status === 'paid') {
                $baseQuery->where('overdue_payment_status', 'paid');
            } elseif ($status === 'not_required') {
                $baseQuery->where('overdue_payment_status', 'not_required');
            }
        }

        $stats = [
            'pending_verification' => (clone $baseQuery)->whereNull('return_verified_at')->count(),
            'pending_overdue' => (clone $baseQuery)->where('overdue_payment_status', 'pending')->count(),
            'approved' => (clone $baseQuery)->whereNotNull('return_verified_at')->count(),
        ];

        $returns = $baseQuery->orderByDesc('actual_end_date')->paginate(15)->withQueryString();

        return view('admin.returns.index', compact('returns', 'stats'));
    }

    /**
     * Show the customer return form.
     */
    public function returnForm(Rental $rental)
    {
        $this->authorize('returnAsCustomer', $rental);

        $rental->loadMissing('car', 'reservation');

        $isPaymentOnly = $rental->status === 'returned' && $rental->overdue_payment_status === 'pending';
        $baselineDate = $rental->actual_end_date ? $rental->actual_end_date->format('Y-m-d') : now()->format('Y-m-d');
        $overduePreviewDays = Carbon::parse($baselineDate)->gt($rental->end_date)
            ? $rental->end_date->diffInDays(Carbon::parse($baselineDate))
            : 0;
        $overduePreviewFee = $overduePreviewDays * $rental->car->daily_rate;

        return view('rentals.return', [
            'rental' => $rental,
            'suggestedEnd' => $baselineDate,
            'overduePreviewDays' => $overduePreviewDays,
            'overduePreviewFee' => $overduePreviewFee,
            'isPaymentOnly' => $isPaymentOnly,
        ]);
    }

    /**
     * Handle customer-initiated returns.
     */
    public function submitReturn(Request $request, Rental $rental)
    {
        $this->authorize('returnAsCustomer', $rental);

        $isActiveReturn = $rental->status === 'active';
        $isPaymentUpdate = $rental->status === 'returned' && $rental->overdue_payment_status === 'pending';

        if (!$isActiveReturn && !$isPaymentUpdate) {
            return back()->with('error', 'This rental cannot be updated.');
        }

        $validated = $request->validate([
            'actual_end_date' => 'required|date|after_or_equal:' . $rental->start_date->format('Y-m-d'),
            'overdue_payment_method' => 'nullable|in:telebirr,cbe,bank',
            'overdue_payment_reference' => 'nullable|string|max:255',
            'overdue_receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'overdue_payment_notes' => 'nullable|string|max:500',
        ]);

        $rental->loadMissing('car');

        $actualEnd = $isActiveReturn || !$rental->actual_end_date
            ? Carbon::parse($validated['actual_end_date'])
            : $rental->actual_end_date;
        $overdueDays = $isActiveReturn
            ? ($actualEnd->gt($rental->end_date) ? $rental->end_date->diffInDays($actualEnd) : 0)
            : ($rental->overdue_fee > 0 ? max(1, (int) round($rental->overdue_fee / max(1, $rental->car->daily_rate))) : 0);
        $overdueFee = $isActiveReturn ? $overdueDays * $rental->car->daily_rate : $rental->overdue_fee;

        if ($overdueFee > 0) {
            $request->validate([
                'overdue_payment_method' => 'required|in:telebirr,cbe,bank',
                'overdue_payment_reference' => 'required|string|max:255',
            ]);
        }

        $receiptPath = $rental->overdue_receipt_path;
        if ($request->hasFile('overdue_receipt_file')) {
            if ($receiptPath && Storage::disk('public')->exists($receiptPath)) {
                Storage::disk('public')->delete($receiptPath);
            }
            $receiptPath = $request->file('overdue_receipt_file')->store('rental_overdue_receipts', 'public');
        }

        $updatePayload = [
            'overdue_fee' => $overdueFee,
            'overdue_payment_status' => $overdueFee > 0 ? 'pending' : 'not_required',
            'overdue_payment_method' => $overdueFee > 0 ? $request->overdue_payment_method : null,
            'overdue_payment_reference' => $overdueFee > 0 ? $request->overdue_payment_reference : null,
            'overdue_receipt_path' => $receiptPath,
            'overdue_payment_notes' => $request->overdue_payment_notes,
            'overdue_paid_at' => null,
            'return_verified_at' => null,
            'return_verified_by' => null,
            'return_verification_notes' => null,
        ];

        if ($isActiveReturn) {
            $updatePayload['actual_end_date'] = $actualEnd;
            $updatePayload['status'] = 'returned';
        }

        $rental->update($updatePayload);

        return redirect()->route('rentals.show', $rental)
            ->with('success', $overdueFee > 0
                ? 'Return submitted. Your overdue payment will be reviewed shortly.'
                : 'Return completed successfully.');
    }

    /**
     * Admin: Create a new rental directly (without reservation)
     */
    public function create(Request $request)
    {
        $this->authorize('create', Rental::class);

        $cars = Car::available()->get();
        $users = User::where('is_active', true)->get();

        return view('admin.rentals.create', compact('cars', 'users'));
    }

    /**
     * Admin: Store a new rental
     */
    public function store(Request $request)
    {
        $this->authorize('create', Rental::class);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'deposit_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $car = Car::findOrFail($validated['car_id']);

        // Check if car is available for the selected dates
        if (!$car->isAvailableForDates($validated['start_date'], $validated['end_date'])) {
            return back()->withErrors(['car_id' => 'This car is not available for the selected dates.'])
                        ->withInput();
        }

        // Calculate total amount
        $days = \Carbon\Carbon::parse($validated['start_date'])
            ->diffInDays(\Carbon\Carbon::parse($validated['end_date'])) + 1;
        $totalAmount = $car->daily_rate * $days;

        $rental = Rental::create([
            'user_id' => $validated['user_id'],
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'actual_start_date' => now(),
            'pickup_location' => $validated['pickup_location'],
            'return_location' => $validated['return_location'],
            'total_amount' => $totalAmount,
            'deposit_amount' => $validated['deposit_amount'] ?? 0,
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.rentals.index')
            ->with('success', 'Rental created successfully.');
    }

    /**
     * Admin: Process car return
     */
    public function processReturn(Request $request, Rental $rental)
    {
        $this->authorize('processReturn', $rental);

        if (!$rental->canBeReturned()) {
            return back()->with('error', 'This rental cannot be returned.');
        }

        $validated = $request->validate([
            'actual_end_date' => 'required|date|after_or_equal:' . $rental->start_date,
            'return_notes' => 'nullable|string',
            'damage_report' => 'nullable|string',
            'additional_charges' => 'nullable|numeric|min:0',
            'mark_overdue_paid' => 'nullable|boolean',
            'overdue_payment_method' => 'nullable|in:telebirr,cbe,bank,cash',
            'overdue_payment_reference' => 'nullable|string|max:255',
            'overdue_receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'overdue_payment_notes' => 'nullable|string|max:500',
        ]);

        $rental->loadMissing('car');

        $actualEnd = Carbon::parse($validated['actual_end_date']);
        $overdueDays = $actualEnd->gt($rental->end_date) ? $rental->end_date->diffInDays($actualEnd) : 0;
        $overdueFee = $overdueDays * $rental->car->daily_rate;

        $receiptPath = $rental->overdue_receipt_path;
        if ($request->hasFile('overdue_receipt_file')) {
            if ($receiptPath && Storage::disk('public')->exists($receiptPath)) {
                Storage::disk('public')->delete($receiptPath);
            }
            $receiptPath = $request->file('overdue_receipt_file')->store('rental_overdue_receipts', 'public');
        }

        $overduePaymentStatus = $overdueFee > 0 ? 'pending' : 'not_required';
        $overduePaidAt = null;
        $overdueMethod = $overdueFee > 0 ? $validated['overdue_payment_method'] : null;
        $overdueReference = $overdueFee > 0 ? $validated['overdue_payment_reference'] : null;

        if ($overdueFee > 0 && $request->boolean('mark_overdue_paid')) {
            $overduePaymentStatus = 'paid';
            $overduePaidAt = now();
            $overdueMethod = $overdueMethod ?? 'cash';
            $overdueReference = $overdueReference ?? 'cash-' . now()->timestamp;
        }

        DB::transaction(function () use ($rental, $validated, $actualEnd, $overdueFee, $overduePaymentStatus, $overdueMethod, $overdueReference, $receiptPath, $overduePaidAt) {
            $rental->update([
                'actual_end_date' => $actualEnd,
                'status' => 'returned',
                'return_notes' => $validated['return_notes'],
                'damage_report' => $validated['damage_report'],
                'additional_charges' => $validated['additional_charges'] ?? 0,
                'returned_by' => auth()->id(),
                'return_verified_at' => now(),
                'return_verified_by' => auth()->id(),
                'return_verification_notes' => $validated['return_notes'] ?? $rental->return_verification_notes,
                'overdue_fee' => $overdueFee,
                'overdue_payment_status' => $overduePaymentStatus,
                'overdue_payment_method' => $overdueMethod,
                'overdue_payment_reference' => $overdueReference,
                'overdue_receipt_path' => $receiptPath,
                'overdue_payment_notes' => $validated['overdue_payment_notes'] ?? $rental->overdue_payment_notes,
                'overdue_paid_at' => $overduePaidAt,
            ]);
        });

        return redirect()->route('admin.rentals.index')
            ->with('success', 'Car return processed successfully.');
    }

    /**
     * Admin: Update rental status
     */
    public function updateStatus(Request $request, Rental $rental)
    {
        $this->authorize('update', $rental);

        $validated = $request->validate([
            'status' => 'required|in:active,returned,overdue',
            'notes' => 'nullable|string',
        ]);

        $rental->update($validated);

        return back()->with('success', 'Rental status updated successfully.');
    }

    /**
     * Admin: Delete rental
     */
    public function destroy(Rental $rental)
    {
        $this->authorize('delete', $rental);

        if ($rental->status !== 'returned') {
            return back()->with('error', 'Only returned rentals can be deleted.');
        }

        $rental->delete();

        return redirect()->route('admin.rentals.index')
            ->with('success', 'Rental deleted successfully.');
    }

    /**
     * Admin: Approve return after verification.
     */
    public function approveReturn(Request $request, Rental $rental)
    {
        $this->authorize('update', $rental);

        if ($rental->status !== 'returned') {
            return back()->with('error', 'Only returned rentals can be approved.');
        }

        if ($rental->overdue_fee > 0 && $rental->overdue_payment_status !== 'paid') {
            if ($rental->overdue_payment_reference || $rental->overdue_receipt_path) {
                $rental->update([
                    'overdue_payment_status' => 'paid',
                    'overdue_paid_at' => now(),
                ]);
            } else {
                return back()->with('error', 'Collect overdue payment or upload proof before approving.');
            }
        }

        $data = $request->validate([
            'return_verification_notes' => 'nullable|string|max:500',
        ]);

        $rental->update([
            'return_verified_at' => now(),
            'return_verified_by' => auth()->id(),
            'return_verification_notes' => $data['return_verification_notes'],
        ]);

        return back()->with('success', 'Return approved successfully.');
    }

    /**
     * Admin: Mark overdue fee as paid.
     */
    public function markOverduePaid(Request $request, Rental $rental)
    {
        $this->authorize('update', $rental);

        if ($rental->overdue_fee <= 0) {
            return back()->with('info', 'No overdue fee to mark as paid.');
        }

        if ($rental->overdue_payment_reference || $rental->overdue_receipt_path) {
            return back()->with('error', 'Customer already submitted payment proof. Please verify via Approve Return.');
        }

        $validated = $request->validate([
            'overdue_payment_method' => 'required|in:telebirr,cbe,bank,cash',
            'overdue_payment_reference' => 'required|string|max:255',
            'overdue_receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'overdue_payment_notes' => 'nullable|string|max:500',
        ]);

        $receiptPath = $rental->overdue_receipt_path;
        if ($request->hasFile('overdue_receipt_file')) {
            if ($receiptPath && Storage::disk('public')->exists($receiptPath)) {
                Storage::disk('public')->delete($receiptPath);
            }
            $receiptPath = $request->file('overdue_receipt_file')->store('rental_overdue_receipts', 'public');
        }

        $rental->update([
            'overdue_payment_status' => 'paid',
            'overdue_payment_method' => $validated['overdue_payment_method'],
            'overdue_payment_reference' => $validated['overdue_payment_reference'],
            'overdue_receipt_path' => $receiptPath,
            'overdue_payment_notes' => $validated['overdue_payment_notes'],
            'overdue_paid_at' => now(),
        ]);

        return back()->with('success', 'Overdue payment recorded.');
    }

    /**
     * Admin: Generate rental reports
     */
    public function reports(Request $request)
    {
        $this->authorize('viewReports', Rental::class);

        $month = $request->get('month', now()->format('Y-m'));
        $year = $request->get('year', now()->year);

        // Monthly statistics
        $monthlyStats = Rental::selectRaw('
            COUNT(*) as total_rentals,
            SUM(total_amount) as total_revenue,
            AVG(total_amount) as avg_rental_amount,
            COUNT(CASE WHEN status = "active" THEN 1 END) as active_rentals,
            COUNT(CASE WHEN status = "returned" THEN 1 END) as completed_rentals,
            COUNT(CASE WHEN status = "overdue" THEN 1 END) as overdue_rentals
        ')
        ->whereYear('created_at', $year)
        ->when($month !== 'all', function ($query) use ($month) {
            return $query->whereYear('created_at', substr($month, 0, 4))
                        ->whereMonth('created_at', substr($month, 5, 2));
        })
        ->first();

        // Top rented cars
        $topCars = Rental::with('car')
            ->selectRaw('car_id, COUNT(*) as rental_count, SUM(total_amount) as total_revenue')
            ->whereYear('created_at', $year)
            ->when($month !== 'all', function ($query) use ($month) {
                return $query->whereYear('created_at', substr($month, 0, 4))
                            ->whereMonth('created_at', substr($month, 5, 2));
            })
            ->groupBy('car_id')
            ->orderBy('rental_count', 'desc')
            ->limit(10)
            ->get();

        // Recent rentals
        $recentRentals = Rental::with(['car', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.rentals.reports', compact('monthlyStats', 'topCars', 'recentRentals', 'month', 'year'));
    }
}
