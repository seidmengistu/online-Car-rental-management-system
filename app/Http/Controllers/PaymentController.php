<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\Reservation;
use App\Services\ChapaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private ChapaService $chapaService)
    {
    }
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
     * Process the payment submission by redirecting to Chapa.
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

        $reservation->loadMissing(['car', 'user']);

        $txRef = $this->chapaService->makeTxRef('RES', $reservation->id);

        $payerEmail = $reservation->user->email
            ?? auth()->user()->email
            ?? 'payer@example.com';
        $payerName = trim($reservation->user->name ?? auth()->user()->name ?? 'Customer Reservation');
        $firstName = Str::before($payerName, ' ') ?: 'Customer';
        $lastName = Str::after($payerName, ' ') ?: 'Reservation';
        $email = filter_var($payerEmail, FILTER_VALIDATE_EMAIL) ? $payerEmail : 'test@example.com';

        $sanitizedCar = trim(preg_replace('/[^A-Za-z0-9 ._-]/', '', $reservation->car->full_name));
        $customTitle = 'Car Payment'; // must be <= 16 chars
        $customDescription = 'Reservation ' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT) . ' ' . $sanitizedCar;

        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'user_id' => auth()->id(),
            'amount' => $reservation->total_amount,
            'currency' => 'ETB',
            'payment_method' => 'chapa',
            'provider' => 'Chapa',
            'status' => 'initiated',
            'reference' => $txRef,
            'meta' => [
                'type' => 'reservation',
            ],
        ]);

        $initPayload = [
            'amount' => number_format($reservation->total_amount, 2, '.', ''),
            'currency' => 'ETB',
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'tx_ref' => $txRef,
            'callback_url' => route('payments.chapa.callback'),
            'return_url' => route('reservations.show', $reservation),
            'customization' => [
                'title' => $customTitle,
                'description' => $customDescription,
            ],
            'meta' => [
                'reservation_id' => $reservation->id,
                'user_id' => auth()->id(),
            ],
        ];

        $init = $this->chapaService->initialize($initPayload);

        if (!$init['ok'] || empty($init['checkout_url'])) {
            Log::error('Chapa init failed for reservation', [
                'tx_ref' => $txRef,
                'reservation_id' => $reservation->id,
                'user_id' => auth()->id(),
                'response' => $init,
            ]);

            $payment->update([
                'status' => 'failed',
                'meta' => array_merge($payment->meta ?? [], [
                    'chapa_init' => $init['raw'] ?? null,
                ]),
            ]);

            return back()->with('error', 'Unable to start Chapa payment. Please try again.');
        }

        $payment->update([
            'meta' => array_merge($payment->meta ?? [], [
                'checkout_url' => $init['checkout_url'],
                'chapa_init' => $init['raw'] ?? null,
            ]),
        ]);

        $reservation->update([
            'payment_status' => 'pending',
            'payment_reference' => $txRef,
            'payment_receipt_path' => null,
        ]);

        return redirect()->away($init['checkout_url']);
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

    /**
     * Chapa callback to verify reservation or overdue payments.
     */
    public function chapaCallback(Request $request)
    {
        $txRef = $request->get('tx_ref');

        if (!$txRef) {
            return redirect()->route('home')->with('error', 'Missing payment reference.');
        }

        $verification = $this->chapaService->verify($txRef);

        if ($payment = Payment::where('reference', $txRef)->first()) {
            $reservation = $payment->reservation;

            if ($verification['ok']) {
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'meta' => array_merge($payment->meta ?? [], [
                        'chapa_verify' => $verification['raw'] ?? null,
                    ]),
                ]);

                $reservation?->update([
                    'payment_status' => 'paid',
                    'payment_reference' => $txRef,
                ]);

                return redirect()->route('reservations.show', $reservation)
                    ->with('success', 'Payment completed successfully.');
            }

            $payment->update([
                'status' => 'failed',
                'meta' => array_merge($payment->meta ?? [], [
                    'chapa_verify' => $verification['raw'] ?? null,
                ]),
            ]);

            $reservation?->update(['payment_status' => 'failed']);

            $redirectUrl = $reservation
                ? route('reservations.payment', $reservation)
                : route('home');

            return redirect($redirectUrl)
                ->with('error', 'Payment was not successful. Please try again.');
        }

        if ($rental = Rental::where('overdue_payment_reference', $txRef)->first()) {
            if ($verification['ok']) {
                $rental->update([
                    'overdue_payment_status' => 'paid',
                    'overdue_paid_at' => now(),
                    'overdue_payment_method' => 'chapa',
                ]);

                return redirect()->route('rentals.show', $rental)
                    ->with('success', 'Overdue fine paid successfully.');
            }

            return redirect()->route('rentals.show', $rental)
                ->with('error', 'Overdue payment was not completed. Please try again.');
        }

        return redirect()->route('home')->with('error', 'Payment reference not recognized.');
    }
}
