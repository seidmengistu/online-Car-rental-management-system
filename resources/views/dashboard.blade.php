@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Dashboard</span>
@endsection

@section('content')
<!-- Welcome Hero -->
<div class="welcome-hero mb-4">
    <div class="welcome-hero-content">
        <div class="welcome-badge">
            <i class="bi bi-speedometer2"></i>
            Personal Dashboard
        </div>
        <h1>Welcome back, {{ Auth::user()->name }}!</h1>
        <p>Track reservations, stay on top of rentals, and plan your next trip.</p>
    </div>
    <div class="welcome-hero-stats">
        <div class="hero-stat">
            <span class="hero-stat-label">Member Since</span>
            <span class="hero-stat-value">{{ Auth::user()->created_at->format('M d, Y') }}</span>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card primary">
            <div class="stat-card-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-card-value">{{ Auth::user()->reservations()->count() }}</div>
            <div class="stat-card-label">Total Reservations</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card success">
            <div class="stat-card-icon">
                <i class="bi bi-key"></i>
            </div>
            <div class="stat-card-value">{{ Auth::user()->rentals()->count() }}</div>
            <div class="stat-card-label">Total Rentals</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card warning">
            <div class="stat-card-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-card-value">{{ Auth::user()->reservations()->where('status', 'pending')->count() }}</div>
            <div class="stat-card-label">Pending Reservations</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card danger">
            <div class="stat-card-icon">
                <i class="bi bi-car-front"></i>
            </div>
            <div class="stat-card-value">{{ Auth::user()->rentals()->where('status', 'active')->count() }}</div>
            <div class="stat-card-label">Active Rentals</div>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="modern-card mb-4">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-lightning-charge me-2 text-warning"></i>
                    Quick Actions
                </h3>
            </div>
            <div class="modern-card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="action-card">
                            <div class="action-icon" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);">
                                <i class="bi bi-car-front-fill" style="color: #3b82f6;"></i>
                            </div>
                            <div class="action-content">
                                <h5>Browse Cars</h5>
                                <p>Discover vehicles by brand, size, and perks</p>
                                <a href="{{ route('cars.index') }}" class="btn-modern btn-modern-primary">
                                    <i class="bi bi-arrow-right"></i> Browse Now
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="action-card">
                            <div class="action-icon" style="background: rgba(16, 185, 129, 0.12);">
                                <i class="bi bi-calendar-plus" style="color: #10b981;"></i>
                            </div>
                            <div class="action-content">
                                <h5>Plan a Trip</h5>
                                <p>Reserve a vehicle for your upcoming travel</p>
                                <a href="{{ route('reservations.create') }}" class="btn-modern" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);">
                                    <i class="bi bi-plus-circle"></i> New Reservation
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="modern-card">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-grid me-2 text-primary"></i>
                    Manage Your Trips
                </h3>
            </div>
            <div class="modern-card-body">
                <div class="quick-links-grid">
                    <a href="{{ route('reservations.index') }}" class="quick-link-card">
                        <div class="quick-link-icon primary">
                            <i class="bi bi-calendar-week"></i>
                        </div>
                        <div class="quick-link-content">
                            <h6>My Reservations</h6>
                            <p>View and manage your bookings</p>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('rentals.index') }}" class="quick-link-card">
                        <div class="quick-link-icon success">
                            <i class="bi bi-key"></i>
                        </div>
                        <div class="quick-link-content">
                            <h6>My Rentals</h6>
                            <p>Track active and past rentals</p>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('profile') }}" class="quick-link-card">
                        <div class="quick-link-icon warning">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="quick-link-content">
                            <h6>My Profile</h6>
                            <p>Update your account information</p>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-clock-history me-2 text-info"></i>
                    Recent Activity
                </h3>
            </div>
            <div class="modern-card-body">
                @php
                    $recentReservations = Auth::user()->reservations()->latest()->take(5)->get();
                    $recentRentals = Auth::user()->rentals()->latest()->take(5)->get();
                    $recentItems = $recentReservations->concat($recentRentals)->sortByDesc('created_at')->take(6);
                @endphp
                
                @if($recentItems->count())
                    <div class="activity-list">
                        @foreach($recentItems as $item)
                        <div class="activity-item">
                            <div class="activity-icon {{ $item instanceof \App\Models\Reservation ? 'primary' : 'success' }}">
                                <i class="bi bi-{{ $item instanceof \App\Models\Reservation ? 'calendar-check' : 'key' }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">
                                    {{ $item instanceof \App\Models\Reservation ? 'Reservation' : 'Rental' }}
                                </div>
                                <div class="activity-description">
                                    {{ $item->car->full_name }}
                                </div>
                                <div class="activity-meta">
                                    {{ $item->start_date->format('M d') }} - {{ $item->end_date->format('M d, Y') }}
                                </div>
                            </div>
                            <div class="activity-time">
                                {{ $item->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-activity">
                        <div class="empty-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h6>No recent activity</h6>
                        <p>Your booking history will appear here</p>
                        <a href="{{ route('cars.index') }}" class="btn-modern btn-modern-primary btn-modern-sm">
                            Browse Cars
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .welcome-hero {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: 20px;
        padding: 32px;
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 24px;
    }

    .welcome-hero::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        top: -100px;
        right: -50px;
    }

    .welcome-hero-content {
        position: relative;
        z-index: 1;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .welcome-hero h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .welcome-hero p {
        font-size: 15px;
        opacity: 0.9;
        margin: 0;
    }

    .welcome-hero-stats {
        position: relative;
        z-index: 1;
    }

    .hero-stat {
        text-align: right;
    }

    .hero-stat-label {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        opacity: 0.8;
        margin-bottom: 4px;
    }

    .hero-stat-value {
        font-size: 20px;
        font-weight: 700;
    }

    .action-card {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding: 24px;
        background: #f8fafc;
        border-radius: 16px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .action-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .action-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .action-content h5 {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .action-content p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
    }

    .quick-links-grid {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .quick-link-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .quick-link-card:hover {
        background: var(--primary-gradient);
        color: white;
    }

    .quick-link-card:hover .quick-link-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .quick-link-card:hover .quick-link-content h6,
    .quick-link-card:hover .quick-link-content p {
        color: white;
    }

    .quick-link-card:hover .bi-chevron-right {
        color: white;
    }

    .quick-link-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .quick-link-icon.primary {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .quick-link-icon.success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .quick-link-icon.warning {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .quick-link-content {
        flex: 1;
    }

    .quick-link-content h6 {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .quick-link-content p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }

    .quick-link-card .bi-chevron-right {
        color: #94a3b8;
        font-size: 16px;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .activity-icon.primary {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .activity-icon.success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .activity-content {
        flex: 1;
        min-width: 0;
    }

    .activity-title {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
    }

    .activity-description {
        font-size: 12px;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .activity-meta {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .activity-time {
        font-size: 11px;
        color: #94a3b8;
        white-space: nowrap;
    }

    .empty-activity {
        text-align: center;
        padding: 32px 16px;
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #94a3b8;
        margin: 0 auto 16px;
    }

    .empty-activity h6 {
        font-size: 15px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 4px;
    }

    .empty-activity p {
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .btn-modern-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .welcome-hero {
            padding: 24px;
        }

        .welcome-hero h1 {
            font-size: 22px;
        }

        .action-card {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush
@endsection
