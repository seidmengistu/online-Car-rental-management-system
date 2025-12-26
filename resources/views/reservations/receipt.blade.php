<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Carola Receipt</title>
    <style>
        body { font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; margin: 0; padding: 2rem; background: #f8fafc; color: #0f172a; }
        .receipt { background: #fff; border-radius: 1rem; padding: 2rem; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.1); max-width: 720px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .header h2 { margin: 0; }
        .section { margin-bottom: 1.5rem; }
        .section h4 { margin-bottom: 0.5rem; color: #475569; text-transform: uppercase; letter-spacing: 0.08em; font-size: 0.85rem; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 0.4rem 0; vertical-align: top; }
        .label { color: #64748b; width: 40%; }
        .value { font-weight: 600; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div>
                <h2>Payment receipt</h2>
                <p style="margin:0;">Reference: {{ $payment->reference }}</p>
            </div>
            <div style="text-align:right;">
                <strong>EthioRental</strong><br>
                Addis Ababa, Ethiopia
            </div>
        </div>

        <div class="section">
            <h4>Customer</h4>
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
            <h4>Reservation</h4>
            <table>
                <tr>
                    <td class="label">Reservation ID</td>
                    <td class="value">#{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td class="label">Vehicle</td>
                    <td class="value">{{ $reservation->car->full_name }}</td>
                </tr>
                <tr>
                    <td class="label">Travel dates</td>
                    <td class="value">{{ $reservation->start_date->format('M d, Y') }} - {{ $reservation->end_date->format('M d, Y') }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h4>Payment</h4>
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
                    <td class="label">Paid on</td>
                    <td class="value">{{ optional($payment->paid_at)->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="label">Card ending</td>
                    <td class="value">**** **** **** {{ $payment->card_last_four }}</td>
                </tr>
            </table>
        </div>

        <p style="margin:0; font-size:0.85rem; color:#94a3b8;">Thank you for choosing EthioRental. Please keep this receipt for your records.</p>
    </div>
</body>
</html>

