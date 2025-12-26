@extends('layouts.app')

@section('title', 'Reservation Details')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('reservations.index') }}">Reservations</a>
<span class="separator">/</span>
<span class="current">Reservation #{{ $reservation->id }}</span>
@endsection

@push('styles')
<style>
    .reservation-hero {
        background: linear-gradient(120deg, #0f172a 0%, #1d4ed8 40%, #2563eb 100%);
        color: white;
        border-radius: 1.25rem;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 55px rgba(15,23,42,0.45);
    }
    .reservation-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        top: -70px;
        right: -60px;
    }
    .reservation-hero > * { position: relative; z-index: 2; }
    .status-chip, .payment-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.18);
        font-weight: 600;
    }
    .detail-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 25px 45px rgba(15,23,42,0.08);
        height: 100%;
    }
    .detail-card .card-header {
        border-bottom: 1px solid #edf0f7;
        background: transparent;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }
    .info-chip {
        border: 1px solid #edf0f7;
        border-radius: 0.9rem;
        padding: 1rem;
        background: #f8fafc;
    }
    .info-chip span {
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.75rem;
        color: #94a3b8;
        margin-bottom: 0.35rem;
    }
    .info-chip strong {
        color: #0f172a;
        font-size: 1rem;
    }
    .vehicle-media {
        background: #0f172a;
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    .vehicle-media img {
        width: 100%;
        max-height: 220px;
        object-fit: contain;
        border-radius: 0.75rem;
    }
    .actions-card .btn {
        min-width: 180px;
    }
</style>
@endpush

@section('content')
@php
    $statusMeta = [
        'pending' => ['label' => 'Pending', 'class' => 'status-pending'],
        'confirmed' => ['label' => 'Confirmed', 'class' => 'status-confirmed'],
        'cancelled' => ['label' => 'Cancelled', 'class' => 'status-cancelled'],
        'completed' => ['label' => 'Completed', 'class' => 'status-completed'],
    ][$reservation->status] ?? ['label' => ucfirst($reservation->status), 'class' => 'status-default'];

    $paymentMeta = [
        'paid' => ['label' => 'Paid', 'class' => 'bg-success-subtle text-success'],
        'pending' => ['label' => 'Payment pending', 'class' => 'bg-warning-subtle text-warning'],
        'failed' => ['label' => 'Payment failed', 'class' => 'bg-danger-subtle text-danger'],
        'refunded' => ['label' => 'Refunded', 'class' => 'bg-info-subtle text-info'],
    ][$reservation->payment_status] ?? ['label' => ucfirst($reservation->payment_status), 'class' => 'bg-secondary-subtle text-secondary'];

    $tripDays = $reservation->start_date->diffInDays($reservation->end_date) + 1;
@endphp
<div class="container-fluid px-3 px-lg-4">
    <div class="reservation-hero">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="status-chip">
                        <i class="bi bi-circle-fill" style="font-size: 0.6rem;"></i>{{ $statusMeta['label'] }}
                    </span>
                    <span class="payment-chip {{ $paymentMeta['class'] }}">{{ $paymentMeta['label'] }}</span>
                </div>
                <h1 class="mt-3 mb-1">{{ $reservation->car->full_name }}</h1>
                <p class="mb-0 text-white-75">{{ $reservation->car->plate_number }} · {{ $tripDays }} day trip</p>
            </div>
            <div class="ms-auto text-end">
                <small class="text-uppercase text-white-50">Total amount</small>
                <h2 class="mb-0">${{ number_format($reservation->total_amount, 2) }}</h2>
                <small class="text-white-50">Created {{ $reservation->created_at->format('M d, Y H:i') }}</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8 d-flex flex-column gap-4">
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Reservation overview</h5>
                </div>
                <div class="card-body">
                    <div class="info-grid mb-3">
                        <div class="info-chip">
                            <span>Reservation ID</span>
                            <strong>#{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</strong>
                            <small class="text-muted">{{ ucfirst($reservation->status) }}</small>
                                </div>
                        <div class="info-chip">
                            <span>Driver requested</span>
                            <strong>{{ $reservation->requires_driver ? 'Yes' : 'No' }}</strong>
                            <small class="text-muted">{{ $reservation->requires_driver ? 'We will assign a professional driver' : 'Self drive' }}</small>
                                        </div>
                        <div class="info-chip">
                            <span>Payment reference</span>
                            <strong>{{ $reservation->payment_reference ?? '—' }}</strong>
                            <small class="text-muted">{{ strtoupper($reservation->payment_status) }}</small>
                                        </div>
                                    </div>
                    <div class="info-grid">
                        <div class="info-chip">
                            <span>Start date</span>
                            <strong>{{ $reservation->start_date->format('M d, Y') }}</strong>
                            <small class="text-muted">{{ $reservation->start_date->format('l') }}</small>
                        </div>
                        <div class="info-chip">
                            <span>End date</span>
                            <strong>{{ $reservation->end_date->format('M d, Y') }}</strong>
                            <small class="text-muted">{{ $tripDays }} days</small>
                        </div>
                        <div class="info-chip">
                            <span>Pickup location</span>
                            <strong>{{ $reservation->pickup_location }}</strong>
                            <small class="text-muted">Return: {{ $reservation->return_location }}</small>
                                            </div>
                                        </div>
                    @if($reservation->notes)
                        <div class="alert alert-info mt-4 mb-0">
                            <strong><i class="bi bi-sticky me-2"></i>Notes:</strong>
                            <p class="mb-0">{{ $reservation->notes }}</p>
                                    </div>
                                    @endif
                            </div>
                        </div>

            <div class="card detail-card actions-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Actions</h5>
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                                </div>
                <div class="card-body d-flex flex-wrap gap-2">
                    <a href="{{ route('cars.show', $reservation->car) }}" class="btn btn-outline-primary">
                        <i class="bi bi-car-front me-1"></i>Vehicle details
                    </a>
                    <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-search me-1"></i>Browse cars
                    </a>
                    @if($reservation->canBeCancelled())
                        <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i>Cancel reservation
                            </button>
                        </form>
                                    @endif
                                        </div>
                                        </div>
                                    </div>
        <div class="col-lg-4 d-flex flex-column gap-4">
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payment</h5>
                                        </div>
                <div class="card-body d-flex flex-column gap-3">
                    <p class="text-muted mb-0">
                        Pay securely through Chapa. You'll be redirected to complete checkout and we'll confirm automatically once the payment succeeds.
                    </p>
                    <div class="info-chip">
                        <span>Amount</span>
                        <strong>ETB {{ number_format($reservation->total_amount, 2) }}</strong>
                        <small class="text-muted">{{ strtoupper($reservation->payment_status) }}</small>
                                        </div>
                    <div class="info-chip">
                        <span>Payment reference</span>
                        <strong>{{ $reservation->payment_reference ?? '—' }}</strong>
                        <small class="text-muted">{{ $reservation->payment_reference ? 'Chapa checkout ref' : 'Awaiting payment' }}</small>
                                    </div>
                    @if($reservation->payments->isNotEmpty())
                        @php $latestPayment = $reservation->payments->first(); @endphp
                        <div class="alert alert-secondary mb-0">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $latestPayment->provider }}</strong>
                                <small>{{ optional($latestPayment->created_at)->format('M d, Y H:i') }}</small>
                            </div>
                            <p class="mb-1 text-muted">Tx Ref: {{ $latestPayment->reference }}</p>
                        </div>
                    @endif
                    @if($reservation->payment_status === 'paid')
                        <a href="{{ route('reservations.receipt', $reservation) }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-receipt me-2"></i>Download verified receipt
                        </a>
                    @else
                        <a href="{{ route('reservations.payment', $reservation) }}" class="btn btn-primary w-100">
                            <i class="bi bi-credit-card me-2"></i>Pay with Chapa
                        </a>
                    @endif
                        </div>
                    </div>

            <div class="card detail-card">
                                <div class="card-header">
                    <h5 class="card-title mb-0">Vehicle</h5>
                                </div>
                                <div class="card-body">
                    <div class="vehicle-media">
                        @if($reservation->car->image)
                            <img src="{{ asset('storage/' . $reservation->car->image) }}" alt="{{ $reservation->car->full_name }}">
                        @else
                            <div class="text-white-50">
                                <i class="bi bi-car-front-fill" style="font-size: 3rem;"></i>
                                <p class="mt-2 mb-0">Image unavailable</p>
                            </div>
                        @endif
                    </div>
                    <h5>{{ $reservation->car->full_name }}</h5>
                    <p class="text-muted mb-3">Plate {{ $reservation->car->plate_number }}</p>
                    <div class="info-grid">
                        <div class="info-chip">
                            <span>Color</span>
                            <strong>{{ $reservation->car->color }}</strong>
                        </div>
                        <div class="info-chip">
                            <span>Seats</span>
                            <strong>{{ $reservation->car->seats }}</strong>
                        </div>
                        <div class="info-chip">
                            <span>Fuel</span>
                            <strong>{{ ucfirst($reservation->car->fuel_type) }}</strong>
                        </div>
                        <div class="info-chip">
                            <span>Transmission</span>
                            <strong>{{ ucfirst($reservation->car->transmission) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
