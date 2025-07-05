@extends('layouts.admin')

@section('title', 'Booking Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Booking Management</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
       
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.rentals.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Rental
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">All Bookings</h5>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('admin.reservations.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
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
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse($reservations ?? [] as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->car->full_name ?? 'N/A' }}</td>
                        <td>{{ $reservation->user->name ?? 'N/A' }}</td>
                        <td>{{ $reservation->start_date->format('M d, Y') }}</td>
                        <td>{{ $reservation->end_date->format('M d, Y') }}</td>
                        <td>${{ number_format($reservation->total_amount, 2) }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ 
                                $reservation->status == 'confirmed' ? 'success' : 
                                ($reservation->status == 'pending' ? 'warning' : 
                                ($reservation->status == 'cancelled' ? 'danger' : 'secondary')) 
                            }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-info rounded-pill dropdown-toggle" type="button" id="action-{{ $reservation->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear"></i> Actions
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="action-{{ $reservation->id }}">
                                    @if($reservation->status == 'pending')
                                    <li>
                                        <form action="{{ route('admin.reservations.update-status', $reservation) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-check-circle text-success"></i> Confirm
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.reservations.update-status', $reservation) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-x-circle text-danger"></i> Cancel
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
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-trash text-danger"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-calendar-x fs-1 text-secondary mb-3"></i>
                                <p class="text-muted">No bookings found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($reservations) && $reservations->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-center">
                {{ $reservations->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.5rem 1rem;
        clear: both;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }
    
    .dropdown-item:hover, .dropdown-item:focus {
        color: #16181b;
        text-decoration: none;
        background-color: #f8f9fa;
    }
    
    form {
        margin: 0;
    }
</style>
@endpush
@endsection 