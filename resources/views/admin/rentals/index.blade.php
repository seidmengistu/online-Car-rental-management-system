@extends('layouts.admin')

@section('title', 'Rental Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Rentals</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">All Rentals</h4>
            <small class="text-muted">Monitor active, returned, and overdue rentals.</small>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <form action="{{ route('admin.rentals.index') }}" method="GET" class="row g-2">
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search car or user..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                    <a href="{{ route('admin.rentals.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Create Rental
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
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
                                'active' => 'bg-success',
                                'returned' => 'bg-info',
                                'overdue' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                            $paymentStatus = optional($rental->reservation)->payment_status ?? 'paid';
                        @endphp
                        <tr>
                            <td>#{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $rental->car->full_name ?? 'N/A' }}</td>
                            <td>{{ $rental->user->name ?? 'N/A' }}</td>
                            <td>
                                <div class="small text-muted">{{ $rental->start_date->format('M d, Y') }} - {{ $rental->end_date->format('M d, Y') }}</div>
                                <div>{{ $rental->start_date->diffInDays($rental->end_date) + 1 }} days</div>
                            </td>
                            <td>
                                <span class="badge {{ $statusBadge }}">{{ ucfirst($rental->status) }}</span>
                                @if($rental->isOverdue())
                                    <span class="badge bg-danger-subtle text-danger mt-1">Overdue by {{ $rental->overdue_days }} days</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $customerProvidedProof = $rental->overdue_payment_reference || $rental->overdue_receipt_path;
                                @endphp
                                <div>
                                    <span class="badge {{ $paymentStatus === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($paymentStatus) }}
                                    </span>
                                    @if(optional($rental->reservation)->payment_reference)
                                        <div class="small text-muted mt-1">
                                            Ref: {{ \Illuminate\Support\Str::limit($rental->reservation->payment_reference, 12) }}
                                        </div>
                                    @endif
                                </div>
                                @if($rental->overdue_fee > 0)
                                    <div class="mt-2 p-2 border rounded">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Overdue:</strong> ETB {{ number_format($rental->overdue_fee, 2) }}
                                                <span class="badge {{ $rental->overdue_payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} ms-1">
                                                    {{ ucfirst($rental->overdue_payment_status) }}
                                                </span>
                                            </div>
                                            @if($rental->overdue_receipt_path)
                                                <a href="{{ asset('storage/' . $rental->overdue_receipt_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                                </a>
                                            @endif
                                        </div>
                                        @if($rental->overdue_payment_status === 'pending' && !$customerProvidedProof)
                                            <form action="{{ route('admin.rentals.overdue.pay', $rental) }}" method="POST" class="mt-2" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-2">
                                                    <select name="overdue_payment_method" class="form-select form-select-sm" required>
                                                        <option value="cash">Cash</option>
                                                        <option value="telebirr">Telebirr</option>
                                                        <option value="cbe">CBE</option>
                                                        <option value="bank">Bank branch</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" name="overdue_payment_reference" class="form-control form-control-sm" placeholder="Reference / receipt #" required>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="file" name="overdue_receipt_file" class="form-control form-control-sm">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" name="overdue_payment_notes" class="form-control form-control-sm" placeholder="Notes (optional)">
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success w-100">
                                                    <i class="bi bi-check2-circle"></i> Mark overdue paid
                                                </button>
                                            </form>
                                        @elseif($rental->overdue_payment_status === 'pending')
                                            <div class="mt-2 alert alert-info mb-0 py-2">
                                                Customer uploaded proof. Review receipt then approve return.
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('rentals.show', $rental) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-key fs-1 text-muted mb-3"></i>
                                <p class="text-muted mb-0">No rentals found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rentals->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-center">
                    {{ $rentals->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

