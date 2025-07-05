@extends('layouts.app')

@section('title', 'Reservation Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reservation Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Reservations
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Reservation Information -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Reservation Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Reservation ID:</strong></td>
                                                    <td>#{{ $reservation->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        @switch($reservation->status)
                                                            @case('pending')
                                                                <span class="badge badge-error">Pending</span>
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
                                                </tr>
                                                <tr>
                                                    <td><strong>Start Date:</strong></td>
                                                    <td>{{ $reservation->start_date->format('l, F d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>End Date:</strong></td>
                                                    <td>{{ $reservation->end_date->format('l, F d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Duration:</strong></td>
                                                    <td>{{ $reservation->start_date->diffInDays($reservation->end_date) + 1 }} days</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Pickup Location:</strong></td>
                                                    <td>{{ $reservation->pickup_location }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Return Location:</strong></td>
                                                    <td>{{ $reservation->return_location }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Amount:</strong></td>
                                                    <td><span class="h5 text-success">${{ number_format($reservation->total_amount, 2) }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created:</strong></td>
                                                    <td>{{ $reservation->created_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                                @if($reservation->createdBy)
                                                <tr>
                                                    <td><strong>Created By:</strong></td>
                                                    <td>{{ $reservation->createdBy->name }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>

                                    @if($reservation->notes)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <h6><i class="fas fa-sticky-note"></i> Notes:</h6>
                                                <p class="mb-0">{{ $reservation->notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Car Information -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Car Information</h5>
                                </div>
                                <div class="card-body">
                                    @if($reservation->car->image)
                                        <img src="{{ Storage::url($reservation->car->image) }}"
                                             class="img-fluid rounded mb-3"
                                             alt="{{ $reservation->car->full_name }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 150px;">
                                            <i class="fas fa-car fa-3x text-muted"></i>
                                        </div>
                                    @endif

                                    <h6>{{ $reservation->car->full_name }}</h6>
                                    <p class="text-muted mb-2">Plate: {{ $reservation->car->plate_number }}</p>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Color:</small><br>
                                            <span class="badge badge-secondary">{{ $reservation->car->color }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Seats:</small><br>
                                            <span class="badge badge-info">{{ $reservation->car->seats }}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Fuel:</small><br>
                                            <span class="badge badge-warning">{{ ucfirst($reservation->car->fuel_type) }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Transmission:</small><br>
                                            <span class="badge badge-dark">{{ ucfirst($reservation->car->transmission) }}</span>
                                        </div>
                                    </div>

                                    <div class="alert alert-success">
                                        <strong>Daily Rate:</strong> ${{ number_format($reservation->car->daily_rate, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group" role="group">
                                        @if($reservation->canBeCancelled())
                                            <form method="POST" action="{{ route('reservations.cancel', $reservation) }}"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Are you sure you want to cancel this reservation? This action cannot be undone.')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-times"></i> Cancel Reservation
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('cars.show', $reservation->car) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-car"></i> View Car Details
                                        </a>

                                        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-list"></i> Browse More Cars
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
