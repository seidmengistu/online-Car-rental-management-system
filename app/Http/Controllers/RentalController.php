<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use App\Services\ChapaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class RentalController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private ChapaService $chapaService)
    {
    }

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
            'overdue_payment_notes' => 'nullable|string|max:500',
        ]);

        $rental->loadMissing('car', 'user');

        $actualEnd = $isActiveReturn || !$rental->actual_end_date
            ? Carbon::parse($validated['actual_end_date'])
            : $rental->actual_end_date;
        $overdueDays = $isActiveReturn
            ? ($actualEnd->gt($rental->end_date) ? $rental->end_date->diffInDays($actualEnd) : 0)
            : ($rental->overdue_fee > 0 ? max(1, (int) round($rental->overdue_fee / max(1, $rental->car->daily_rate))) : 0);
        $overdueFee = $isActiveReturn ? $overdueDays * $rental->car->daily_rate : $rental->overdue_fee;

        $overdueReference = $overdueFee > 0
            ? ($rental->overdue_payment_reference ?: $this->chapaService->makeTxRef('FINE', $rental->id))
            : null;

        $updatePayload = [
            'overdue_fee' => $overdueFee,
            'overdue_payment_status' => $overdueFee > 0 ? 'pending' : 'not_required',
            'overdue_payment_method' => $overdueFee > 0 ? 'chapa' : null,
            'overdue_payment_reference' => $overdueReference,
            'overdue_receipt_path' => null,
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

        if ($overdueFee > 0) {
            $checkoutUrl = $this->startOverdueCheckout($rental);

            if ($checkoutUrl) {
                return redirect()->away($checkoutUrl);
            }

            return redirect()->route('rentals.show', $rental)
                ->with('error', 'Return saved but we could not start Chapa checkout. Please try paying again.');
        }

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Return completed successfully.');
    }

    /**
     * Customer: start or restart Chapa checkout for overdue payments.
     */
    public function startOverduePayment(Rental $rental)
    {
        $this->authorize('returnAsCustomer', $rental);

        if ($rental->overdue_fee <= 0) {
            return back()->with('info', 'No overdue fee to pay.');
        }

        if ($rental->overdue_payment_status === 'paid') {
            return back()->with('info', 'Overdue payment already marked as paid.');
        }

        $rental->loadMissing('car', 'user');

        $checkoutUrl = $this->startOverdueCheckout($rental);

        if ($checkoutUrl) {
            return redirect()->away($checkoutUrl);
        }

        return back()->with('error', 'Could not start Chapa payment. Please try again.');
    }

    /**
     * Build a Chapa checkout session for overdue amounts.
     */
    protected function startOverdueCheckout(Rental $rental): ?string
    {
        if ($rental->overdue_fee <= 0) {
            return null;
        }

        $txRef = $rental->overdue_payment_reference ?: $this->chapaService->makeTxRef('FINE', $rental->id);

        if (!$rental->overdue_payment_reference) {
            $rental->update([
                'overdue_payment_reference' => $txRef,
                'overdue_payment_method' => 'chapa',
                'overdue_payment_status' => 'pending',
            ]);
        }

        $init = $this->chapaService->initialize([
            'amount' => number_format($rental->overdue_fee, 2, '.', ''),
            'currency' => 'ETB',
            'email' => filter_var($rental->user->email ?? auth()->user()->email ?? '', FILTER_VALIDATE_EMAIL)
                ? ($rental->user->email ?? auth()->user()->email)
                : 'test@example.com',
            'first_name' => Str::before($rental->user->name ?? auth()->user()->name ?? 'Customer Rental', ' ') ?: 'Customer',
            'last_name' => Str::after($rental->user->name ?? auth()->user()->name ?? 'Customer Rental', ' ') ?: 'Rental',
            'tx_ref' => $txRef,
            'callback_url' => route('payments.chapa.callback'),
            'return_url' => route('rentals.show', $rental),
            'customization' => [
                'title' => 'Overdue Fee', // must be <= 16 chars
                'description' => 'Rental ' . str_pad($rental->id, 5, '0', STR_PAD_LEFT) . ' overdue fee',
            ],
            'meta' => [
                'rental_id' => $rental->id,
                'user_id' => $rental->user_id,
            ],
        ]);

        if ($init['ok'] && !empty($init['checkout_url'])) {
            return $init['checkout_url'];
        }

        Log::error('Chapa init failed for overdue rental', [
            'tx_ref' => $txRef,
            'rental_id' => $rental->id,
            'user_id' => $rental->user_id,
            'response' => $init,
        ]);

        return null;
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

        // Notify User
        try {
            $rental->user->notify(new \App\Notifications\RentalStatusUpdated($rental, $validated['status']));
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

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
