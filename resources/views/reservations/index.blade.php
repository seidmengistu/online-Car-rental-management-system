@extends('layouts.app')

@section('title', 'My Reservations')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">My Reservations</span>
@endsection

@push('styles')
<style>
    .reservations-page {
        padding-bottom: 3rem;
    }

    .page-hero {
        border: none;
        border-radius: 1.25rem;
        background: linear-gradient(120deg, #4c6ef5 0%, #7950f2 50%, #b197fc 100%);
        color: white;
        padding: 2.25rem;
        box-shadow: 0 25px 45px rgba(76, 110, 245, 0.35);
        margin-bottom: 2rem;
    }

    .page-hero h1 {
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .page-hero p {
        color: rgba(255,255,255,0.85);
        max-width: 640px;
    }

    .hero-actions .btn {
        border-radius: 999px;
        padding-inline: 1.5rem;
    }

    .stats-row .stat-card {
        border: none;
        border-radius: 1rem;
        background: white;
        padding: 1.25rem;
        box-shadow: 0 18px 40px rgba(15,23,42,0.07);
        height: 100%;
    }

    .stat-card span {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
    }

    .stat-card strong {
        display: block;
        margin-top: 0.35rem;
        font-size: 1.8rem;
        color: #1f2937;
    }

    .filter-panel {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 45px rgba(15, 23, 42, 0.06);
    }

    .filter-panel .card-body {
        padding: 1.5rem;
    }

    .reservation-grid {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .reservation-card {
        border: 1px solid #edf0f7;
        border-radius: 1.25rem;
        background: white;
        padding: 1.5rem;
        box-shadow: 0 20px 35px rgba(15,23,42,0.05);
    }

    .reservation-card__header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .status-pending { background: #fff3cd; color: #8a6d1d; }
    .status-confirmed { background: #d1f7c4; color: #1f7a2d; }
    .status-cancelled { background: #fde2e1; color: #b43429; }
    .status-completed { background: #d9f0ff; color: #1d4d8b; }
    .status-default { background: #e2e8f0; color: #475569; }

    .reservation-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-block {
        border: 1px solid #edf0f7;
        border-radius: 0.75rem;
        padding: 0.9rem;
        background: #f8fafc;
        min-height: 110px;
    }

    .info-block span {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
        margin-bottom: 0.35rem;
    }

    .info-block strong {
        display: block;
        color: #1f2937;
        font-size: 1rem;
    }

    .reservation-card__actions {
        border-top: 1px dashed #e2e8f0;
        padding-top: 1rem;
    }

    .reservation-card__actions .btn {
        border-radius: 0.75rem;
        font-weight: 600;
    }

    .empty-card {
        border: 2px dashed #e0e7ff;
        border-radius: 1rem;
        background: #f8faff;
        padding: 2.5rem;
        text-align: center;
    }
</style>
@endpush

@section('content')
@php
    $reservationsCollection = collect($reservations->items());
    $totalSpent = $reservationsCollection->sum('total_amount');
    $upcomingCount = $reservationsCollection->whereIn('status', ['pending','confirmed'])->count();
@endphp
<div class="reservations-page container-fluid px-3 px-md-4">
    <div class="page-hero">
        <div class="d-flex flex-wrap justify-content-between gap-3">
            <div>
                <h1>My Reservations</h1>
                <p>Track upcoming trips, review completed rides, or make changes before your journey begins.</p>
                <div class="hero-actions d-flex flex-wrap gap-2 mt-3">
                    <a href="{{ route('cars.index') }}" class="btn btn-light text-primary fw-semibold">
                        <i class="bi bi-car-front me-2"></i>Browse cars
                    </a>
                    <a href="{{ route('rentals.index') }}" class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-clock-history me-2"></i>View rentals
                        </a>
                    </div>
                </div>
            <div class="text-lg-end">
                <p class="mb-1 text-uppercase small text-white-50">Total spend this page</p>
                <h2 class="mb-0">Br {{ number_format($totalSpent, 2) }}</h2>
            </div>
        </div>
    </div>

    <div class="row g-3 stats-row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <span>Reservations shown</span>
                <strong>{{ $reservations->firstItem() }} - {{ $reservations->lastItem() }}</strong>
                <small class="text-muted">of {{ $reservations->total() }} total</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Upcoming</span>
                <strong>{{ $upcomingCount }}</strong>
                <small class="text-muted">Awaiting pickup or confirmation</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Average trip value</span>
                <strong>
                    {{ $reservationsCollection->count() ? 'Br '.number_format($totalSpent / max($reservationsCollection->count(),1), 2) : '—' }}
                </strong>
                <small class="text-muted">Based on visible results</small>
            </div>
        </div>
    </div>

    <div class="filter-panel card mb-4">
                <div class="card-body">
                            <form method="GET" action="{{ route('reservations.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label fw-semibold text-secondary">Filter by status</label>
                        <select class="form-select" name="status">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-funnel me-2"></i>Apply filter
                                        </button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary flex-fill">
                            Clear
                        </a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('reservations.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>New reservation
                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

    <div class="reservation-grid">
                                @forelse($reservations as $reservation)
            @php
                $statusMeta = [
                    'pending' => ['label' => 'Pending', 'class' => 'status-pending'],
                    'confirmed' => ['label' => 'Confirmed', 'class' => 'status-confirmed'],
                    'cancelled' => ['label' => 'Cancelled', 'class' => 'status-cancelled'],
                    'completed' => ['label' => 'Completed', 'class' => 'status-completed'],
                ][$reservation->status] ?? ['label' => ucfirst($reservation->status), 'class' => 'status-default'];
                $paymentMeta = match ($reservation->payment_status) {
                    'paid' => ['label' => 'Paid', 'class' => 'badge bg-success-subtle text-success'],
                    'failed' => ['label' => 'Payment failed', 'class' => 'badge bg-danger-subtle text-danger'],
                    'refunded' => ['label' => 'Refunded', 'class' => 'badge bg-info-subtle text-info'],
                    default => ['label' => $reservation->payment_reference ? 'Awaiting verification' : 'Payment pending', 'class' => $reservation->payment_reference ? 'badge bg-warning-subtle text-warning' : 'badge bg-secondary-subtle text-secondary'],
                };
                $tripDays = $reservation->start_date->diffInDays($reservation->end_date) + 1;
            @endphp
            <div class="reservation-card">
                <div class="reservation-card__header">
                                        <div>
                        <span class="status-pill {{ $statusMeta['class'] }}">
                            <i class="bi bi-circle-fill" style="font-size: 0.6rem;"></i>{{ $statusMeta['label'] }}
                        </span>
                        <h5 class="mt-2 mb-1">{{ $reservation->car->full_name }}</h5>
                        <p class="text-muted mb-0">{{ $reservation->car->plate_number }}</p>
                    </div>
                    <div class="text-lg-end">
                        <span class="{{ $paymentMeta['class'] }}">{{ $paymentMeta['label'] }}</span>
                        <small class="text-uppercase text-muted">Total amount</small>
                        <h4 class="mb-0 text-success">Br {{ number_format($reservation->total_amount, 2) }}</h4>
                        <small class="text-muted">Booked {{ $reservation->created_at->format('M d, Y H:i') }}</small>
                    </div>
                </div>
                <div class="reservation-info-grid">
                    <div class="info-block">
                        <span>Trip dates</span>
                        <strong>{{ $reservation->start_date->format('M d, Y') }}</strong>
                        <small class="text-muted">to {{ $reservation->end_date->format('M d, Y') }} · {{ $tripDays }} days</small>
                    </div>
                    <div class="info-block">
                        <span>Pickup location</span>
                        <strong>{{ $reservation->pickup_location }}</strong>
                        <small class="text-muted">Return: {{ $reservation->return_location }}</small>
                    </div>
                    <div class="info-block">
                        <span>Payment reference</span>
                        <strong>
                            @if($reservation->payment_reference)
                                #{{ strtoupper(\Illuminate\Support\Str::limit($reservation->payment_reference, 10, '')) }}
                            @else
                                —
                            @endif
                        </strong>
                        <small class="text-muted">Reservation ID {{ $reservation->id }}</small>
                                        </div>
                    <div class="info-block">
                        <span>Driver requested</span>
                        <strong>{{ $reservation->requires_driver ? 'Yes' : 'No' }}</strong>
                        <small class="text-muted">{{ $reservation->requires_driver ? 'We will assign a driver' : 'Self driving' }}</small>
                                        </div>
                                        </div>
                <div class="reservation-card__actions d-flex flex-wrap gap-2">
                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-1"></i>View details
                    </a>
                    @if($reservation->payment_status !== 'paid')
                        <a href="{{ route('reservations.payment', $reservation) }}" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i>Upload receipt
                        </a>
                    @else
                        <a href="{{ route('reservations.receipt', $reservation) }}" class="btn btn-outline-success">
                            <i class="bi bi-receipt me-1"></i>Receipt
                                            </a>
                    @endif
                                            @if($reservation->canBeCancelled())
                                                <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" 
                                                      onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                                    @csrf
                                                    @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i>Cancel reservation
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
            </div>
                                @empty
            <div class="empty-card">
                <i class="bi bi-calendar-x display-5 text-primary mb-3"></i>
                <h5>No reservations yet</h5>
                <p class="text-muted mb-3">Start by choosing a car that fits your trip and create your first reservation.</p>
                <a href="{{ route('cars.index') }}" class="btn btn-primary">
                    <i class="bi bi-car-front me-2"></i>Browse available cars
                                            </a>
                                        </div>
                                @endforelse
                    </div>

    <div class="d-flex justify-content-center mt-4">
                        {{ $reservations->links() }}
    </div>
</div>
@endsection 