@extends('layouts.app')

@section('title', 'New Reservation')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('reservations.index') }}">Reservations</a>
<span class="separator">/</span>
<span class="current">New Reservation</span>
@endsection

@push('styles')
<style>
    .reservation-create-page {
        padding-bottom: 3rem;
    }

    .reservation-hero {
        background: linear-gradient(120deg, #4338ca 0%, #7c3aed 45%, #a855f7 100%);
        color: white;
        border-radius: 1.25rem;
        padding: 2.25rem;
        box-shadow: 0 30px 55px rgba(67,56,202,0.35);
        margin-bottom: 2rem;
    }

    .hero-icon {
        width: 72px;
        height: 72px;
        border-radius: 1rem;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .reservation-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 25px 45px rgba(15,23,42,0.08);
        height: 100%;
    }

    .reservation-card .card-header {
        border-bottom: 1px solid #edf0f7;
        background: transparent;
    }

    .summary-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        background: #eef2ff;
        color: #4338ca;
        font-weight: 600;
    }

    .cost-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .cost-block {
        border: 1px solid #edf0f7;
        border-radius: 0.9rem;
        padding: 1rem;
        background: #f8fafc;
    }

    .cost-block label {
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .sticky-summary {
        position: sticky;
        top: 90px;
    }
</style>
@endpush

@section('content')
<div class="reservation-create-page container-fluid px-3 px-lg-4">
    <div class="reservation-hero d-flex flex-wrap align-items-center gap-4">
        <div class="hero-icon">
            <i class="bi bi-calendar-plus"></i>
        </div>
        <div>
            <h2 class="mb-1">Create a new reservation</h2>
            <p class="mb-0 text-white-75">Choose your vehicle, set your trip dates, and we’ll take care of the rest.</p>
        </div>
        <div class="ms-auto text-lg-end">
            <span class="summary-chip">
                <i class="bi bi-car-front"></i>
                {{ $availableCars->count() }} cars available
            </span>
                    </div>
                </div>

                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf
        <div class="row g-4">
            <div class="col-xl-7">
                <div class="card reservation-card mb-4">
                                    <div class="card-header">
                        <h5 class="card-title mb-0">Trip details</h5>
                                    </div>
                                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="car_id" class="form-label fw-semibold">Select car *</label>
                                <select class="form-select @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required>
                                    <option value="">Choose a vehicle...</option>
                                                @foreach($availableCars as $availableCar)
                                                    <option value="{{ $availableCar->id }}" 
                                                        {{ (old('car_id', $car->id ?? '') == $availableCar->id) ? 'selected' : '' }}
                                                        data-daily-rate="{{ $availableCar->daily_rate }}">
                                            {{ $availableCar->full_name }} · Br {{ number_format($availableCar->daily_rate, 2) }}/day
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-semibold">Start date *</label>
                                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                                           id="start_date" name="start_date" 
                                       value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-semibold">End date *</label>
                                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            <div class="col-md-6">
                                <label for="pickup_location" class="form-label fw-semibold">Pickup location *</label>
                                                    <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" 
                                       id="pickup_location" name="pickup_location" value="{{ old('pickup_location') }}" 
                                                           placeholder="e.g., Main Office" required>
                                                    @error('pickup_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            <div class="col-md-6">
                                <label for="return_location" class="form-label fw-semibold">Return location *</label>
                                                    <input type="text" class="form-control @error('return_location') is-invalid @enderror" 
                                       id="return_location" name="return_location" value="{{ old('return_location') }}" 
                                                           placeholder="e.g., Main Office" required>
                                                    @error('return_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold">Additional notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                                                      placeholder="Any special requirements or notes...">{{ old('notes') }}</textarea>
                                            @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                            <div class="col-12">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="requires_driver" name="requires_driver" value="1" {{ old('requires_driver') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="requires_driver">
                                        I need a professional driver
                                    </label>
                                </div>
                                <small class="text-muted d-block">Selecting this option lets our team assign a vetted driver for your reservation.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="sticky-summary">
                    <div class="card reservation-card mb-4">
                                    <div class="card-header">
                            <h5 class="card-title mb-0">Cost summary</h5>
                                    </div>
                                    <div class="card-body">
                            <div class="cost-grid">
                                <div class="cost-block">
                                    <label>Daily rate</label>
                                                    <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control" id="daily_rate_display" readonly>
                                                    </div>
                                                </div>
                                <div class="cost-block">
                                    <label>Number of days</label>
                                                    <input type="text" class="form-control" id="days_display" readonly>
                                                </div>
                                <div class="cost-block">
                                    <label>Total amount</label>
                                                    <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control" id="total_amount_display" readonly>
                                    </div>
                                </div>
                            </div>
                            @if($car)
                            <div class="alert alert-info mt-3 mb-0">
                                <h6 class="mb-1">Selected car</h6>
                                <p class="mb-0">{{ $car->full_name }} · Plate {{ $car->plate_number }}</p>
                            </div>
                            @endif
                            <small class="text-muted d-block mt-3">After submitting, you can complete payment securely online and download your receipt instantly.</small>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-calendar-plus me-2"></i>Create reservation
                        </button>
                        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary flex-fill">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carSelect = document.getElementById('car_id');
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const dailyRateDisplay = document.getElementById('daily_rate_display');
    const daysDisplay = document.getElementById('days_display');
    const totalAmountDisplay = document.getElementById('total_amount_display');

    function calculateCost() {
        const selectedOption = carSelect.options[carSelect.selectedIndex];
        const dailyRate = selectedOption.dataset.dailyRate || 0;
        
        dailyRateDisplay.value = parseFloat(dailyRate).toFixed(2);
        
        if (startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
            
            daysDisplay.value = days;
            totalAmountDisplay.value = (dailyRate * days).toFixed(2);
        } else {
            daysDisplay.value = '';
            totalAmountDisplay.value = '';
        }
    }

    carSelect.addEventListener('change', calculateCost);
    startDate.addEventListener('change', calculateCost);
    endDate.addEventListener('change', calculateCost);

    // Set minimum end date based on start date
    startDate.addEventListener('change', function() {
        if (this.value) {
            const minEndDate = new Date(this.value);
            minEndDate.setDate(minEndDate.getDate() + 1);
            endDate.min = minEndDate.toISOString().split('T')[0];
        }
    });

    // Initialize calculation if car is pre-selected
    if (carSelect.value) {
        calculateCost();
    }
});
</script>
@endpush
@endsection 