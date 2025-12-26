@extends('layouts.admin')

@section('title', 'Vehicle Management')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Vehicles</span>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
    <div>
        <h1 class="page-title">Vehicle Management</h1>
        <p class="page-subtitle">Manage your car rental fleet inventory</p>
    </div>
    <a href="{{ route('admin.cars.create') }}" class="btn-modern btn-modern-success">
        <i class="bi bi-plus-circle"></i> Add New Vehicle
    </a>
</div>

<!-- Filters Card -->
<div class="modern-card mb-4">
    <div class="modern-card-body">
        <form action="{{ route('admin.cars.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label-modern">Search Vehicles</label>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="form-control-modern" placeholder="Make, model, plate number..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-modern">Filter by Status</label>
                    <select name="status" class="form-control-modern">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label-modern">Availability</label>
                    <select name="available" class="form-control-modern">
                        <option value="">All</option>
                        <option value="1" {{ request('available') == '1' ? 'selected' : '' }}>Available for Rent</option>
                        <option value="0" {{ request('available') == '0' ? 'selected' : '' }}>Not Available</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-modern-primary flex-grow-1">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('admin.cars.index') }}" class="btn-modern btn-modern-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Cars Table -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-car-front-fill me-2"></i>
            Fleet Inventory
        </h3>
        <span class="modern-badge modern-badge-success">{{ $cars->total() ?? 0 }} Vehicles</span>
    </div>
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Details</th>
                    <th>Daily Rate</th>
                    <th>Status</th>
                    <th>Availability</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cars ?? [] as $car)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="car-image">
                                @if($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}">
                                @else
                                    <i class="bi bi-car-front"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">{{ $car->make }} {{ $car->model }}</div>
                                <div class="text-muted small">{{ $car->year }} • {{ $car->color }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="small">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-card-text text-muted"></i>
                                {{ $car->plate_number }}
                            </div>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <i class="bi bi-people"></i>
                                {{ $car->seats }} Seats
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">Br {{ number_format($car->daily_rate, 2) }}</div>
                        <div class="text-muted small">/day</div>
                    </td>
                    <td>
                        <span class="modern-badge modern-badge-{{ 
                            $car->status == 'available' ? 'success' : 
                            ($car->status == 'rented' ? 'primary' : 'warning') 
                        }}">
                            {{ ucfirst($car->status ?? 'available') }}
                        </span>
                    </td>
                    <td>
                        <span class="modern-badge modern-badge-{{ $car->is_available ? 'success' : 'secondary' }}">
                            <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>
                            {{ $car->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.cars.edit', $car) }}" class="btn-icon btn-icon-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.cars.toggle-availability', $car) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-icon btn-icon-{{ $car->is_available ? 'warning' : 'success' }}" title="{{ $car->is_available ? 'Mark Unavailable' : 'Mark Available' }}">
                                    <i class="bi bi-{{ $car->is_available ? 'pause-circle' : 'play-circle' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-car-front"></i>
                            </div>
                            <h5 class="empty-state-title">No vehicles found</h5>
                            <p class="empty-state-text">Start by adding your first vehicle to the fleet.</p>
                            <a href="{{ route('admin.cars.create') }}" class="btn-modern btn-modern-success mt-3">
                                <i class="bi bi-plus-circle"></i> Add Vehicle
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($cars) && $cars->hasPages())
    <div class="modern-card-footer">
        <div class="d-flex justify-content-center">
            {{ $cars->links() }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .car-image {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .car-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .car-image i {
        font-size: 24px;
        color: #9ca3af;
    }
</style>
@endpush
@endsection
