@extends('layouts.app')

@section('title', $car->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $car->full_name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Cars
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Car Image -->
                        <div class="col-md-6">
                            @if($car->image)
                                <img src="{{ Storage::url($car->image) }}" class="img-fluid rounded" alt="{{ $car->full_name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                                    <i class="fas fa-car fa-5x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Car Details -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-primary">{{ $car->full_name }}</h4>
                                    <p class="text-muted">Plate Number: {{ $car->plate_number }}</p>
                                    
                                    <div class="alert alert-info">
                                        <h5 class="mb-0">
                                            <i class="fas fa-dollar-sign"></i> 
                                            Daily Rate: ${{ number_format($car->daily_rate, 2) }}
                                        </h5>
                                        @if($car->weekly_rate)
                                            <small>Weekly: ${{ number_format($car->weekly_rate, 2) }} | Monthly: ${{ number_format($car->monthly_rate, 2) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-primary"><i class="fas fa-palette"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Color</span>
                                            <span class="info-box-number">{{ $car->color }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Seats</span>
                                            <span class="info-box-number">{{ $car->seats }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-gas-pump"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Fuel Type</span>
                                            <span class="info-box-number">{{ ucfirst($car->fuel_type) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-info"><i class="fas fa-cog"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Transmission</span>
                                            <span class="info-box-number">{{ ucfirst($car->transmission) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-secondary"><i class="fas fa-tachometer-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Mileage</span>
                                            <span class="info-box-number">{{ number_format($car->mileage) }} km</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon {{ $car->is_available ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-circle"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Status</span>
                                            <span class="info-box-number">{{ $car->is_available ? 'Available' : 'Not Available' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($car->description)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Description</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ $car->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($car->features && count($car->features) > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Features</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($car->features as $feature)
                                                <div class="col-md-6">
                                                    <span class="badge badge-primary mb-1">{{ $feature }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row mt-3">
                                <div class="col-12">
                                    @if($car->is_available)
                                        <a href="{{ route('reservations.create', ['car_id' => $car->id]) }}" class="btn btn-success btn-lg btn-block">
                                            <i class="fas fa-calendar-plus"></i> Reserve This Car
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-lg btn-block" disabled>
                                            <i class="fas fa-times"></i> Not Available for Reservation
                                        </button>
                                    @endif
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