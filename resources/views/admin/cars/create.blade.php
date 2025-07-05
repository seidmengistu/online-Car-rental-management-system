@extends('layouts.admin')

@section('title', 'Add New Car')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.cars.index') }}">Car Management</a></li>
<li class="breadcrumb-item active">Add New Car</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3">Add New Car</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Car Details</h3>
        </div>
        <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="plate_number">License Plate Number</label>
                            <input type="text" class="form-control @error('plate_number') is-invalid @enderror" id="plate_number" name="plate_number" value="{{ old('plate_number') }}" required>
                            @error('plate_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="make">Make</label>
                                    <input type="text" class="form-control @error('make') is-invalid @enderror" id="make" name="make" value="{{ old('make') }}" required>
                                    @error('make')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="model">Model</label>
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model') }}" required>
                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="year">Year</label>
                                    <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="color">Color</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color') }}" required>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="seats">Seats</label>
                                    <input type="number" class="form-control @error('seats') is-invalid @enderror" id="seats" name="seats" value="{{ old('seats', 5) }}" min="1" max="50" required>
                                    @error('seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="mileage">Mileage</label>
                                    <input type="number" class="form-control @error('mileage') is-invalid @enderror" id="mileage" name="mileage" value="{{ old('mileage', 0) }}" min="0">
                                    @error('mileage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="fuel_type">Fuel Type</label>
                                    <select class="form-control @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type" required>
                                        <option value="gasoline" {{ old('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                        <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                    @error('fuel_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="transmission">Transmission</label>
                                    <select class="form-control @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                                        <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                        <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                    </select>
                                    @error('transmission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="daily_rate">Daily Rate ($)</label>
                                    <input type="number" class="form-control @error('daily_rate') is-invalid @enderror" id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" min="0" step="0.01" required>
                                    @error('daily_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="weekly_rate">Weekly Rate ($)</label>
                                    <input type="number" class="form-control @error('weekly_rate') is-invalid @enderror" id="weekly_rate" name="weekly_rate" value="{{ old('weekly_rate') }}" min="0" step="0.01">
                                    @error('weekly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="monthly_rate">Monthly Rate ($)</label>
                                    <input type="number" class="form-control @error('monthly_rate') is-invalid @enderror" id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate') }}" min="0" step="0.01">
                                    @error('monthly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Car Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            <small class="form-text text-muted">Upload an image of the car (max 2MB).</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">Available for Rent</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Features</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_ac" name="features[]" value="air_conditioning" {{ in_array('air_conditioning', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_ac">Air Conditioning</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_nav" name="features[]" value="navigation" {{ in_array('navigation', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_nav">Navigation System</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_bluetooth" name="features[]" value="bluetooth" {{ in_array('bluetooth', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_bluetooth">Bluetooth</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_sunroof" name="features[]" value="sunroof" {{ in_array('sunroof', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_sunroof">Sunroof</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_leather" name="features[]" value="leather_seats" {{ in_array('leather_seats', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_leather">Leather Seats</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_cruise" name="features[]" value="cruise_control" {{ in_array('cruise_control', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_cruise">Cruise Control</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_camera" name="features[]" value="backup_camera" {{ in_array('backup_camera', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_camera">Backup Camera</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="feature_parking" name="features[]" value="parking_sensors" {{ in_array('parking_sensors', old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_parking">Parking Sensors</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add Car</button>
                <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-calculate weekly and monthly rates based on daily rate
        const dailyRateInput = document.getElementById('daily_rate');
        const weeklyRateInput = document.getElementById('weekly_rate');
        const monthlyRateInput = document.getElementById('monthly_rate');
        
        dailyRateInput.addEventListener('input', function() {
            const dailyRate = parseFloat(this.value) || 0;
            weeklyRateInput.value = (dailyRate * 6).toFixed(2); // 1 day free
            monthlyRateInput.value = (dailyRate * 25).toFixed(2); // 5 days free
        });
    });
</script>
@endpush
@endsection 