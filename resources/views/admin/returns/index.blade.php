@extends('layouts.admin')

@section('title', 'Return Management')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Returns</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Return Management</h1>
    <p class="page-subtitle">Process and verify vehicle returns</p>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card warning">
            <div class="stat-card-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-card-value">{{ $stats['pending_verification'] }}</div>
            <div class="stat-card-label">Pending Verification</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card danger">
            <div class="stat-card-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-card-value">{{ $stats['pending_overdue'] }}</div>
            <div class="stat-card-label">Overdue Payments Pending</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card success">
            <div class="stat-card-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-card-value">{{ $stats['approved'] }}</div>
            <div class="stat-card-label">Approved Returns</div>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="modern-card mb-4">
    <div class="modern-card-body">
        <form class="row g-3" method="GET" action="{{ route('admin.returns.index') }}">
            <div class="col-md-4">
                <label class="form-label-modern">Search</label>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control-modern" placeholder="Customer, email, plate...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label-modern">Verification Status</label>
                <select name="verification" class="form-control-modern">
                    <option value="">All</option>
                    <option value="pending" {{ request('verification') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="approved" {{ request('verification') == 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label-modern">Overdue Payment</label>
                <select name="overdue_status" class="form-control-modern">
                    <option value="">All</option>
                    <option value="pending" {{ request('overdue_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('overdue_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="not_required" {{ request('overdue_status') == 'not_required' ? 'selected' : '' }}>Not Required</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn-modern btn-modern-primary flex-grow-1">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.returns.index') }}" class="btn-modern btn-modern-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Returns Table -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-box-arrow-in-left me-2"></i>
            Vehicle Returns
        </h3>
    </div>
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Rental</th>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Return Details</th>
                    <th>Overdue Fee</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $rental)
                @php
                    $customerProvidedProof = $rental->overdue_payment_reference || $rental->overdue_receipt_path;
                @endphp
                <tr>
                    <td>
                        <div class="fw-semibold text-dark">#{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-muted small">
                            {{ $rental->reservation ? 'Reservation #' . $rental->reservation->id : 'Manual rental' }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="customer-avatar">
                                <span>{{ strtoupper(substr($rental->user->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">{{ $rental->user->name }}</div>
                                <div class="text-muted small">{{ $rental->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $rental->car->full_name }}</div>
                        <div class="text-muted small">Plate: {{ $rental->car->plate_number }}</div>
                    </td>
                    <td>
                        <div class="small">
                            <div class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                Scheduled: {{ $rental->end_date->format('M d, Y') }}
                            </div>
                            <div class="fw-semibold mt-1">
                                <i class="bi bi-calendar-check me-1"></i>
                                Actual: {{ $rental->actual_end_date ? $rental->actual_end_date->format('M d, Y H:i') : '—' }}
                            </div>
                            <div class="mt-2">
                                @if($rental->return_verified_at)
                                    <span class="modern-badge modern-badge-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Verified {{ $rental->return_verified_at->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="modern-badge modern-badge-warning">
                                        <i class="bi bi-clock me-1"></i>
                                        Pending Verification
                                    </span>
                                @endif
                            </div>
                            @if($rental->return_verification_notes)
                                <div class="text-muted mt-1 small">Notes: {{ $rental->return_verification_notes }}</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="overdue-info">
                            <div class="fw-semibold" style="font-size: 18px;">ETB {{ number_format($rental->overdue_fee, 2) }}</div>
                            <span class="modern-badge modern-badge-{{ match($rental->overdue_payment_status){
                                'paid' => 'success',
                                'pending' => 'warning',
                                default => 'secondary'
                            } }}">
                                {{ ucfirst($rental->overdue_payment_status) }}
                            </span>
                            @if($rental->overdue_fee > 0)
                                <div class="small text-muted mt-2">
                                    <div>Method: {{ $rental->overdue_payment_method ? ucfirst(str_replace('_',' ', $rental->overdue_payment_method)) : '—' }}</div>
                                    <div>Ref: {{ $rental->overdue_payment_reference ?? '—' }}</div>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="d-flex flex-column gap-2 align-items-end">
                            <a href="{{ route('rentals.show', $rental) }}" class="btn-icon btn-icon-primary" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            
                            @if($rental->overdue_receipt_path)
                                <a href="{{ asset('storage/' . $rental->overdue_receipt_path) }}" target="_blank" class="btn-icon btn-icon-secondary" title="View Receipt">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            @endif
                            
                            @if($rental->overdue_fee > 0 && $rental->overdue_payment_status === 'pending' && !$customerProvidedProof)
                                <div class="payment-form p-3 rounded" style="background: #f9fafb; width: 200px;">
                                    <form method="POST" action="{{ route('admin.rentals.overdue.pay', $rental) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="overdue_payment_reference" class="form-control-modern mb-2" style="padding: 8px; font-size: 12px;" placeholder="Reference #" required>
                                        <select name="overdue_payment_method" class="form-control-modern mb-2" style="padding: 8px; font-size: 12px;" required>
                                            <option value="cash">Cash</option>
                                            <option value="telebirr">Telebirr</option>
                                            <option value="cbe">CBE</option>
                                            <option value="bank">Bank</option>
                                        </select>
                                        <input type="file" name="overdue_receipt_file" class="form-control-modern mb-2" style="padding: 4px; font-size: 11px;">
                                        <input type="text" name="overdue_payment_notes" class="form-control-modern mb-2" style="padding: 8px; font-size: 12px;" placeholder="Notes (optional)">
                                        <button type="submit" class="btn-modern btn-modern-success btn-modern-sm w-100">
                                            <i class="bi bi-cash-stack"></i> Mark Paid
                                        </button>
                                    </form>
                                </div>
                            @elseif($rental->overdue_fee > 0 && $rental->overdue_payment_status === 'pending')
                                <div class="alert alert-info mb-0 py-2 px-3" style="font-size: 12px; max-width: 200px;">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Customer uploaded payment proof. Review receipt.
                                </div>
                            @endif
                            
                            @if(!$rental->return_verified_at)
                                @php
                                    $canApprove = $rental->overdue_fee == 0 || $rental->overdue_payment_status === 'paid' || $customerProvidedProof;
                                @endphp
                                @if($canApprove)
                                    <div class="approve-form p-3 rounded" style="background: #d1fae5; width: 200px;">
                                        <form method="POST" action="{{ route('admin.returns.approve', $rental) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="return_verification_notes" class="form-control-modern mb-2" style="padding: 8px; font-size: 12px;" placeholder="Verification notes">
                                            <button type="submit" class="btn-modern btn-modern-success btn-modern-sm w-100">
                                                <i class="bi bi-check2-circle"></i> Approve Return
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0 py-2 px-3" style="font-size: 12px; max-width: 200px;">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Waiting for payment proof before approval.
                                    </div>
                                @endif
                            @else
                                <span class="modern-badge modern-badge-success" style="font-size: 13px; padding: 8px 16px;">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Approved
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-box-arrow-in-left"></i>
                            </div>
                            <h5 class="empty-state-title">No returns to show</h5>
                            <p class="empty-state-text">Vehicle returns will appear here when rentals are completed.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($returns->hasPages())
    <div class="modern-card-footer">
        <div class="d-flex justify-content-center">
            {{ $returns->links() }}
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

    .btn-icon-secondary {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-icon-secondary:hover {
        background: #e5e7eb;
        color: #374151;
    }
</style>
@endpush
@endsection
