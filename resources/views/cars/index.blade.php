@extends('layouts.app')

@section('title', 'Browse Cars')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Browse Cars</span>
@endsection

@push('styles')
<style>
    body {
        background: #f6f7fb;
    }

    .cars-page-header {
        background: linear-gradient(135deg, #6451f1 0%, #7b5df0 45%, #a855f7 100%);
        color: white;
        padding: 2.5rem;
        margin-bottom: 2rem;
        border-radius: 1rem;
        box-shadow: 0 25px 50px rgba(106, 79, 255, 0.25);
        overflow: hidden;
        position: relative;
    }

    .cars-page-header::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        top: -60px;
        right: -40px;
    }

    .cars-page-title {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .cars-page-subtitle {
        color: rgba(255,255,255,0.85);
        font-size: 1rem;
        max-width: 640px;
    }

    .cars-hero-actions {
        margin-top: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .cars-hero-actions .btn {
        border-radius: 999px;
        padding-inline: 1.5rem;
    }

    .cars-stats-row {
        margin-top: 1rem;
    }

    .car-stat-card {
        border: none;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        padding: 1.25rem;
        height: 100%;
    }

    .car-stat-card span {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
    }

    .car-stat-card strong {
        display: block;
        margin-top: 0.4rem;
        font-size: 1.8rem;
        color: #1f2937;
    }
    
    .filter-card {
        border: none;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        border-radius: 1rem;
        margin-bottom: 1.75rem;
        background: white;
    }
    
    .filter-header {
        background: transparent;
        color: #1f2937;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #edf0f7;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }
    
    .filter-header i {
        font-size: 1.25rem;
        color: #7b5df0;
    }
    
    .filter-header:hover {
        color: #7b5df0;
    }
    
    .filter-card .card-body {
        padding: 1.5rem;
    }
    
    .car-card {
        border: none;
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 25px 45px rgba(15, 23, 42, 0.08);
        height: 100%;
        background: white;
    }
    
    .car-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 35px 65px rgba(15, 23, 42, 0.15);
    }
    
    .car-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 190px;
        background: linear-gradient(135deg, #eef2ff 0%, #d9e4ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }
    
    .car-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    
    .car-card:hover .car-image-wrapper img {
        transform: scale(1.05);
    }
    
    .car-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255,255,255,0.95);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    .car-badge.available {
        color: #28a745;
    }
    
    .car-badge.unavailable {
        color: #dc3545;
    }
    
    .car-price-tag {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.25rem;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    
    .car-price-tag small {
        font-size: 0.75rem;
        opacity: 0.9;
        font-weight: 400;
    }
    
    .car-body {
        padding: 1.25rem 1.5rem 1.4rem;
    }
    
    .car-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.4rem;
        line-height: 1.3;
    }
    
    .car-subtitle {
        color: #718096;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }
    
    .car-specs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .car-specs-primary {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 0.5rem;
        width: 100%;
    }
    
    .car-specs-primary .spec-badge {
        flex: 1;
        min-width: 0;
    }
    
    .car-specs-secondary {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .spec-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.65rem;
        background: #f3f6ff;
        border-radius: 0.75rem;
        font-size: 0.8rem;
        color: #475569;
        border: 1px solid #e2e8f0;
        white-space: nowrap;
        font-weight: 600;
    }
    
    .spec-badge i {
        color: #667eea;
        font-size: 0.9rem;
    }
    
    .car-description {
        color: #475569;
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 0.9rem;
        min-height: 2rem;
    }
    
    .car-rates {
        background: #f8fafc;
        padding: 0.8rem;
        border-radius: 0.75rem;
        margin-bottom: 0.9rem;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 0.4rem;
        border: 1px dashed #e3e8f4;
    }
    
    .rate-item {
        text-align: center;
        flex: 1;
        min-width: 65px;
    }
    
    .rate-item .rate-label {
        font-size: 0.72rem;
        color: #94a3b8;
        display: block;
        margin-bottom: 0.2rem;
    }
    
    .rate-item .rate-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .car-actions {
        display: flex;
        gap: 0.6rem;
    }
    
    .car-actions .btn {
        flex: 1;
        border-radius: 0.75rem;
        font-weight: 600;
        padding: 0.6rem 0.9rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .car-actions .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #7b5df0;
        box-shadow: 0 0 0 0.15rem rgba(123, 93, 240, 0.15);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5568d3 0%, #653a8f 100%);
    }
    
    @media (max-width: 768px) {
        .cars-page-header {
            padding: 1.5rem;
        }
        
        .car-card {
            margin-bottom: 1.5rem;
        }
        
        .car-specs-primary {
            flex-direction: column;
        }
        
        .car-specs-primary .spec-badge {
            width: 100%;
        }
        
        .car-specs {
            gap: 0.4rem;
        }
        
        .car-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
@php
    $carsCollection = collect($cars->items());
    $availableCount = $carsCollection->where('is_available', true)->count();
    $avgDailyRate = $carsCollection->avg('daily_rate');
@endphp
<div class="container-fluid px-3 px-md-4">
    <div class="cars-page-header">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="cars-page-title">Find the perfect ride for your next trip</div>
                <p class="cars-page-subtitle">
                    Filter by brand, features, pricing, and more. Every car is thoroughly inspected and ready to go.
                </p>
                <div class="cars-hero-actions">
                    <a href="#filterCollapse" class="btn btn-light text-primary fw-semibold">
                        <i class="bi bi-funnel-fill me-2"></i>Refine results
                    </a>
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-calendar2-week me-2"></i>View my reservations
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row g-3 cars-stats-row">
                    <div class="col-sm-6 col-lg-12">
                        <div class="car-stat-card">
                            <span>Total cars available</span>
                            <strong>{{ number_format($cars->total()) }}</strong>
                            <small class="text-muted">Across all categories</small>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-12">
                        <div class="car-stat-card">
                            <span>On this page</span>
                            <strong>{{ $cars->firstItem() }} - {{ $cars->lastItem() }}</strong>
                            <small class="text-muted">{{ $availableCount }} open for booking</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="car-stat-card">
                <span>Ready now</span>
                <strong>{{ $availableCount }}</strong>
                <small class="text-muted">Currently showing</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="car-stat-card">
                <span>Avg daily rate</span>
                <strong>{{ $avgDailyRate ? '$'.number_format($avgDailyRate, 2) : '—' }}</strong>
                <small class="text-muted">Based on filtered results</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="car-stat-card">
                <span>Filter preset</span>
                <strong>{{ request('available') ? 'Available only' : 'All cars' }}</strong>
                <small class="text-muted">Adjust in the panel below</small>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card card">
        <div class="filter-header" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
            <div>
                <i class="bi bi-funnel-fill me-2"></i>
                <strong>Search & Filter</strong>
            </div>
            <i class="bi bi-chevron-down" id="filterIcon"></i>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('cars.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <label for="search" class="form-label fw-semibold">
                                <i class="bi bi-search me-1"></i>Search
                            </label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Make, model, or description...">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="make" class="form-label fw-semibold">
                                <i class="bi bi-tag me-1"></i>Make
                            </label>
                            <input type="text" class="form-control" id="make" name="make" 
                                   value="{{ request('make') }}" placeholder="e.g., Toyota">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="model" class="form-label fw-semibold">
                                <i class="bi bi-tag-fill me-1"></i>Model
                            </label>
                            <input type="text" class="form-control" id="model" name="model" 
                                   value="{{ request('model') }}" placeholder="e.g., Camry">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="fuel_type" class="form-label fw-semibold">
                                <i class="bi bi-fuel-pump me-1"></i>Fuel Type
                            </label>
                            <select class="form-select" id="fuel_type" name="fuel_type">
                                <option value="">All Types</option>
                                @foreach($fuelTypes as $fuel)
                                    <option value="{{ $fuel }}" {{ request('fuel_type') == $fuel ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $fuel)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="transmission" class="form-label fw-semibold">
                                <i class="bi bi-gear me-1"></i>Transmission
                            </label>
                            <select class="form-select" id="transmission" name="transmission">
                                <option value="">All Types</option>
                                @foreach($transmissions as $trans)
                                    <option value="{{ $trans }}" {{ request('transmission') == $trans ? 'selected' : '' }}>
                                        {{ ucfirst($trans) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="price_min" class="form-label fw-semibold">
                                <i class="bi bi-currency-dollar me-1"></i>Min Price/Day
                            </label>
                            <input type="number" class="form-control" id="price_min" name="price_min" 
                                   value="{{ request('price_min') }}" placeholder="0" min="0" step="0.01">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="price_max" class="form-label fw-semibold">
                                <i class="bi bi-currency-dollar me-1"></i>Max Price/Day
                            </label>
                            <input type="number" class="form-control" id="price_max" name="price_max" 
                                   value="{{ request('price_max') }}" placeholder="1000" min="0" step="0.01">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label for="seats_min" class="form-label fw-semibold">
                                <i class="bi bi-people me-1"></i>Min Seats
                            </label>
                            <input type="number" class="form-control" id="seats_min" name="seats_min" 
                                   value="{{ request('seats_min') }}" placeholder="2" min="2" max="8">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i>Search Cars
                                </button>
                                <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Clear Filters
                                </a>
                                <div class="form-check ms-auto d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" id="available" name="available" 
                                           value="1" {{ request('available') ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="available">
                                        Available Only
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Results Count -->
    @if($cars->count() > 0)
    <div class="mb-3">
        <p class="text-muted mb-0">
            <i class="bi bi-info-circle me-1"></i>
            Showing <strong>{{ $cars->firstItem() }}</strong> to <strong>{{ $cars->lastItem() }}</strong> 
            of <strong>{{ $cars->total() }}</strong> cars
        </p>
    </div>
    @endif

    <!-- Cars Grid -->
    <div class="row g-4">
        @forelse($cars as $car)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="car-card card">
                <div class="car-image-wrapper">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->full_name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-car-front-fill" style="font-size: 4rem; color: #cbd5e0;"></i>
                        </div>
                    @endif
                    <div class="car-badge {{ $car->is_available ? 'available' : 'unavailable' }}">
                        <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                        {{ $car->is_available ? 'Available' : 'Unavailable' }}
                    </div>
                    <div class="car-price-tag">
                        Br {{ number_format($car->daily_rate, 2) }}
                        <small>/day</small>
                    </div>
                </div>
                
                <div class="car-body">
                    <h5 class="car-title">{{ $car->full_name }}</h5>
                    <p class="car-subtitle">
                        <i class="bi bi-tag me-1"></i>{{ $car->plate_number }}
                        @if($car->year)
                            <span class="ms-2">• {{ $car->year }}</span>
                        @endif
                    </p>
                    
                    <div class="car-specs">
                        <div class="car-specs-primary">
                            <span class="spec-badge">
                                <i class="bi bi-palette"></i>
                                <span>{{ $car->color ?? 'N/A' }}</span>
                            </span>
                            <span class="spec-badge">
                                <i class="bi bi-people"></i>
                                <span>{{ $car->seats ?? 'N/A' }} seats</span>
                            </span>
                            <span class="spec-badge">
                                <i class="bi bi-fuel-pump"></i>
                                <span>{{ ucfirst(str_replace('_', ' ', $car->fuel_type ?? 'N/A')) }}</span>
                            </span>
                        </div>
                        <div class="car-specs-secondary">
                            <span class="spec-badge">
                                <i class="bi bi-gear"></i>
                                <span>{{ ucfirst($car->transmission ?? 'N/A') }}</span>
                            </span>
                            @if($car->mileage)
                            <span class="spec-badge">
                                <i class="bi bi-speedometer2"></i>
                                <span>{{ number_format($car->mileage) }} mi</span>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    @if($car->description)
                    <p class="car-description">
                        {{ Str::limit($car->description, 100) }}
                    </p>
                    @endif
                    
                    @if($car->weekly_rate || $car->monthly_rate)
                    <div class="car-rates">
                        <div class="rate-item">
                            <span class="rate-label">Daily</span>
                            <span class="rate-value">Br {{ number_format($car->daily_rate, 2) }}</span>
                        </div>
                        @if($car->weekly_rate)
                        <div class="rate-item">
                            <span class="rate-label">Weekly</span>
                            <span class="rate-value">Br {{ number_format($car->weekly_rate, 2) }}</span>
                        </div>
                        @endif
                        @if($car->monthly_rate)
                        <div class="rate-item">
                            <span class="rate-label">Monthly</span>
                            <span class="rate-value">Br {{ number_format($car->monthly_rate, 2) }}</span>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <div class="car-actions">
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye me-1"></i>Details
                        </a>
                        @auth
                            <a href="{{ route('reservations.create', ['car_id' => $car->id]) }}" class="btn btn-success">
                                <i class="bi bi-calendar-plus me-1"></i>Reserve
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-car-front"></i>
                <h4 class="mb-2">No Cars Found</h4>
                <p class="text-muted mb-4">
                    We couldn't find any cars matching your search criteria. Try adjusting your filters.
                </p>
                <a href="{{ route('cars.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise me-2"></i>Clear All Filters
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($cars->hasPages())
    <div class="d-flex justify-content-center mt-5">
        <nav>
            {{ $cars->links() }}
        </nav>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Toggle filter icon on collapse
    document.getElementById('filterCollapse').addEventListener('show.bs.collapse', function () {
        document.getElementById('filterIcon').classList.remove('bi-chevron-down');
        document.getElementById('filterIcon').classList.add('bi-chevron-up');
    });
    
    document.getElementById('filterCollapse').addEventListener('hide.bs.collapse', function () {
        document.getElementById('filterIcon').classList.remove('bi-chevron-up');
        document.getElementById('filterIcon').classList.add('bi-chevron-down');
    });
</script>
@endpush
@endsection
