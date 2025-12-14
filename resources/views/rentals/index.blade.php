@extends('layouts.app')

@section('title', 'My Rentals')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">My Rentals</span>
@endsection

@push('styles')
<style>
    .rentals-page {
        padding-bottom: 3rem;
    }

    .rentals-hero {
        border: none;
        border-radius: 1.25rem;
        background: linear-gradient(120deg, #0f172a 0%, #1e293b 45%, #312e81 100%);
        color: white;
        padding: 2.25rem;
        margin-bottom: 2rem;
        box-shadow: 0 30px 55px rgba(15,23,42,0.45);
    }

    .rentals-hero h1 {
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .rentals-hero p {
        color: rgba(255,255,255,0.8);
        max-width: 620px;
    }

    .rentals-stats .stat-card {
        border: none;
        border-radius: 1rem;
        background: white;
        padding: 1.2rem;
        box-shadow: 0 18px 40px rgba(15,23,42,0.07);
        height: 100%;
    }

    .stat-card span {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
    }

    .stat-card strong {
        display: block;
        margin-top: 0.35rem;
        font-size: 1.8rem;
        color: #0f172a;
    }

    .filter-panel {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 45px rgba(15, 23, 42, 0.06);
    }

    .filter-panel .card-body {
        padding: 1.5rem;
    }

    .rental-grid {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .rental-card {
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        background: white;
        padding: 1.5rem;
        box-shadow: 0 25px 45px rgba(15,23,42,0.05);
    }

    .rental-card__header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .rental-card__status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .status-active { background: #d1f7c4; color: #1f7a2d; }
    .status-returned { background: #d9f0ff; color: #1d4d8b; }
    .status-overdue { background: #fde2e1; color: #b43429; }
    .status-default { background: #e2e8f0; color: #475569; }

    .rental-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-block {
        border: 1px solid #edf0f7;
        border-radius: 0.9rem;
        padding: 1rem;
        background: #f8fafc;
        min-height: 120px;
    }

    .info-block small {
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.72rem;
        color: #94a3b8;
        margin-bottom: 0.35rem;
    }

    .info-block strong {
        font-size: 1rem;
        color: #0f172a;
    }

    .rental-card__footer {
        border-top: 1px dashed #e2e8f0;
        padding-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: space-between;
        align-items: center;
    }

    .rental-card__footer .btn {
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
    $rentalsCollection = collect($rentals->items());
    $activeRentals = $rentalsCollection->where('status', 'active')->count();
    $overdueRentals = $rentalsCollection->where('status', 'overdue')->count();
    $totalRentalAmount = $rentalsCollection->sum('total_amount');
@endphp
<div class="rentals-page container-fluid px-3 px-md-4">
    <div class="rentals-hero">
        <div class="d-flex flex-wrap justify-content-between gap-3">
            <div>
                <h1>My Rentals</h1>
                <p>Monitor active trips, review historical rentals, and keep an eye on outstanding balances.</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a href="{{ route('reservations.index') }}" class="btn btn-light text-primary fw-semibold">
                        <i class="bi bi-calendar-week me-2"></i>Reservations
                    </a>
                    <a href="{{ route('cars.index') }}" class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-car-front me-2"></i>Find another car
                        </a>
                    </div>
                </div>
            <div class="text-lg-end">
                <p class="mb-1 text-uppercase small text-white-50">Value of trips shown</p>
                <h2 class="mb-0">${{ number_format($totalRentalAmount, 2) }}</h2>
            </div>
        </div>
    </div>

    <div class="row g-3 rentals-stats mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <span>Rentals shown</span>
                <strong>{{ $rentals->firstItem() }} - {{ $rentals->lastItem() }}</strong>
                <small class="text-muted">of {{ $rentals->total() }} total</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Active now</span>
                <strong>{{ $activeRentals }}</strong>
                <small class="text-muted">Currently in progress</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span>Overdue</span>
                <strong>{{ $overdueRentals }}</strong>
                <small class="text-muted">Needs your attention</small>
            </div>
        </div>
    </div>

    <div class="filter-panel card mb-4">
                <div class="card-body">
                            <form method="GET" action="{{ route('rentals.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label fw-semibold text-secondary">Filter by status</label>
                        <select class="form-select" name="status">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-funnel me-2"></i>Apply filter
                                        </button>
                        <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary flex-fill">
                            Clear
                        </a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('cars.index') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>Start new rental
                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

    <div class="rental-grid">
                                @forelse($rentals as $rental)
            @php
                $statusMeta = [
                    'active' => ['label' => 'Active', 'class' => 'status-active'],
                    'returned' => ['label' => 'Returned', 'class' => 'status-returned'],
                    'overdue' => ['label' => 'Overdue', 'class' => 'status-overdue'],
                ][$rental->status] ?? ['label' => ucfirst($rental->status), 'class' => 'status-default'];
                $tripDays = $rental->start_date->diffInDays($rental->end_date) + 1;
            @endphp
            <div class="rental-card">
                <div class="rental-card__header">
                                        <div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="rental-card__status {{ $statusMeta['class'] }}">
                                <i class="bi bi-circle-fill" style="font-size: 0.6rem;"></i>{{ $statusMeta['label'] }}
                            </span>
                            @if($rental->requires_driver)
                                <span class="badge bg-primary-subtle text-primary">
                                    <i class="bi bi-person-wheelchair"></i> Driver included
                                </span>
                            @endif
                        </div>
                        <h5 class="mt-2 mb-1">{{ $rental->car->full_name }}</h5>
                        <p class="text-muted mb-0">{{ $rental->car->plate_number }}</p>
                    </div>
                    <div class="text-lg-end">
                        <small class="text-uppercase text-muted">Total amount</small>
                        <h4 class="mb-0 text-success">${{ number_format($rental->total_amount, 2) }}</h4>
                        @if($rental->additional_charges > 0)
                            <small class="text-warning">+${{ number_format($rental->additional_charges, 2) }} charges</small>
                        @endif
                    </div>
                                        </div>
                <div class="rental-info-grid">
                    <div class="info-block">
                        <small>Rental period</small>
                        <strong>{{ $rental->start_date->format('M d, Y') }}</strong>
                        <span class="text-muted">to {{ $rental->end_date->format('M d, Y') }} · {{ $tripDays }} days</span>
                                            @if($rental->isOverdue())
                            <span class="badge bg-danger-subtle text-danger mt-2">Overdue by {{ $rental->overdue_days }} days</span>
                                            @endif
                                        </div>
                    <div class="info-block">
                        <small>Locations</small>
                        <strong>{{ $rental->pickup_location }}</strong>
                        <span class="text-muted">Return: {{ $rental->return_location }}</span>
                    </div>
                    <div class="info-block">
                        <small>Reference</small>
                        <strong>#{{ strtoupper(\Illuminate\Support\Str::limit(optional($rental->reservation)->payment_reference ?? $rental->id, 8, '')) }}</strong>
                        <span class="text-muted">Rental ID {{ $rental->id }}</span>
                    </div>
                    <div class="info-block">
                        <small>Driver</small>
                        <strong>{{ $rental->requires_driver ? 'Provided' : 'Self drive' }}</strong>
                        <span class="text-muted">{{ $rental->requires_driver ? 'Professional driver assigned' : 'No driver requested' }}</span>
                    </div>
                                        </div>
                @if($rental->overdue_fee > 0)
                    <div class="alert {{ $rental->overdue_payment_status === 'paid' ? 'alert-success' : 'alert-warning' }} mt-2 mb-0">
                        <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <div>
                                <strong>Overdue fee:</strong> ETB {{ number_format($rental->overdue_fee, 2) }}
                                <div class="small text-muted">Status: {{ ucfirst($rental->overdue_payment_status) }}</div>
                                @if($rental->overdue_payment_status === 'paid' && $rental->overdue_paid_at)
                                    <div class="small text-muted">Paid on {{ $rental->overdue_paid_at->format('M d, Y H:i') }}</div>
                                            @endif
                                        </div>
                            @if($rental->overdue_payment_status === 'pending')
                                <a href="{{ route('rentals.return.form', $rental) }}" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-upload me-1"></i>Update receipt
                                            </a>
                            @endif
                                        </div>
                                        </div>
                @endif
                <div class="rental-card__footer">
                    <div class="text-muted small">
                        Last updated {{ $rental->updated_at->format('M d, Y H:i') }}
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @if($rental->status === 'active')
                            <a href="{{ route('rentals.return.form', $rental) }}" class="btn btn-outline-success">
                                <i class="bi bi-box-arrow-in-left me-1"></i>Return car
                            </a>
                        @endif
                        <a href="{{ route('rentals.show', $rental) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye me-1"></i>View details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-card">
                <i class="bi bi-car-front display-5 text-primary mb-3"></i>
                <h5>No rentals yet</h5>
                <p class="text-muted mb-3">When you rent a car, you'll see its journey details here.</p>
                <a href="{{ route('cars.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Browse cars
                </a>
            </div>
        @endforelse
        </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $rentals->links() }}
    </div>
</div>
@endsection 