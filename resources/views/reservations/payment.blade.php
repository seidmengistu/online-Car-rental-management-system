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
                                <h4 class="mb-0">ETB {{ number_format($reservation->total_amount, 2) }}</h4>
                                <small class="text-muted">Processed securely via Chapa</small>
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
                    @if($reservation->payment_reference && $reservation->payment_status === 'pending')
                        <div class="alert alert-info">
                            <strong>Pending payment:</strong> We found a previous attempt (Ref {{ $reservation->payment_reference }}). You can restart checkout below.
                        </div>
                    @endif
                    <form method="POST" action="{{ route('reservations.payment.process', $reservation) }}">
                        @csrf
                        <div class="mt-4 d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-credit-card"></i> Pay with Chapa
                            </button>
                            <small class="text-muted text-center">
                                You will be redirected to Chapa's secure checkout to complete your payment.
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

