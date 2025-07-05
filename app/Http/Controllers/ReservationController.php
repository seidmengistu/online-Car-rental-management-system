<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReservationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the customer's reservations.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['car', 'user'])
            ->where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create(Request $request)
    {
        $car = null;
        if ($request->has('car_id')) {
            $car = Car::findOrFail($request->car_id);
        }

        $availableCars = Car::where('is_available', true)->get();

        return view('reservations.create', compact('car', 'availableCars'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $car = Car::findOrFail($validated['car_id']);

        // Check if car is available for the selected dates
        if (!$car->isAvailableForDates($validated['start_date'], $validated['end_date'])) {
            return back()->withErrors(['car_id' => 'This car is not available for the selected dates.'])
                        ->withInput();
        }

        // Calculate total amount
        $days = Carbon::parse($validated['start_date'])
            ->diffInDays(Carbon::parse($validated['end_date'])) + 1;
        $totalAmount = $car->daily_rate * $days;

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'pickup_location' => $validated['pickup_location'],
            'return_location' => $validated['return_location'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Reservation created successfully! It will be reviewed by our staff.');
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reservation $reservation)
    {
        // Ensure user can only view their own reservations (unless admin)
        if (!auth()->user()->isAdmin() && $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->load(['car', 'user']);

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Cancel the specified reservation.
     */
    public function cancel(Reservation $reservation)
    {
        // Ensure user can only cancel their own reservations
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if reservation can be cancelled
        if (!$reservation->canBeCancelled()) {
            return back()->with('error', 'This reservation cannot be cancelled.');
        }

        $reservation->update([
            'status' => 'cancelled',
            'notes' => $reservation->notes . "\n[Cancelled by user on " . now() . "]",
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Admin: Display all reservations
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('viewAny', Reservation::class);

        $query = Reservation::with(['car', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('car', function($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.bookings.index', compact('reservations'));
    }

    /**
     * Admin: Update reservation status
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $reservation->update($validated);

        return back()->with('success', 'Reservation status updated successfully.');
    }

    /**
     * Admin: Convert reservation to rental
     */
    public function convertToRental(Reservation $reservation)
    {
        $this->authorize('convertToRental', $reservation);

        if (!$reservation->canBeConvertedToRental()) {
            return back()->with('error', 'This reservation cannot be converted to a rental.');
        }

        // Create rental from reservation
        $rental = Rental::create([
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'car_id' => $reservation->car_id,
            'start_date' => $reservation->start_date,
            'end_date' => $reservation->end_date,
            'actual_start_date' => now(),
            'pickup_location' => $reservation->pickup_location,
            'return_location' => $reservation->return_location,
            'total_amount' => $reservation->total_amount,
            'deposit_amount' => 0, // Default deposit
            'status' => 'active',
            'notes' => "Converted from reservation #{$reservation->id}",
            'created_by' => auth()->id(),
        ]);

        // Update reservation status
        $reservation->update([
            'status' => 'completed',
            'notes' => $reservation->notes . "\n[Converted to rental #{$rental->id} on " . now() . "]",
        ]);

        return redirect()->route('admin.rentals.index')
            ->with('success', 'Reservation converted to rental successfully.');
    }

    /**
     * Admin: Delete reservation
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
}
