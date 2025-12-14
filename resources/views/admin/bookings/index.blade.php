@extends('layouts.admin')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Booking Management')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Bookings</span>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
    <div>
        <h1 class="page-title">Booking Management</h1>
        <p class="page-subtitle">Manage all customer reservations and bookings</p>
    </div>
    <a href="{{ route('admin.rentals.create') }}" class="btn-modern btn-modern-primary">
        <i class="bi bi-plus-circle"></i> New Rental
    </a>
</div>

<!-- Filters Card -->
<div class="modern-card mb-4">
    <div class="modern-card-body">
        <form action="{{ route('admin.reservations.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label-modern">Search</label>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="form-control-modern" placeholder="Customer name, car, reference..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-modern">Status</label>
                    <select name="status" class="form-control-modern">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label-modern">Payment</label>
                    <select name="payment" class="form-control-modern">
                        <option value="">All</option>
                        <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('payment') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-modern-primary flex-grow-1">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('admin.reservations.index') }}" class="btn-modern btn-modern-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-calendar-check me-2"></i>
            All Bookings
        </h3>
        <span class="modern-badge modern-badge-primary">{{ $reservations->total() ?? 0 }} Total</span>
    </div>
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Booking</th>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Period</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations ?? [] as $reservation)
                <tr>
                    <td>
                        <div class="fw-semibold text-dark">#{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-muted small">{{ $reservation->created_at->format('M d, Y') }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="customer-avatar">
                                <span>{{ strtoupper(substr($reservation->user->name ?? 'N', 0, 2)) }}</span>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">{{ $reservation->user->name ?? 'N/A' }}</div>
                                <div class="text-muted small">{{ $reservation->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $reservation->car->full_name ?? 'N/A' }}</div>
                        <div class="text-muted small">{{ $reservation->car->plate_number ?? '' }}</div>
                    </td>
                    <td>
                        <div class="small">
                            <div class="text-muted">{{ $reservation->start_date->format('M d') }} - {{ $reservation->end_date->format('M d, Y') }}</div>
                            <div class="fw-semibold">{{ $reservation->start_date->diffInDays($reservation->end_date) + 1 }} days</div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">${{ number_format($reservation->total_amount, 2) }}</div>
                    </td>
                    <td>
                        <span class="modern-badge modern-badge-{{ 
                            $reservation->status == 'confirmed' ? 'success' : 
                            ($reservation->status == 'pending' ? 'warning' : 
                            ($reservation->status == 'cancelled' ? 'danger' : 'secondary')) 
                        }}">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </td>
                    <td>
                        @php
                            $paymentBadge = match ($reservation->payment_status) {
                                'paid' => ['text' => 'Paid', 'class' => 'success'],
                                'failed' => ['text' => 'Failed', 'class' => 'danger'],
                                default => ['text' => $reservation->payment_reference ? 'Awaiting' : 'Pending', 'class' => 'warning'],
                            };
                        @endphp
                        <span class="modern-badge modern-badge-{{ $paymentBadge['class'] }}">{{ $paymentBadge['text'] }}</span>
                        @if($reservation->payment_reference)
                            <div class="small text-muted mt-1">{{ Str::limit($reservation->payment_reference, 12) }}</div>
                        @endif
                        
                        @if($reservation->payment_reference && $reservation->payment_status !== 'paid')
                        <div class="d-flex gap-1 mt-2">
                            <a href="{{ route('reservations.receipt', $reservation) }}" target="_blank" class="btn-icon btn-icon-primary" style="width: 28px; height: 28px;" title="View Receipt">
                                <i class="bi bi-receipt" style="font-size: 12px;"></i>
                            </a>
                            <form action="{{ route('admin.reservations.payments.approve', $reservation) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-icon btn-icon-success" style="width: 28px; height: 28px;" title="Approve">
                                    <i class="bi bi-check" style="font-size: 14px;"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.reservations.payments.reset', $reservation) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-icon btn-icon-danger" style="width: 28px; height: 28px;" title="Reset">
                                    <i class="bi bi-arrow-counterclockwise" style="font-size: 12px;"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn-modern btn-modern-secondary btn-modern-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i> Actions
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                                @if($reservation->status == 'pending')
                                <li>
                                    <form action="{{ route('admin.reservations.update-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-check-circle text-success"></i> Confirm Booking
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.reservations.update-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-x-circle text-danger"></i> Cancel Booking
                                        </button>
                                    </form>
                                </li>
                                @endif
                                
                                @if($reservation->status == 'confirmed' && $reservation->canBeConvertedToRental())
                                <li>
                                    <form action="{{ route('admin.reservations.convert-to-rental', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-key text-primary"></i> Convert to Rental
                                        </button>
                                    </form>
                                </li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                
                                <li>
                                    <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-trash"></i> Delete Booking
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-calendar-x"></i>
                            </div>
                            <h5 class="empty-state-title">No bookings found</h5>
                            <p class="empty-state-text">Bookings will appear here when customers make reservations.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($reservations) && $reservations->hasPages())
    <div class="modern-card-footer">
        <div class="d-flex justify-content-center">
            {{ $reservations->links() }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 13px;
    }
</style>
@endpush
@endsection
