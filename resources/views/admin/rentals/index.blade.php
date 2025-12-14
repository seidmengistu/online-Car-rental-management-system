@extends('layouts.admin')

@section('title', 'Rental Management')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Rentals</span>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
    <div>
        <h1 class="page-title">Rental Management</h1>
        <p class="page-subtitle">Monitor active, returned, and overdue rentals</p>
    </div>
    <a href="{{ route('admin.rentals.create') }}" class="btn-modern btn-modern-success">
        <i class="bi bi-plus-circle"></i> Create Rental
    </a>
</div>

<!-- Filters Card -->
<div class="modern-card mb-4">
    <div class="modern-card-body">
        <form action="{{ route('admin.rentals.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label-modern">Search</label>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="form-control-modern" placeholder="Car, customer name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-modern">Status</label>
                    <select name="status" class="form-control-modern">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn-modern btn-modern-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.rentals.index') }}" class="btn-modern btn-modern-secondary w-100">
                        <i class="bi bi-x-lg"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Rentals Table -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-key me-2"></i>
            All Rentals
        </h3>
        <span class="modern-badge modern-badge-success">{{ $rentals->total() ?? 0 }} Total</span>
    </div>
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Rental ID</th>
                    <th>Vehicle</th>
                    <th>Customer</th>
                    <th>Period</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $rental)
                @php
                    $statusBadge = match ($rental->status) {
                        'active' => 'success',
                        'returned' => 'primary',
                        'overdue' => 'danger',
                        default => 'secondary',
                    };
                    $paymentStatus = optional($rental->reservation)->payment_status ?? 'paid';
                    $customerProvidedProof = $rental->overdue_payment_reference || $rental->overdue_receipt_path;
                @endphp
                <tr>
                    <td>
                        <div class="fw-semibold text-dark">#{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</div>
                        @if($rental->reservation)
                            <div class="text-muted small">Res #{{ $rental->reservation->id }}</div>
                        @else
                            <div class="text-muted small">Manual rental</div>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="car-icon-box">
                                <i class="bi bi-car-front"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">{{ $rental->car->full_name ?? 'N/A' }}</div>
                                <div class="text-muted small">{{ $rental->car->plate_number ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $rental->user->name ?? 'N/A' }}</div>
                        <div class="text-muted small">{{ $rental->user->email ?? '' }}</div>
                    </td>
                    <td>
                        <div class="small">
                            <div class="text-muted">{{ $rental->start_date->format('M d') }} - {{ $rental->end_date->format('M d, Y') }}</div>
                            <div class="fw-semibold">{{ $rental->start_date->diffInDays($rental->end_date) + 1 }} days</div>
                        </div>
                    </td>
                    <td>
                        <span class="modern-badge modern-badge-{{ $statusBadge }}">
                            {{ ucfirst($rental->status) }}
                        </span>
                        @if($rental->isOverdue())
                            <div class="mt-1">
                                <span class="modern-badge modern-badge-danger" style="background: rgba(239, 68, 68, 0.08); font-size: 11px;">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $rental->overdue_days }} days overdue
                                </span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="modern-badge modern-badge-{{ $paymentStatus === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($paymentStatus) }}
                        </span>
                        @if(optional($rental->reservation)->payment_reference)
                            <div class="small text-muted mt-1">
                                Ref: {{ \Illuminate\Support\Str::limit($rental->reservation->payment_reference, 12) }}
                            </div>
                        @endif
                        
                        @if($rental->overdue_fee > 0)
                        <div class="mt-2 p-2 rounded" style="background: #fef3c7;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small">
                                    <strong>Overdue:</strong> ETB {{ number_format($rental->overdue_fee, 2) }}
                                </div>
                                <span class="modern-badge modern-badge-{{ $rental->overdue_payment_status === 'paid' ? 'success' : 'warning' }}" style="font-size: 10px;">
                                    {{ ucfirst($rental->overdue_payment_status) }}
                                </span>
                            </div>
                            @if($rental->overdue_receipt_path)
                                <a href="{{ asset('storage/' . $rental->overdue_receipt_path) }}" target="_blank" class="btn-icon btn-icon-primary mt-1" style="width: 24px; height: 24px;" title="View Receipt">
                                    <i class="bi bi-file-earmark-arrow-down" style="font-size: 11px;"></i>
                                </a>
                            @endif
                            @if($rental->overdue_payment_status === 'pending' && !$customerProvidedProof)
                                <form action="{{ route('admin.rentals.overdue.pay', $rental) }}" method="POST" class="mt-2" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <select name="overdue_payment_method" class="form-control-modern mb-2" style="padding: 6px 10px; font-size: 12px;" required>
                                        <option value="cash">Cash</option>
                                        <option value="telebirr">Telebirr</option>
                                        <option value="cbe">CBE</option>
                                        <option value="bank">Bank</option>
                                    </select>
                                    <input type="text" name="overdue_payment_reference" class="form-control-modern mb-2" style="padding: 6px 10px; font-size: 12px;" placeholder="Reference #" required>
                                    <button type="submit" class="btn-modern btn-modern-success btn-modern-sm w-100" style="padding: 4px 8px; font-size: 11px;">
                                        <i class="bi bi-check2-circle"></i> Mark Paid
                                    </button>
                                </form>
                            @elseif($rental->overdue_payment_status === 'pending')
                                <div class="alert alert-info mb-0 py-1 px-2 mt-2" style="font-size: 11px;">
                                    Customer uploaded proof. Review & approve return.
                                </div>
                            @endif
                        </div>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('rentals.show', $rental) }}" class="btn-modern btn-modern-primary btn-modern-sm">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-key"></i>
                            </div>
                            <h5 class="empty-state-title">No rentals found</h5>
                            <p class="empty-state-text">Rentals will appear here when bookings are converted.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rentals->hasPages())
    <div class="modern-card-footer">
        <div class="d-flex justify-content-center">
            {{ $rentals->links() }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .car-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }
</style>
@endpush
@endsection
