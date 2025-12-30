<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ActivityLog;

class ReservationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the customer's reservations.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['car'])
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
            'requires_driver' => 'nullable|boolean',
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
            'notes' => $validated['notes'] ?? null,
            'requires_driver' => $request->boolean('requires_driver'),
            'payment_status' => 'pending',
        ]);

        // Log activity
        ActivityLog::log('reservation_created', "Created booking #{$reservation->id} for {$car->name} ({$days} days, \${$totalAmount})", $reservation);

        // Notify Admins
        try {
            $admins = \App\Models\User::whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'manager', 'staff']);
            })->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewBookingCreated($reservation));
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

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

        $reservation->load([
            'car',
            'user',
            'payments' => function ($query) {
                $query->latest();
            }
        ]);

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

        if ($reservation->rental && $reservation->rental->status === 'active' && $reservation->rental->actual_start_date === null) {
            $reservation->rental->delete();
        }

        $reservation->update([
            'status' => 'cancelled',
            'notes' => $this->appendNote($reservation->notes, '[Cancelled by user on ' . now()->toDayDateTimeString() . ']'),
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

        $query = Reservation::with([
            'car',
            'user',
            'payments' => fn($q) => $q->latest(),
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
                ->orWhereHas('car', function ($q) use ($search) {
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

        if ($validated['status'] === 'confirmed' && $reservation->payment_status !== 'paid') {
            return back()->with('error', 'Approve the payment before confirming this reservation.');
        }

        $updatePayload = [
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $reservation->notes,
        ];

        if ($validated['status'] === 'confirmed') {
            $this->ensureRentalExists($reservation, auth()->id());
        }
        if ($validated['status'] === 'cancelled' && $reservation->rental && $reservation->rental->actual_start_date === null) {
            $reservation->rental->delete();
        }

        $reservation->update($updatePayload);

        // Notify User
        try {
            $reservation->user->notify(new \App\Notifications\BookingStatusUpdated($reservation, $validated['status']));
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

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

        if ($reservation->payment_status !== 'paid') {
            return back()->with('error', 'Payment must be approved before converting to a rental.');
        }

        $rental = $this->ensureRentalExists($reservation, auth()->id(), true);

        $reservation->update([
            'status' => 'completed',
            'payment_status' => 'paid',
            'notes' => $this->appendNote($reservation->notes, '[Converted to rental #' . $rental->id . ' on ' . now()->toDayDateTimeString() . ']'),
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

    /**
     * Ensure a rental exists for the reservation.
     */
    protected function ensureRentalExists(Reservation $reservation, ?int $actorId = null, bool $setActualStart = false)
    {
        if ($reservation->rental) {
            if ($setActualStart && !$reservation->rental->actual_start_date) {
                $reservation->rental->update(['actual_start_date' => now()]);
            }

            return $reservation->rental;
        }

        return Rental::create([
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'car_id' => $reservation->car_id,
            'requires_driver' => $reservation->requires_driver,
            'start_date' => $reservation->start_date,
            'end_date' => $reservation->end_date,
            'actual_start_date' => $setActualStart ? now() : null,
            'pickup_location' => $reservation->pickup_location,
            'return_location' => $reservation->return_location,
            'total_amount' => $reservation->total_amount,
            'deposit_amount' => 0,
            'status' => 'active',
            'notes' => $setActualStart
                ? "Converted from reservation #{$reservation->id}"
                : "Auto-generated from reservation #{$reservation->id}",
            'created_by' => $actorId,
        ]);
    }

    /**
     * Helper to append audit notes safely.
     */
    protected function appendNote(?string $existing, string $line): string
    {
        $existing = trim((string) $existing);
        $line = trim($line);

        return $existing ? $existing . "\n" . $line : $line;
    }

    /**
     * Admin: Approve a pending payment.
     */
    public function approvePayment(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        if (!$reservation->payment_reference) {
            return back()->with('error', 'No payment receipt has been submitted for this reservation.');
        }

        $latestPayment = $reservation->payments()->latest()->first();
        if ($latestPayment) {
            $latestPayment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        $reservation->update([
            'payment_status' => 'paid',
        ]);

        return back()->with('success', 'Payment approved successfully. You can now confirm the reservation.');
    }

    /**
     * Admin: Reset payment verification to request a new receipt.
     */
    public function resetPayment(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $data = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $latestPayment = $reservation->payments()->latest()->first();
        if ($latestPayment) {
            $latestPayment->update([
                'status' => 'failed',
                'meta' => array_merge($latestPayment->meta ?? [], [
                    'admin_reason' => $data['reason'],
                ]),
            ]);
        }

        if ($reservation->payment_receipt_path && Storage::disk('public')->exists($reservation->payment_receipt_path)) {
            Storage::disk('public')->delete($reservation->payment_receipt_path);
        }

        $reservation->update([
            'payment_status' => 'pending',
            'payment_reference' => null,
            'payment_receipt_path' => null,
        ]);

        return back()->with('success', 'Payment receipt cleared. Ask the customer to upload a new proof of payment.');
    }
}
