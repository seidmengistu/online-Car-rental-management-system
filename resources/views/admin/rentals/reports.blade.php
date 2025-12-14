@extends('layouts.admin')

@section('title', 'Rental Reports')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('admin.rentals.index') }}">Rentals</a>
<span class="separator">/</span>
<span class="current">Reports</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Rental Reports</h1>
    <p class="page-subtitle">Detailed analytics and statistics for rental operations</p>
</div>

<!-- Filter Card -->
<div class="modern-card mb-4">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-funnel me-2"></i>
            Filter Reports
        </h3>
    </div>
    <div class="modern-card-body">
        <form method="GET" action="{{ route('admin.reports') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label-modern">Month</label>
                    <select name="month" class="form-control-modern">
                        <option value="all" {{ $month === 'all' ? 'selected' : '' }}>All Months</option>
                        @for($i = 0; $i < 12; $i++)
                            @php 
                                $monthValue = now()->startOfYear()->addMonths($i)->format('Y-m');
                                $monthLabel = now()->startOfYear()->addMonths($i)->format('F Y');
                            @endphp
                            <option value="{{ $monthValue }}" {{ $month === $monthValue ? 'selected' : '' }}>
                                {{ $monthLabel }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label-modern">Year</label>
                    <select name="year" class="form-control-modern">
                        @for($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn-modern btn-modern-primary w-100">
                        <i class="bi bi-filter"></i> Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Monthly Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card primary">
            <div class="stat-card-icon">
                <i class="bi bi-car-front"></i>
            </div>
            <div class="stat-card-value">{{ $monthlyStats->total_rentals ?? 0 }}</div>
            <div class="stat-card-label">Total Rentals</div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card success">
            <div class="stat-card-icon">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div class="stat-card-value">${{ number_format($monthlyStats->total_revenue ?? 0, 0) }}</div>
            <div class="stat-card-label">Total Revenue</div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card warning">
            <div class="stat-card-icon">
                <i class="bi bi-calculator"></i>
            </div>
            <div class="stat-card-value">${{ number_format($monthlyStats->avg_rental_amount ?? 0, 0) }}</div>
            <div class="stat-card-label">Average Rental Amount</div>
        </div>
    </div>
</div>

<!-- Status Breakdown -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="modern-card h-100">
            <div class="modern-card-body text-center py-4">
                <div class="status-icon" style="background: rgba(102, 126, 234, 0.12); color: #667eea;">
                    <i class="bi bi-car-front"></i>
                </div>
                <div class="status-value">{{ $monthlyStats->active_rentals ?? 0 }}</div>
                <div class="status-label">Active Rentals</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="modern-card h-100">
            <div class="modern-card-body text-center py-4">
                <div class="status-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="status-value">{{ $monthlyStats->completed_rentals ?? 0 }}</div>
                <div class="status-label">Completed Rentals</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="modern-card h-100">
            <div class="modern-card-body text-center py-4">
                <div class="status-icon" style="background: rgba(239, 68, 68, 0.12); color: #ef4444;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="status-value">{{ $monthlyStats->overdue_rentals ?? 0 }}</div>
                <div class="status-label">Overdue Rentals</div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div class="row g-4">
    <!-- Top Rented Cars -->
    <div class="col-lg-6">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-star me-2 text-warning"></i>
                    Top Rented Vehicles
                </h3>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Rentals</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCars as $car)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="car-icon-sm">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $car->car->full_name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="modern-badge modern-badge-primary">{{ $car->rental_count }}</span>
                            </td>
                            <td class="fw-semibold">${{ number_format($car->total_revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">
                                <div class="text-center text-muted py-4">No data available</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Rentals -->
    <div class="col-lg-6">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-clock-history me-2 text-info"></i>
                    Recent Rentals
                </h3>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRentals as $rental)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $rental->user->name ?? 'Unknown' }}</div>
                            </td>
                            <td>
                                <div class="text-muted small">{{ $rental->car->full_name ?? 'Unknown' }}</div>
                            </td>
                            <td>
                                <span class="modern-badge modern-badge-{{ $rental->status === 'active' ? 'success' : ($rental->status === 'overdue' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </td>
                            <td class="fw-semibold">${{ number_format($rental->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="text-center text-muted py-4">No recent rentals</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .status-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 16px;
    }

    .status-value {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .status-label {
        font-size: 14px;
        color: #6b7280;
    }

    .car-icon-sm {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
</style>
@endpush
@endsection
