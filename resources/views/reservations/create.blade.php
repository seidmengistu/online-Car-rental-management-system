@extends('layouts.app')

@section('title', 'Create Reservation')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Reservation</h3>
                    <div class="card-tools">
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Cars
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf
                        
                        <div class="row">
                            <!-- Car Selection -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Select Car</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="car_id">Car *</label>
                                            <select class="form-control @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required>
                                                <option value="">Select a car...</option>
                                                @foreach($availableCars as $availableCar)
                                                    <option value="{{ $availableCar->id }}" 
                                                        {{ (old('car_id', $car->id ?? '') == $availableCar->id) ? 'selected' : '' }}
                                                        data-daily-rate="{{ $availableCar->daily_rate }}">
                                                        {{ $availableCar->full_name }} - ${{ number_format($availableCar->daily_rate, 2) }}/day
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('car_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        @if($car)
                                        <div class="alert alert-info">
                                            <h6>Selected Car Details:</h6>
                                            <p class="mb-1"><strong>{{ $car->full_name }}</strong></p>
                                            <p class="mb-1">Plate: {{ $car->plate_number }}</p>
                                            <p class="mb-1">Color: {{ $car->color }}</p>
                                            <p class="mb-0">Daily Rate: ${{ number_format($car->daily_rate, 2) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Reservation Details -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Reservation Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date *</label>
                                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                                           id="start_date" name="start_date" 
                                                           value="{{ old('start_date') }}" 
                                                           min="{{ date('Y-m-d') }}" required>
                                                    @error('start_date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date">End Date *</label>
                                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                                           id="end_date" name="end_date" 
                                                           value="{{ old('end_date') }}" required>
                                                    @error('end_date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pickup_location">Pickup Location *</label>
                                                    <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" 
                                                           id="pickup_location" name="pickup_location" 
                                                           value="{{ old('pickup_location') }}" 
                                                           placeholder="e.g., Main Office" required>
                                                    @error('pickup_location')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="return_location">Return Location *</label>
                                                    <input type="text" class="form-control @error('return_location') is-invalid @enderror" 
                                                           id="return_location" name="return_location" 
                                                           value="{{ old('return_location') }}" 
                                                           placeholder="e.g., Main Office" required>
                                                    @error('return_location')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="notes">Additional Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      id="notes" name="notes" rows="3" 
                                                      placeholder="Any special requirements or notes...">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cost Calculation -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Cost Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Daily Rate:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="daily_rate_display" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Number of Days:</label>
                                                    <input type="text" class="form-control" id="days_display" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Total Amount:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="total_amount_display" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-calendar-plus"></i> Create Reservation
                                </button>
                                <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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