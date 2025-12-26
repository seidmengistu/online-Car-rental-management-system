@extends('layouts.app')

@section('title', 'Rental Details')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('rentals.index') }}">Rentals</a>
<span class="separator">/</span>
<span class="current">Rental #{{ $rental->id }}</span>
@endsection

@push('styles')
<style>
    .rental-detail-page {
        padding-bottom: 3rem;
    }
    .rental-hero {
        background: linear-gradient(120deg, #0f172a 0%, #1d4ed8 40%, #2563eb 100%);
        color: white;
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: 0 30px 55px rgba(15,23,42,0.45);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .rental-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        top: -70px;
        right: -60px;
    }
    .rental-hero > * { position: relative; z-index: 2; }
    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.18);
        font-weight: 600;
    }
    .detail-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 25px 45px rgba(15,23,42,0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .detail-card .card-header {
        border-bottom: 1px solid #edf0f7;
        background: transparent;
    }
    .detail-card .card-body {
        flex: 1;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
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
    .note-card {
        border-radius: 1rem;
        padding: 1rem;
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
    .quick-actions-card .card-body {
        min-height: 220px;
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
        justify-content: center;
    }
</style>
@endpush

@section('content')
@php
    $statusMeta = [
        'active' => ['label' => 'Active rental', 'class' => 'bg-success-subtle text-success'],
        'returned' => ['label' => 'Returned', 'class' => 'bg-info-subtle text-info'],
        'overdue' => ['label' => 'Overdue', 'class' => 'bg-danger-subtle text-danger'],
    ][$rental->status] ?? ['label' => ucfirst($rental->status), 'class' => 'bg-secondary-subtle text-secondary'];

    $plannedDuration = $rental->start_date->diffInDays($rental->end_date) + 1;
@endphp
<div class="rental-detail-page container-fluid px-3 px-lg-4">
    <div class="rental-hero">
        <div class="d-flex flex-wrap align-items-center gap-4">
            <div>
                <span class="status-chip {{ $statusMeta['class'] }}">
                    <i class="bi bi-circle-fill" style="font-size: 0.6rem;"></i>
                    {{ $statusMeta['label'] }}
                </span>
                <h2 class="mt-2 mb-1">Rental #{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</h2>
                <p class="mb-0 text-white-75">{{ $rental->car->full_name }} · {{ $plannedDuration }}-day itinerary</p>
            </div>
            <div class="ms-auto text-end">
                <small class="text-uppercase text-white-50">Final amount</small>
                <h2 class="mb-0">Br {{ number_format($rental->calculateFinalAmount(), 2) }}</h2>
                @if($rental->additional_charges > 0)
                    <small class="text-warning">Includes Br {{ number_format($rental->additional_charges, 2) }} additional</small>
                @endif
                @if($rental->status === 'active')
                    <div class="mt-3">
                        <a href="{{ route('rentals.return.form', $rental) }}" class="btn btn-light text-primary fw-semibold">
                            <i class="bi bi-box-arrow-in-left me-1"></i>Start return
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8 d-flex flex-column gap-4">
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="info-grid mb-3">
                        <div class="info-chip">
                            <span>scheduled start</span>
                            <strong>{{ $rental->start_date->format('M d, Y') }}</strong>
                            <small class="text-muted">{{ $rental->start_date->format('l') }}</small>
                        </div>
                        <div class="info-chip">
                            <span>scheduled return</span>
                            <strong>{{ $rental->end_date->format('M d, Y') }}</strong>
                            <small class="text-muted">{{ $plannedDuration }} days</small>
                                </div>
                                                @if($rental->actual_start_date)
                        <div class="info-chip">
                            <span>actual start</span>
                            <strong>{{ $rental->actual_start_date->format('M d, Y H:i') }}</strong>
                        </div>
                                                @endif
                                                @if($rental->actual_end_date)
                        <div class="info-chip">
                            <span>actual return</span>
                            <strong>{{ $rental->actual_end_date->format('M d, Y H:i') }}</strong>
                        </div>
                                                @endif
                    </div>
                    <div class="info-grid">
                        <div class="info-chip">
                            <span>pickup location</span>
                            <strong>{{ $rental->pickup_location }}</strong>
                        </div>
                        <div class="info-chip">
                            <span>return location</span>
                            <strong>{{ $rental->return_location }}</strong>
                        </div>
                        <div class="info-chip">
                            <span>deposit</span>
                            <strong>Br {{ number_format($rental->deposit_amount ?? 0, 2) }}</strong>
                        </div>
                        <div class="info-chip">
                            <span>driver</span>
                            <strong>{{ $rental->requires_driver ? 'Provided' : 'Self drive' }}</strong>
                            <small class="text-muted">{{ $rental->requires_driver ? 'Professional driver assigned' : 'No driver requested' }}</small>
                        </div>
                                        </div>
                                        </div>
                                    </div>

            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Financial summary</h5>
                </div>
                <div class="card-body">
                    <div class="info-grid mb-3">
                        <div class="info-chip">
                            <span>base amount</span>
                            <strong>Br {{ number_format($rental->total_amount, 2) }}</strong>
                        </div>
                        <div class="info-chip">
                            <span>additional charges</span>
                            <strong class="{{ $rental->additional_charges > 0 ? 'text-warning' : 'text-muted' }}">
                                {{ $rental->additional_charges > 0 ? 'Br '.number_format($rental->additional_charges, 2) : 'Br 0.00' }}
                            </strong>
                        </div>
                        <div class="info-chip">
                            <span>final amount</span>
                            <strong class="text-success">Br {{ number_format($rental->calculateFinalAmount(), 2) }}</strong>
                                            </div>
                                        </div>
                    @if($rental->notes)
                        <div class="note-card bg-info-subtle text-info mb-2">
                            <strong><i class="bi bi-sticky me-2"></i>Notes:</strong>
                            <p class="mb-0">{{ $rental->notes }}</p>
                                    </div>
                                    @endif
                                    @if($rental->return_notes)
                        <div class="note-card bg-warning-subtle text-warning mb-2">
                            <strong><i class="bi bi-clipboard-check me-2"></i>Return notes:</strong>
                                                <p class="mb-0">{{ $rental->return_notes }}</p>
                                    </div>
                                    @endif
                                    @if($rental->damage_report)
                        <div class="note-card bg-danger-subtle text-danger">
                            <strong><i class="bi bi-exclamation-triangle me-2"></i>Damage report:</strong>
                                                <p class="mb-0">{{ $rental->damage_report }}</p>
                                            </div>
                    @endif
                                        </div>
                                    </div>
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Return & overdue status</h5>
                </div>
                <div class="card-body">
                    @if($rental->status === 'active')
                        <div class="alert alert-warning mb-0">
                            Vehicle not yet returned. Please <a href="{{ route('rentals.return.form', $rental) }}">submit your return</a> when ready.
                        </div>
                    @else
                        <div class="info-grid mb-3">
                            <div class="info-chip">
                                <span>Actual return</span>
                                <strong>{{ $rental->actual_end_date ? $rental->actual_end_date->format('M d, Y H:i') : '—' }}</strong>
                            </div>
                            <div class="info-chip">
                                <span>Overdue fee</span>
                                <strong class="{{ $rental->overdue_fee > 0 ? 'text-danger' : 'text-muted' }}">
                                    {{ $rental->overdue_fee > 0 ? 'ETB '.number_format($rental->overdue_fee, 2) : 'None' }}
                                </strong>
                            </div>
                            <div class="info-chip">
                                <span>Payment status</span>
                                <strong>{{ ucfirst($rental->overdue_payment_status) }}</strong>
                                @if($rental->overdue_paid_at)
                                    <small class="text-muted">Paid {{ $rental->overdue_paid_at->format('M d, Y H:i') }}</small>
                                    @endif
                            </div>
                        </div>
                        @if($rental->overdue_fee > 0)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Method:</strong> {{ $rental->overdue_payment_method ? ucfirst(str_replace('_',' ', $rental->overdue_payment_method)) : 'Chapa checkout' }}</p>
                                <p class="mb-1"><strong>Reference:</strong> {{ $rental->overdue_payment_reference ?? '—' }}</p>
                                @if($rental->overdue_payment_notes)
                                    <p class="mb-1 text-muted"><strong>Notes:</strong> {{ $rental->overdue_payment_notes }}</p>
                                @endif
                                </div>
                            <div class="d-flex flex-wrap gap-2">
                                @if($rental->overdue_payment_status === 'pending')
                                    <form method="POST" action="{{ route('rentals.overdue.checkout', $rental) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-credit-card me-1"></i>Pay overdue with Chapa
                                        </button>
                                    </form>
                                @endif
                                        </div>
                                    @endif
                    @endif
                                        </div>
                                        </div>
                                    </div>
        <div class="col-lg-4 d-flex flex-column gap-4">
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Vehicle</h5>
                                        </div>
                <div class="card-body">
                    <div class="vehicle-media">
                        @if($rental->car->image)
                            <img src="{{ asset('storage/' . $rental->car->image) }}" alt="{{ $rental->car->full_name }}">
                        @else
                            <div class="text-white-50">
                                <i class="bi bi-car-front-fill" style="font-size: 3rem;"></i>
                                <p class="mt-2 mb-0">Image unavailable</p>
                                        </div>
                        @endif
                                    </div>
                    <h5>{{ $rental->car->full_name }}</h5>
                    <p class="text-muted mb-3">Plate {{ $rental->car->plate_number }}</p>
                    <div class="info-grid">
                        <div class="info-chip">
                            <span>color</span>
                            <strong>{{ $rental->car->color }}</strong>
                                    </div>
                        <div class="info-chip">
                            <span>seats</span>
                            <strong>{{ $rental->car->seats }}</strong>
                                </div>
                        <div class="info-chip">
                            <span>fuel</span>
                            <strong>{{ ucfirst($rental->car->fuel_type) }}</strong>
                            </div>
                        <div class="info-chip">
                            <span>transmission</span>
                            <strong>{{ ucfirst($rental->car->transmission) }}</strong>
                        </div>
                    </div>
                    <div class="alert alert-primary mt-3 mb-0">
                        <strong>Daily rate:</strong> Br {{ number_format($rental->car->daily_rate, 2) }}
                                    </div>
                                </div>
                            </div>

            <div class="card detail-card quick-actions-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick actions</h5>
                        </div>
                <div class="card-body">
                    <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left me-2"></i>Back to rentals
                    </a>
                    <a href="{{ route('cars.show', $rental->car) }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-car-front me-2"></i>View car details
                    </a>
                    <a href="{{ route('cars.index') }}" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Browse more cars
                    </a>
                    @if($rental->status === 'active')
                        <a href="{{ route('rentals.return.form', $rental) }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-box-arrow-in-left me-2"></i>Return this car
                        </a>
                    @endif
                    @if(optional($rental->reservation)->payment_receipt_path)
                        <a href="{{ route('reservations.receipt', $rental->reservation) }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-receipt me-2"></i>Download receipt
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 