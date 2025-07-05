@extends('layouts.app')

@section('title', 'Rental Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rental Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('rentals.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Rentals
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Rental Information -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Rental Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Rental ID:</strong></td>
                                                    <td>#{{ $rental->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
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
                                                        @if($rental->isOverdue())
                                                            <br><span class="badge badge-danger">Overdue by {{ $rental->overdue_days }} days</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Start Date:</strong></td>
                                                    <td>{{ $rental->start_date->format('l, F d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>End Date:</strong></td>
                                                    <td>{{ $rental->end_date->format('l, F d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Duration:</strong></td>
                                                    <td>{{ $rental->start_date->diffInDays($rental->end_date) + 1 }} days</td>
                                                </tr>
                                                @if($rental->actual_start_date)
                                                <tr>
                                                    <td><strong>Actual Start:</strong></td>
                                                    <td>{{ $rental->actual_start_date->format('M d, Y H:i') }}</td>
                                                </tr>
                                                @endif
                                                @if($rental->actual_end_date)
                                                <tr>
                                                    <td><strong>Actual End:</strong></td>
                                                    <td>{{ $rental->actual_end_date->format('M d, Y H:i') }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Pickup Location:</strong></td>
                                                    <td>{{ $rental->pickup_location }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Return Location:</strong></td>
                                                    <td>{{ $rental->return_location }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Base Amount:</strong></td>
                                                    <td><span class="h5 text-success">${{ number_format($rental->total_amount, 2) }}</span></td>
                                                </tr>
                                                @if($rental->additional_charges > 0)
                                                <tr>
                                                    <td><strong>Additional Charges:</strong></td>
                                                    <td><span class="h5 text-warning">${{ number_format($rental->additional_charges, 2) }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Final Amount:</strong></td>
                                                    <td><span class="h5 text-danger">${{ number_format($rental->calculateFinalAmount(), 2) }}</span></td>
                                                </tr>
                                                @endif
                                                @if($rental->deposit_amount > 0)
                                                <tr>
                                                    <td><strong>Deposit:</strong></td>
                                                    <td><span class="h5 text-info">${{ number_format($rental->deposit_amount, 2) }}</span></td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>

                                    @if($rental->notes)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <h6><i class="fas fa-sticky-note"></i> Notes:</h6>
                                                <p class="mb-0">{{ $rental->notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($rental->return_notes)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="alert alert-warning">
                                                <h6><i class="fas fa-clipboard"></i> Return Notes:</h6>
                                                <p class="mb-0">{{ $rental->return_notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($rental->damage_report)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="alert alert-danger">
                                                <h6><i class="fas fa-exclamation-triangle"></i> Damage Report:</h6>
                                                <p class="mb-0">{{ $rental->damage_report }}</p>
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
                                    @if($rental->car->image)
                                        <img src="{{ Storage::url($rental->car->image) }}" 
                                             class="img-fluid rounded mb-3" 
                                             alt="{{ $rental->car->full_name }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 150px;">
                                            <i class="fas fa-car fa-3x text-muted"></i>
                                        </div>
                                    @endif

                                    <h6>{{ $rental->car->full_name }}</h6>
                                    <p class="text-muted mb-2">Plate: {{ $rental->car->plate_number }}</p>
                                    
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Color:</small><br>
                                            <span class="badge badge-secondary">{{ $rental->car->color }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Seats:</small><br>
                                            <span class="badge badge-info">{{ $rental->car->seats }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Fuel:</small><br>
                                            <span class="badge badge-warning">{{ ucfirst($rental->car->fuel_type) }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Transmission:</small><br>
                                            <span class="badge badge-dark">{{ ucfirst($rental->car->transmission) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-success">
                                        <strong>Daily Rate:</strong> ${{ number_format($rental->car->daily_rate, 2) }}
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
                                        <a href="{{ route('cars.show', $rental->car) }}" class="btn btn-outline-primary">
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