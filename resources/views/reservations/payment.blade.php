@extends('layouts.app')

@section('title', 'Complete Payment')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('reservations.index') }}">Reservations</a>
<span class="separator">/</span>
<span class="current">Payment</span>
@endsection

@push('styles')
<style>
    .payment-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 25px 60px rgba(15,23,42,0.08);
    }
    .payment-summary {
        border: 1px solid #edf0f7;
        border-radius: 1rem;
        padding: 1.25rem;
        background: #f8fafc;
    }
    .secure-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        background: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card payment-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Secure payment</h4>
                        <small class="text-muted">Reservation #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</small>
                    </div>
                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="payment-summary mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <span class="text-muted text-uppercase small">Amount</span>
                                <h4 class="mb-0">${{ number_format($reservation->total_amount, 2) }}</h4>
                                <small class="text-muted">Charged in ETB</small>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted text-uppercase small">Vehicle</span>
                                <h6 class="mb-0">{{ $reservation->car->full_name }}</h6>
                                <small class="text-muted">{{ $reservation->start_date->format('M d') }} - {{ $reservation->end_date->format('M d, Y') }}</small>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="secure-badge">
                                    <i class="bi bi-shield-lock"></i>Encrypted
                                </span>
                            </div>
                        </div>
                    </div>
    @if($reservation->payment_reference)
        <div class="alert alert-warning">
            <strong>Receipt already submitted.</strong> Updating the form below will replace your previous submission.
        </div>
    @endif
    <form method="POST" action="{{ route('reservations.payment.process', $reservation) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
            <label class="form-label fw-semibold">Payment method</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach(['telebirr' => 'Telebirr', 'cbe' => 'CBE bank transfer', 'bank' => 'Other bank branch'] as $value => $label)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="method_{{ $value }}" value="{{ $value }}" {{ old('payment_method') === $value ? 'checked' : '' }} required>
                        <label class="form-check-label" for="method_{{ $value }}">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
            @error('payment_method')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
            <label class="form-label fw-semibold">Receipt / transaction reference</label>
            <input type="text" name="payment_reference" class="form-control @error('payment_reference') is-invalid @enderror" value="{{ old('payment_reference', $reservation->payment_reference) }}" placeholder="e.g., Telebirr Txn ID or deposit slip #" required>
            @error('payment_reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                <label class="form-label fw-semibold">Upload receipt (optional)</label>
                <input type="file" name="receipt_file" class="form-control @error('receipt_file') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                @error('receipt_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted d-block">Attach Telebirr screenshot or stamped deposit slip.</small>
                @if($reservation->payment_receipt_path)
                    <a href="{{ route('reservations.receipt', $reservation) }}" target="_blank" class="btn btn-outline-secondary btn-sm mt-2">
                        <i class="bi bi-eye me-1"></i> View current upload
                    </a>
                @endif
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Notes</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Add any helpful remarks">{{ old('notes') }}</textarea>
                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
                        </div>
                        <div class="mt-4 d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-upload"></i> Submit receipt
                            </button>
            <small class="text-muted text-center">You can visit any branch (Telebirr, CBE, or other banks) and upload the receipt here. Our team will verify it before confirming your booking.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

