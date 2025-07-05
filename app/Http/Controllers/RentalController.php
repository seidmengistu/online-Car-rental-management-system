<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RentalController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of rentals for customers
     */
    public function index(Request $request)
    {
        $query = Rental::with(['car', 'user'])
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

        $query = Rental::with(['car', 'user', 'createdBy', 'returnedBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
        ]);

        DB::transaction(function () use ($rental, $validated) {
            $rental->update([
                'actual_end_date' => $validated['actual_end_date'],
                'status' => 'returned',
                'return_notes' => $validated['return_notes'],
                'damage_report' => $validated['damage_report'],
                'additional_charges' => $validated['additional_charges'] ?? 0,
                'returned_by' => auth()->id(),
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
