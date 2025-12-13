<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show the payment form for a reservation.
     */
    public function create(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        if (!auth()->user()->isAdmin() && $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->payment_status === 'paid') {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('info', 'This reservation has already been paid.');
        }

        $reservation->loadMissing(['car', 'payments' => fn ($query) => $query->latest()]);

        return view('reservations.payment', compact('reservation'));
    }

    /**
     * Process the payment submission.
     */
    public function store(Request $request, Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->payment_status === 'paid') {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('info', 'Payment already completed for this reservation.');
        }

        $reservation->loadMissing('car');

        $data = $request->validate([
            'payment_method' => 'required|in:telebirr,cbe,bank',
            'payment_reference' => 'required|string|max:255',
            'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'notes' => 'nullable|string|max:500',
        ]);

        $receiptPath = $reservation->payment_receipt_path;
        if ($request->hasFile('receipt_file')) {
            if ($receiptPath && Storage::disk('public')->exists($receiptPath)) {
                Storage::disk('public')->delete($receiptPath);
            }
            $receiptPath = $request->file('receipt_file')->store('payment_receipts', 'public');
        }

        $systemReference = 'PAY-' . Str::upper(Str::random(8));

        Payment::create([
            'reservation_id' => $reservation->id,
            'user_id' => auth()->id(),
            'amount' => $reservation->total_amount,
            'currency' => 'ETB',
            'payment_method' => $this->mapMethod($data['payment_method']),
            'provider' => $this->mapProvider($data['payment_method']),
            'status' => 'submitted',
            'reference' => $systemReference,
            'receipt_path' => $receiptPath,
            'meta' => [
                'customer_reference' => $data['payment_reference'],
                'notes' => $data['notes'] ?? null,
            ],
        ]);

        $reservation->update([
            'payment_status' => 'pending',
            'payment_reference' => $data['payment_reference'],
            'payment_receipt_path' => $receiptPath,
        ]);

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Receipt submitted! We will verify it shortly.');
    }

    /**
     * Download the reservation payment receipt.
     */
    public function receipt(Reservation $reservation)
    {
        $reservation->loadMissing(['car', 'user', 'payments' => fn ($q) => $q->latest()]);

        if (!auth()->user()->isAdmin() && $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->payments->isEmpty()) {
            abort(404, 'Receipt not available.');
        }

        $payment = $reservation->payments->first();
        $receiptPreview = null;

        if ($reservation->payment_receipt_path && Storage::disk('public')->exists($reservation->payment_receipt_path)) {
            $absolutePath = Storage::disk('public')->path($reservation->payment_receipt_path);
            $mime = mime_content_type($absolutePath);
            $receiptPreview = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($absolutePath));
        }

        $pdf = Pdf::loadView('reservations.full-receipt', [
            'reservation' => $reservation,
            'payment' => $payment,
            'user' => $reservation->user,
            'receiptPreview' => $receiptPreview,
        ])->setPaper('a4');

        return $pdf->download('carola-reservation-' . $reservation->id . '-receipt.pdf');
    }

    protected function mapProvider(string $method): string
    {
        return match ($method) {
            'telebirr' => 'Telebirr',
            'cbe' => 'Commercial Bank of Ethiopia',
            default => 'Bank Branch',
        };
    }

    protected function mapMethod(string $method): string
    {
        return match ($method) {
            'telebirr' => 'mobile_wallet',
            'cbe' => 'bank_transfer',
            default => 'bank_branch',
        };
    }
}

