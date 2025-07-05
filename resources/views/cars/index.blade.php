@extends('layouts.app')

@section('title', 'Neda Available Cars')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Available Cars</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('cars.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="make">Make</label>
                                    <input type="text" class="form-control" id="make" name="make" value="{{ request('make') }}" placeholder="e.g., Toyota">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" class="form-control" id="model" name="model" value="{{ request('model') }}" placeholder="e.g., Camry">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fuel_type">Fuel Type</label>
                                    <select class="form-control" id="fuel_type" name="fuel_type">
                                        <option value="">All Types</option>
                                        <option value="gasoline" {{ request('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                        <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        <option value="plug-in_hybrid" {{ request('fuel_type') == 'plug-in_hybrid' ? 'selected' : '' }}>Plug-in Hybrid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="transmission">Transmission</label>
                                    <select class="form-control" id="transmission" name="transmission">
                                        <option value="">All</option>
                                        <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="min_price">Min Price</label>
                                    <input type="number" class="form-control" id="min_price" name="min_price" value="{{ request('min_price') }}" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="max_price">Max Price</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price" value="{{ request('max_price') }}" placeholder="1000">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="available" name="available" value="1" {{ request('available') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="available">Available Only</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('cars.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Cars Grid -->
                    <div class="row">
                        @forelse($cars as $car)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card h-100">
                                @if($car->image)
                                    <img src="{{ Storage::url($car->image) }}" class="card-img-top" alt="{{ $car->full_name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-car fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $car->full_name }}</h5>
                                    <p class="card-text text-muted">{{ $car->plate_number }}</p>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Color:</small><br>
                                            <span class="badge badge-secondary">{{ $car->color }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Seats:</small><br>
                                            <span class="badge badge-info">{{ $car->seats }}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Fuel:</small><br>
                                            <span class="badge badge-warning">{{ ucfirst($car->fuel_type) }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Transmission:</small><br>
                                            <span class="badge badge-dark">{{ ucfirst($car->transmission) }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Daily Rate:</small><br>
                                        <span class="h5 text-success">${{ number_format($car->daily_rate, 2) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                        @auth
                                            <a href="{{ route('reservations.create', ['car_id' => $car->id]) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-calendar-plus"></i> Reserve
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-sign-in-alt"></i> Login to Reserve
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        <i class="fas fa-circle {{ $car->is_available ? 'text-success' : 'text-danger' }}"></i>
                                        {{ $car->is_available ? 'Available' : 'Not Available' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> No cars found matching your criteria.
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $cars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
