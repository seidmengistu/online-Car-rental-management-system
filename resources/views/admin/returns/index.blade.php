@extends('layouts.admin')

@section('title', 'Return Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Return Management</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted text-uppercase small mb-1">Pending verification</p>
                    <h3 class="mb-0">{{ $stats['pending_verification'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted text-uppercase small mb-1">Overdue payments pending</p>
                    <h3 class="mb-0">{{ $stats['pending_overdue'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted text-uppercase small mb-1">Approved returns</p>
                    <h3 class="mb-0">{{ $stats['approved'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3" method="GET" action="{{ route('admin.returns.index') }}">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Customer, email, car plate...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Verification status</label>
                    <select name="verification" class="form-select">
                        <option value="">All</option>
                        <option value="pending" {{ request('verification') == 'pending' ? 'selected' : '' }}>Pending approval</option>
                        <option value="approved" {{ request('verification') == 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Overdue payment</label>
                    <select name="overdue_status" class="form-select">
                        <option value="">All</option>
                        <option value="pending" {{ request('overdue_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('overdue_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="not_required" {{ request('overdue_status') == 'not_required' ? 'selected' : '' }}>Not required</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>Apply filters
                    </button>
                    <a href="{{ route('admin.returns.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Rental</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Return details</th>
                        <th>Overdue</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $rental)
                        <tr>
                            <td>
                                <strong>#{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</strong>
                                <div class="small text-muted">{{ $rental->reservation ? 'Reservation #' . $rental->reservation->id : 'Manual rental' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $rental->user->name }}</div>
                                <div class="small text-muted">{{ $rental->user->email }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $rental->car->full_name }}</div>
                                <div class="small text-muted">Plate {{ $rental->car->plate_number }}</div>
                            </td>
                            <td>
                                <div class="small text-muted">Scheduled: {{ $rental->end_date->format('M d, Y') }}</div>
                                <div class="fw-semibold">
                                    Actual: {{ $rental->actual_end_date ? $rental->actual_end_date->format('M d, Y H:i') : '—' }}
                                </div>
                                <div class="small text-muted">
                                    Verification: {{ $rental->return_verified_at ? 'Approved on ' . $rental->return_verified_at->format('M d, Y') : 'Pending' }}
                                </div>
                                @if($rental->return_verification_notes)
                                    <div class="small text-muted">Notes: {{ $rental->return_verification_notes }}</div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $customerProvidedProof = $rental->overdue_payment_reference || $rental->overdue_receipt_path;
                                @endphp
                                <div>
                                    <strong>ETB {{ number_format($rental->overdue_fee, 2) }}</strong>
                                    <span class="badge {{ match($rental->overdue_payment_status){
                                        'paid' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        default => 'bg-secondary'
                                    } }}">{{ ucfirst($rental->overdue_payment_status) }}</span>
                                </div>
                                @if($rental->overdue_fee > 0)
                                    <div class="small text-muted">
                                        Method: {{ $rental->overdue_payment_method ? ucfirst(str_replace('_',' ', $rental->overdue_payment_method)) : '—' }}<br>
                                        Ref: {{ $rental->overdue_payment_reference ?? '—' }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('rentals.show', $rental) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($rental->overdue_receipt_path)
                                        <a href="{{ asset('storage/' . $rental->overdue_receipt_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-receipt"></i>
                                        </a>
                                    @endif
                                    @if($rental->overdue_fee > 0 && $rental->overdue_payment_status === 'pending' && !$customerProvidedProof)
                                        <form method="POST" action="{{ route('admin.rentals.overdue.pay', $rental) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="overdue_payment_reference" class="form-control form-control-sm mb-1" placeholder="Reference #" required>
                                            <select name="overdue_payment_method" class="form-select form-select-sm mb-1" required>
                                                <option value="cash">Cash</option>
                                                <option value="telebirr">Telebirr</option>
                                                <option value="cbe">CBE</option>
                                                <option value="bank">Bank</option>
                                            </select>
                                            <input type="file" name="overdue_receipt_file" class="form-control form-control-sm mb-1">
                                            <input type="text" name="overdue_payment_notes" class="form-control form-control-sm mb-2" placeholder="Notes (optional)">
                                            <button class="btn btn-success btn-sm w-100">
                                                <i class="bi bi-cash-stack"></i> Mark paid
                                            </button>
                                        </form>
                                    @elseif($rental->overdue_fee > 0 && $rental->overdue_payment_status === 'pending')
                                        <div class="alert alert-info mb-2">
                                            Customer has uploaded payment proof. Review receipt, then approve return below.
                                        </div>
                                    @endif
                                    @if(!$rental->return_verified_at)
                                        @php
                                            $canApprove = $rental->overdue_fee == 0 || $rental->overdue_payment_status === 'paid' || $customerProvidedProof;
                                        @endphp
                                        @if($canApprove)
                                            <form method="POST" action="{{ route('admin.returns.approve', $rental) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="return_verification_notes" class="form-control form-control-sm mb-2" placeholder="Verification notes">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="bi bi-check2-circle"></i>
                                                </button>
                                            </form>
                                        @else
                                            <div class="alert alert-warning py-2 mb-0">
                                                Waiting for customer receipt upload or record cash payment above before approval.
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge bg-success-subtle text-success">Approved</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No returns to show.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($returns->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-center">
                    {{ $returns->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

