<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EthioRental – Receipt</title>
    <style>
        body { font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; margin: 0; padding: 2rem; background: #f5f6fb; color: #0f172a; }
        .receipt { background: #fff; border-radius: 1.25rem; padding: 2.5rem; box-shadow: 0 25px 60px rgba(15,23,42,0.08); max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; }
        .header h1 { margin: 0; font-size: 2rem; }
        .section { margin-bottom: 1.75rem; }
        .section h3 { margin-bottom: 0.5rem; letter-spacing: 0.08em; text-transform: uppercase; font-size: 0.9rem; color: #64748b; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 0.35rem 0; vertical-align: top; }
        .label { width: 35%; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.08em; font-size: 0.75rem; }
        .value { font-weight: 600; }
        .card { border: 1px solid #edf0f7; border-radius: 0.9rem; padding: 1.25rem; margin-top: 1rem; background: #f9fafc; }
        .muted { color: #94a3b8; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div>
                <h1>Payment receipt</h1>
                <p class="muted">Reference: {{ $payment->reference }}</p>
            </div>
            <div style="text-align:right;">
                <strong>EthioRental</strong><br>
                Addis Ababa, Ethiopia<br>
                support@carola.com
            </div>
        </div>

        <div class="section">
            <h3>Customer details</h3>
            <table>
                <tr>
                    <td class="label">Name</td>
                    <td class="value">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="value">{{ $user->email }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>Rental details</h3>
            <table>
                <tr>
                    <td class="label">Reservation ID</td>
                    <td class="value">#{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td class="label">Rental period</td>
                    <td class="value">{{ $reservation->start_date->format('M d, Y') }} – {{ $reservation->end_date->format('M d, Y') }} ({{ $reservation->start_date->diffInDays($reservation->end_date) + 1 }} days)</td>
                </tr>
                <tr>
                    <td class="label">Pickup / Return</td>
                    <td class="value">{{ $reservation->pickup_location }} → {{ $reservation->return_location }}</td>
                </tr>
                <tr>
                    <td class="label">Driver requested</td>
                    <td class="value">{{ $reservation->requires_driver ? 'Yes, driver assigned' : 'No (self-drive)' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>Vehicle</h3>
            <table>
                <tr>
                    <td class="label">Car</td>
                    <td class="value">{{ $reservation->car->full_name }}</td>
                </tr>
                <tr>
                    <td class="label">Plate number</td>
                    <td class="value">{{ $reservation->car->plate_number }}</td>
                </tr>
                <tr>
                    <td class="label">Color / Seats</td>
                    <td class="value">{{ $reservation->car->color }} · {{ $reservation->car->seats }} seats</td>
                </tr>
                <tr>
                    <td class="label">Fuel / Transmission</td>
                    <td class="value">{{ ucfirst($reservation->car->fuel_type) }} · {{ ucfirst($reservation->car->transmission) }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>Payment</h3>
            <table>
                <tr>
                    <td class="label">Amount</td>
                    <td class="value">Br {{ number_format($payment->amount, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td class="value">{{ ucfirst($payment->status) }}</td>
                </tr>
                <tr>
                    <td class="label">Method</td>
                    <td class="value">{{ $payment->provider }} ({{ str_replace('_', ' ', ucfirst($payment->payment_method)) }})</td>
                </tr>
                <tr>
                    <td class="label">Customer reference</td>
                    <td class="value">{{ $payment->meta['customer_reference'] ?? $reservation->payment_reference ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Paid at</td>
                    <td class="value">{{ optional($payment->paid_at ?? $payment->created_at)->format('M d, Y H:i') }}</td>
                </tr>
            </table>
            @if($payment->meta['notes'] ?? false)
                <div class="card">
                    <strong>Customer note:</strong>
                    <p class="muted mb-0">{{ $payment->meta['notes'] }}</p>
                </div>
            @endif
        </div>

    <div class="section">
        <h3>Uploaded receipt</h3>
        @if(!empty($receiptPreview))
            <div class="card">
                <p class="muted mb-2">Preview of the receipt provided by the customer.</p>
                <img src="{{ $receiptPreview }}" alt="Receipt preview" style="width:100%; border-radius:0.75rem; border:1px solid #e2e8f0;">
            </div>
        @else
            <p class="muted">No supporting file attached.</p>
        @endif
    </div>

        <p class="muted" style="margin-top:1.5rem;">Thank you for choosing EthioRental. Please keep this confirmation for your records.</p>
    </div>
</body>
</html>

