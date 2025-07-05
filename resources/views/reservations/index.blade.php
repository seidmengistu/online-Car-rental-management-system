@extends('layouts.app')

@section('title', 'My Reservations')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Reservations</h3>
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
                            <form method="GET" action="{{ route('reservations.index') }}">
                                <div class="input-group">
                                    <select class="form-control" name="status">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
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

                    <!-- Reservations Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Car</th>
                                    <th>Dates</th>
                                    <th>Locations</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $reservation)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $reservation->car->full_name }}</strong><br>
                                            <small class="text-muted">{{ $reservation->car->plate_number }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>From:</strong> {{ $reservation->start_date->format('M d, Y') }}<br>
                                            <strong>To:</strong> {{ $reservation->end_date->format('M d, Y') }}<br>
                                            <small class="text-muted">
                                                {{ $reservation->start_date->diffInDays($reservation->end_date) + 1 }} days
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>Pickup:</strong> {{ $reservation->pickup_location }}<br>
                                            <strong>Return:</strong> {{ $reservation->return_location }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="h5 text-success">${{ number_format($reservation->total_amount, 2) }}</span>
                                    </td>
                                    <td>
                                        @switch($reservation->status)
                                            @case('pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge badge-success">Confirmed</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                                @break
                                            @case('completed')
                                                <span class="badge badge-info">Completed</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($reservation->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <small>{{ $reservation->created_at->format('M d, Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('reservations.show', $reservation) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            
                                            @if($reservation->canBeCancelled())
                                                <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" 
                                                      style="display: inline;" 
                                                      onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> You don't have any reservations yet.
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
                        {{ $reservations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 