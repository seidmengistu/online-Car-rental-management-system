@extends('layouts.app')

@section('title', 'My Rentals')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Rentals</h3>
                    <div class="card-tools">
                        <a href="{{ route('cars.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-car"></i> Browse Cars
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('rentals.index') }}">
                                <div class="input-group">
                                    <select class="form-control" name="status">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    <div class="input-group-append ms-4">
                                        <button type="submit" class="btn btn-outline-secondary">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Rentals Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Car</th>
                                    <th>Rental Period</th>
                                    <th>Locations</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rentals as $rental)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $rental->car->full_name }}</strong><br>
                                            <small class="text-muted">{{ $rental->car->plate_number }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>From:</strong> {{ $rental->start_date->format('M d, Y') }}<br>
                                            <strong>To:</strong> {{ $rental->end_date->format('M d, Y') }}<br>
                                            <small class="text-muted">
                                                {{ $rental->start_date->diffInDays($rental->end_date) + 1 }} days
                                            </small>
                                            @if($rental->isOverdue())
                                                <br><span class="badge badge-danger">Overdue by {{ $rental->overdue_days }} days</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>Pickup:</strong> {{ $rental->pickup_location }}<br>
                                            <strong>Return:</strong> {{ $rental->return_location }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="h5 text-success">${{ number_format($rental->total_amount, 2) }}</span>
                                            @if($rental->additional_charges > 0)
                                                <br><small class="text-warning">+${{ number_format($rental->additional_charges, 2) }} additional</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @switch($rental->status)
                                            @case('active')
                                                <span class="badge badge-success">Active</span>
                                                @break
                                            @case('returned')
                                                <span class="badge badge-info">Returned</span>
                                                @break
                                            @case('overdue')
                                                <span class="badge badge-danger">Overdue</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($rental->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('rentals.show', $rental) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> You don't have any rentals yet.
                                            <br>
                                            <a href="{{ route('cars.index') }}" class="btn btn-primary btn-sm mt-2">
                                                <i class="fas fa-car"></i> Browse Available Cars
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $rentals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 