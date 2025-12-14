@extends('layouts.app')

@section('title', $car->full_name)

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('cars.index') }}">Cars</a>
<span class="separator">/</span>
<span class="current">{{ $car->make }} {{ $car->model }}</span>
@endsection

@push('styles')
<style>
    .car-detail-page {
        padding: 1.5rem 0 3rem;
        background: linear-gradient(180deg, #f6f7fb 0%, #ffffff 55%);
    }

    .car-hero {
        border: none;
        border-radius: 1.5rem;
        background: linear-gradient(135deg, #6a7df1 0%, #7f56d9 45%, #a855f7 100%);
        color: #fff;
        overflow: hidden;
        position: relative;
    }

    .car-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.35), transparent 60%);
        opacity: 0.9;
    }

    .car-hero > .row {
        position: relative;
        z-index: 2;
    }

    .car-hero h1 {
        font-size: clamp(2rem, 3vw, 2.6rem);
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .car-hero .car-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        font-size: 0.95rem;
        color: rgba(255,255,255,0.8);
    }

    .car-hero .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        font-weight: 600;
        background: rgba(255,255,255,0.18);
        backdrop-filter: blur(6px);
        color: #fff;
    }

    .car-image-frame {
        background: rgba(255,255,255,0.15);
        border-radius: 1.25rem;
        padding: 1.25rem;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.3);
    }

    .car-image-frame img {
        width: 100%;
        max-height: 320px;
        object-fit: contain;
        filter: drop-shadow(0px 18px 35px rgba(30,30,50,0.45));
    }

    .metric-card {
        background: #fff;
        border: 1px solid #edf0f7;
        border-radius: 1rem;
        padding: 1.25rem;
        height: 100%;
        box-shadow: 0 25px 45px rgba(15,23,42,0.05);
    }

    .metric-card h6 {
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.08em;
        color: #94a3b8;
        margin-bottom: 0.25rem;
    }

    .metric-card .metric-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .spec-card {
        background: #fff;
        border: 1px solid #edf0f7;
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: 0 20px 35px rgba(15,23,42,0.05);
    }

    .spec-card h4 {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.25rem;
    }

    .spec-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
    }

    .spec-item {
        border: 1px solid #edf0f7;
        border-radius: 1rem;
        padding: 1rem;
        background: #f9fafc;
    }

    .spec-item strong {
        display: block;
        margin-top: 0.35rem;
        font-size: 1rem;
        color: #111827;
    }

    .spec-item span {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
    }

    .content-card {
        background: #fff;
        border: 1px solid #edf0f7;
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: 0 12px 30px rgba(15,23,42,0.05);
    }

    .content-card h5 {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .feature-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        background: #eef2ff;
        color: #4338ca;
        font-weight: 600;
        font-size: 0.85rem;
        margin: 0.2rem;
    }

    .cta-card {
        background: #0f172a;
        color: #fff;
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: 0 30px 50px rgba(15,23,42,0.3);
        position: relative;
        overflow: hidden;
    }

    .cta-card::before {
        content: "";
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(248,250,252,0.08);
        border-radius: 50%;
        top: -60px;
        right: -40px;
    }

    .cta-card * {
        position: relative;
        z-index: 2;
    }

    .cta-card .btn {
        border-radius: 0.75rem;
        padding: 0.85rem 1.25rem;
        font-weight: 600;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        font-weight: 600;
    }

    .back-link:hover {
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .car-hero {
            padding: 1.5rem !important;
        }

        .car-image-frame {
            margin-top: 1.5rem;
            min-height: 240px;
        }
    }
</style>
@endpush

@section('content')
@php
    $mileageText = $car->mileage ? number_format($car->mileage) . ' km' : '—';
    $fuelType = $car->fuel_type ? ucfirst(str_replace('_', ' ', $car->fuel_type)) : '—';
    $transmission = $car->transmission ? ucfirst($car->transmission) : '—';
@endphp
<div class="car-detail-page container-fluid px-3 px-md-4">
    <div class="car-hero card shadow-sm p-4 p-lg-5 mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <a href="{{ route('cars.index') }}" class="back-link mb-3">
                    <i class="bi bi-arrow-left"></i>
                    Back to all cars
                </a>
                <h1>{{ $car->full_name }}</h1>
                <div class="car-meta">
                    <div><i class="bi bi-hash me-1"></i>Plate: <strong>{{ $car->plate_number }}</strong></div>
                    @if($car->year)
                        <div><i class="bi bi-calendar-event me-1"></i>Year: <strong>{{ $car->year }}</strong></div>
                    @endif
                    </div>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                    <span class="status-pill">
                        <i class="bi bi-circle-fill" style="font-size: 0.65rem;"></i>
                        {{ $car->is_available ? 'Available for booking' : 'Currently unavailable' }}
                    </span>
                    <span class="status-pill">
                        <i class="bi bi-fuel-pump"></i>{{ $fuelType }}
                    </span>
                    <span class="status-pill">
                        <i class="bi bi-speedometer"></i>{{ $mileageText }}
                    </span>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="metric-card">
                            <h6>Daily Rate</h6>
                            <div class="metric-value">${{ number_format($car->daily_rate, 2) }}</div>
                            <small class="text-muted">Includes standard insurance & roadside support</small>
                        </div>
                                </div>
                    @if($car->weekly_rate || $car->monthly_rate)
                    <div class="col-sm-6">
                        <div class="metric-card">
                            <h6>Extended Plans</h6>
                            @if($car->weekly_rate)
                                <div class="metric-value">${{ number_format($car->weekly_rate, 2) }}<span class="fs-6"> / week</span></div>
                            @endif
                            @if($car->monthly_rate)
                                <div class="text-muted fw-semibold mt-1">${{ number_format($car->monthly_rate, 2) }} / month</div>
                            @endif
                            <small class="text-muted d-block mt-1">Ask about long-term discounts</small>
                        </div>
                    </div>
                                        @endif
                                    </div>
                                </div>
            <div class="col-lg-6">
                <div class="car-image-frame">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->full_name }}">
                    @else
                        <div class="text-center text-white">
                            <i class="bi bi-car-front-fill" style="font-size: 4rem;"></i>
                            <p class="mt-3 opacity-75">Image coming soon</p>
                            </div>
                    @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="spec-card mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4>Key Specifications</h4>
                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2">
                        VIN {{ strtoupper(Str::limit($car->plate_number, 8, '…')) }}
                    </span>
                                        </div>
                <div class="spec-grid">
                    <div class="spec-item">
                        <span><i class="bi bi-palette me-1"></i>Exterior</span>
                        <strong>{{ $car->color ?? '—' }}</strong>
                                    </div>
                    <div class="spec-item">
                        <span><i class="bi bi-people me-1"></i>Seating</span>
                        <strong>{{ $car->seats ? $car->seats . ' seats' : '—' }}</strong>
                                </div>
                    <div class="spec-item">
                        <span><i class="bi bi-shift-fill me-1"></i>Transmission</span>
                        <strong>{{ $transmission }}</strong>
                                        </div>
                    <div class="spec-item">
                        <span><i class="bi bi-fuel-pump me-1"></i>Fuel</span>
                        <strong>{{ $fuelType }}</strong>
                                    </div>
                    <div class="spec-item">
                        <span><i class="bi bi-speedometer2 me-1"></i>Mileage</span>
                        <strong>{{ $mileageText }}</strong>
                                </div>
                    <div class="spec-item">
                        <span><i class="bi bi-check2-square me-1"></i>Status</span>
                        <strong>{{ $car->status ? ucfirst($car->status) : '—' }}</strong>
                                    </div>
                                </div>
                            </div>

                            @if($car->description)
            <div class="content-card mb-4">
                <h5>Vehicle Overview</h5>
                <p class="text-secondary lh-lg mb-0">{{ $car->description }}</p>
                            </div>
                            @endif

                            @if($car->features && count($car->features) > 0)
            <div class="content-card mb-4">
                <h5>Included Features</h5>
                <div>
                                                @foreach($car->features as $feature)
                        <span class="feature-pill">
                            <i class="bi bi-check-circle"></i>{{ $feature }}
                        </span>
                                                @endforeach
                                            </div>
                                        </div>
            @endif
                                    </div>
        <div class="col-lg-4">
            <div class="cta-card mb-4">
                <p class="text-uppercase text-white-50 mb-1">Ready to ride</p>
                <h4 class="mb-3">Reserve {{ $car->make }} {{ $car->model }}</h4>
                <ul class="list-unstyled text-white-50 mb-4">
                    <li class="d-flex align-items-center mb-2">
                        <i class="bi bi-shield-check me-2"></i> Comprehensive insurance
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="bi bi-headset me-2"></i> 24/7 roadside assistance
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="bi bi-geo-alt me-2"></i> Free pickup within city limits
                    </li>
                </ul>
                                    @if($car->is_available)
                    <a href="{{ route('reservations.create', ['car_id' => $car->id]) }}" class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-calendar-plus me-2"></i>Reserve now
                                        </a>
                                    @else
                    <button class="btn btn-secondary w-100 mb-2" disabled>
                        <i class="bi bi-x-circle me-2"></i>Not available
                                        </button>
                                    @endif
                <a href="mailto:support@carola.com" class="btn btn-outline-light w-100">
                    <i class="bi bi-chat-dots me-2"></i>Talk to an agent
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 