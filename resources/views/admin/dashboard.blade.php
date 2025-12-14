@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Welcome back, {{ Auth::user()->name }}!</h1>
    <p class="page-subtitle">Here's what's happening with your car rental business today.</p>
</div>

<!-- Stats Overview -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card primary">
            <div class="stat-card-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-card-value">{{ $stats['total_customers'] ?? 0 }}</div>
            <div class="stat-card-label">Total Customers</div>
            <a href="{{ route('admin.users.index') }}?role=customer" class="stat-card-link">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card success">
            <div class="stat-card-icon">
                <i class="bi bi-person-check"></i>
            </div>
            <div class="stat-card-value">{{ $stats['active_users'] ?? 0 }}</div>
            <div class="stat-card-label">Active Users</div>
            <a href="{{ route('admin.users.index') }}" class="stat-card-link">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card warning">
            <div class="stat-card-icon">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-card-value">{{ $stats['total_staff'] ?? 0 }}</div>
            <div class="stat-card-label">Staff Members</div>
            <a href="{{ route('admin.users.index') }}?role=staff" class="stat-card-link">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card danger">
            <div class="stat-card-icon">
                <i class="bi bi-person-lock"></i>
            </div>
            <div class="stat-card-value">{{ $stats['total_managers'] ?? 0 }}</div>
            <div class="stat-card-label">Managers</div>
            <a href="{{ route('admin.users.index') }}?role=manager" class="stat-card-link">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="modern-card mb-4">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-lightning-charge me-2 text-warning"></i>
            Quick Actions
        </h3>
    </div>
    <div class="modern-card-body">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card">
                    <div class="quick-action-icon" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);">
                        <i class="bi bi-person-plus" style="color: #667eea;"></i>
                    </div>
                    <div class="quick-action-content">
                        <h5>Add New User</h5>
                        <p>Create customer or staff accounts</p>
                        <a href="{{ route('admin.users.create') }}" class="btn-modern btn-modern-primary btn-modern-sm">
                            <i class="bi bi-plus"></i> Create
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card">
                    <div class="quick-action-icon" style="background: rgba(16, 185, 129, 0.12);">
                        <i class="bi bi-car-front" style="color: #10b981;"></i>
                    </div>
                    <div class="quick-action-content">
                        <h5>Add New Vehicle</h5>
                        <p>Register a new car to fleet</p>
                        <a href="{{ route('admin.cars.create') }}" class="btn-modern btn-modern-success btn-modern-sm">
                            <i class="bi bi-plus"></i> Create
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card">
                    <div class="quick-action-icon" style="background: rgba(245, 158, 11, 0.12);">
                        <i class="bi bi-calendar-plus" style="color: #f59e0b;"></i>
                    </div>
                    <div class="quick-action-content">
                        <h5>New Booking</h5>
                        <p>Create a new rental booking</p>
                        <a href="{{ route('admin.rentals.create') }}" class="btn-modern btn-modern-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);">
                            <i class="bi bi-plus"></i> Create
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="quick-action-card">
                    <div class="quick-action-icon" style="background: rgba(239, 68, 68, 0.12);">
                        <i class="bi bi-graph-up" style="color: #ef4444;"></i>
                    </div>
                    <div class="quick-action-content">
                        <h5>View Reports</h5>
                        <p>Analytics and statistics</p>
                        <a href="{{ route('admin.reports') }}" class="btn-modern btn-modern-danger btn-modern-sm">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="modern-card">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-activity me-2 text-primary"></i>
                    System Overview
                </h3>
            </div>
            <div class="modern-card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="overview-item">
                            <div class="overview-icon primary">
                                <i class="bi bi-car-front-fill"></i>
                            </div>
                            <div class="overview-details">
                                <span class="overview-label">Total Vehicles</span>
                                <span class="overview-value">{{ $stats['total_cars'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="overview-item">
                            <div class="overview-icon success">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="overview-details">
                                <span class="overview-label">Active Bookings</span>
                                <span class="overview-value">{{ $stats['active_bookings'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="overview-item">
                            <div class="overview-icon warning">
                                <i class="bi bi-key-fill"></i>
                            </div>
                            <div class="overview-details">
                                <span class="overview-label">Ongoing Rentals</span>
                                <span class="overview-value">{{ $stats['active_rentals'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-clock-history me-2 text-info"></i>
                    Quick Links
                </h3>
            </div>
            <div class="modern-card-body">
                <div class="quick-links">
                    <a href="{{ route('admin.reservations.index') }}" class="quick-link-item">
                        <i class="bi bi-calendar3"></i>
                        <span>View All Bookings</span>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.rentals.index') }}" class="quick-link-item">
                        <i class="bi bi-key"></i>
                        <span>Manage Rentals</span>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.returns.index') }}" class="quick-link-item">
                        <i class="bi bi-box-arrow-in-left"></i>
                        <span>Process Returns</span>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.cars.index') }}" class="quick-link-item">
                        <i class="bi bi-car-front"></i>
                        <span>Fleet Management</span>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .quick-action-card {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 14px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .quick-action-card:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
    }

    .quick-action-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .quick-action-content h5 {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 6px;
    }

    .quick-action-content p {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 14px;
    }

    .overview-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 14px;
    }

    .overview-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .overview-icon.primary {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        color: #667eea;
    }

    .overview-icon.success {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
    }

    .overview-icon.warning {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
    }

    .overview-details {
        display: flex;
        flex-direction: column;
    }

    .overview-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .overview-value {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .quick-links {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .quick-link-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #f9fafb;
        border-radius: 10px;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .quick-link-item:hover {
        background: var(--primary-gradient);
        color: white;
    }

    .quick-link-item i:first-child {
        font-size: 18px;
        width: 24px;
    }
</style>
@endpush
@endsection
