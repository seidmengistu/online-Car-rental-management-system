@extends('layouts.admin')

@section('title', 'Edit Vehicle')

@section('breadcrumb')
    <span class="separator">/</span>
    <a href="{{ route('admin.cars.index') }}">Vehicles</a>
    <span class="separator">/</span>
    <span class="current">Edit</span>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Vehicle</h1>
        <p class="page-subtitle">Update information for {{ $car->make }} {{ $car->model }}</p>
    </div>

    <form method="POST" action="{{ route('admin.cars.update', $car) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="modern-card">
                    <div class="modern-card-header">
                        <h3 class="modern-card-title">
                            <i class="bi bi-car-front me-2"></i>
                            Vehicle Information
                        </h3>
                    </div>
                    <div class="modern-card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="plate_number" class="form-label-modern">License Plate <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control-modern @error('plate_number') is-invalid @enderror"
                                    id="plate_number" name="plate_number"
                                    value="{{ old('plate_number', $car->plate_number) }}" required>
                                @error('plate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="make" class="form-label-modern">Make <span class="text-danger">*</span></label>
                                <input type="text" class="form-control-modern @error('make') is-invalid @enderror" id="make"
                                    name="make" value="{{ old('make', $car->make) }}" required>
                                @error('make')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="model" class="form-label-modern">Model <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control-modern @error('model') is-invalid @enderror"
                                    id="model" name="model" value="{{ old('model', $car->model) }}" required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="year" class="form-label-modern">Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control-modern @error('year') is-invalid @enderror"
                                    id="year" name="year" value="{{ old('year', $car->year) }}" min="1900"
                                    max="{{ date('Y') + 1 }}" required>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="color" class="form-label-modern">Color <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control-modern @error('color') is-invalid @enderror"
                                    id="color" name="color" value="{{ old('color', $car->color) }}" required>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="seats" class="form-label-modern">Seats <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control-modern @error('seats') is-invalid @enderror"
                                    id="seats" name="seats" value="{{ old('seats', $car->seats) }}" min="1" max="50"
                                    required>
                                @error('seats')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="mileage" class="form-label-modern">Mileage</label>
                                <input type="number" class="form-control-modern @error('mileage') is-invalid @enderror"
                                    id="mileage" name="mileage" value="{{ old('mileage', $car->mileage) }}" min="0">
                                @error('mileage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="fuel_type" class="form-label-modern">Fuel Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-control-modern @error('fuel_type') is-invalid @enderror" id="fuel_type"
                                    name="fuel_type" required>
                                    <option value="gasoline" {{ old('fuel_type', $car->fuel_type) == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                    <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="electric" {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('fuel_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="transmission" class="form-label-modern">Transmission <span
                                        class="text-danger">*</span></label>
                                <select class="form-control-modern @error('transmission') is-invalid @enderror"
                                    id="transmission" name="transmission" required>
                                    <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                                </select>
                                @error('transmission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label-modern">Description</label>
                                <textarea class="form-control-modern @error('description') is-invalid @enderror"
                                    id="description" name="description"
                                    rows="3">{{ old('description', $car->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Card -->
                <div class="modern-card mt-4">
                    <div class="modern-card-header">
                        <h3 class="modern-card-title">
                            <i class="bi bi-stars me-2"></i>
                            Features
                        </h3>
                    </div>
                    <div class="modern-card-body">
                        @php
                            $features = old('features', $car->features ?? []);
                            if (!is_array($features)) {
                                $features = [];
                            }
                        @endphp
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_ac" name="features[]"
                                        value="air_conditioning" {{ in_array('air_conditioning', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_ac">
                                        <i class="bi bi-snow"></i>
                                        Air Conditioning
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_nav" name="features[]"
                                        value="navigation" {{ in_array('navigation', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_nav">
                                        <i class="bi bi-geo-alt"></i>
                                        Navigation
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_bluetooth" name="features[]"
                                        value="bluetooth" {{ in_array('bluetooth', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_bluetooth">
                                        <i class="bi bi-bluetooth"></i>
                                        Bluetooth
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_sunroof" name="features[]"
                                        value="sunroof" {{ in_array('sunroof', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_sunroof">
                                        <i class="bi bi-sun"></i>
                                        Sunroof
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_leather" name="features[]"
                                        value="leather_seats" {{ in_array('leather_seats', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_leather">
                                        <i class="bi bi-star"></i>
                                        Leather Seats
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_cruise" name="features[]"
                                        value="cruise_control" {{ in_array('cruise_control', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_cruise">
                                        <i class="bi bi-speedometer2"></i>
                                        Cruise Control
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_camera" name="features[]"
                                        value="backup_camera" {{ in_array('backup_camera', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_camera">
                                        <i class="bi bi-camera-video"></i>
                                        Backup Camera
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-checkbox">
                                    <input type="checkbox" class="form-check-input" id="feature_parking" name="features[]"
                                        value="parking_sensors" {{ in_array('parking_sensors', $features) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_parking">
                                        <i class="bi bi-radar"></i>
                                        Parking Sensors
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn-modern btn-modern-success">
                        <i class="bi bi-check-circle"></i> Update Vehicle
                    </button>
                    <a href="{{ route('admin.cars.index') }}" class="btn-modern btn-modern-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Vehicle Preview -->
                <div class="modern-card mb-4">
                    <div class="modern-card-body text-center">
                        <div class="car-preview mb-3">
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->full_name }}">
                            @else
                                <i class="bi bi-car-front"></i>
                            @endif
                        </div>
                        <h5 class="fw-semibold mb-1">{{ $car->make }} {{ $car->model }}</h5>
                        <p class="text-muted small mb-3">{{ $car->year }} • {{ $car->color }}</p>
                        <span class="modern-badge modern-badge-{{ $car->is_available ? 'success' : 'secondary' }}">
                            {{ $car->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                        <div class="mt-3 pt-3 border-top">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="text-muted small">Daily Rate</div>
                                    <div class="fw-semibold">Br {{ number_format($car->daily_rate, 2) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Plate</div>
                                    <div class="fw-semibold">{{ $car->plate_number }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="modern-card mb-4">
                    <div class="modern-card-header">
                        <h3 class="modern-card-title">
                            Pricing
                        </h3>
                    </div>
                    <div class="modern-card-body">
                        <div class="mb-4">
                            <label for="daily_rate" class="form-label-modern">Daily Rate (Br) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control-modern @error('daily_rate') is-invalid @enderror"
                                id="daily_rate" name="daily_rate" value="{{ old('daily_rate', $car->daily_rate) }}" min="0"
                                step="0.01" required>
                            @error('daily_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="weekly_rate" class="form-label-modern">Weekly Rate (Br)</label>
                            <input type="number" class="form-control-modern @error('weekly_rate') is-invalid @enderror"
                                id="weekly_rate" name="weekly_rate" value="{{ old('weekly_rate', $car->weekly_rate) }}"
                                min="0" step="0.01">
                            @error('weekly_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="monthly_rate" class="form-label-modern">Monthly Rate (Br)</label>
                            <input type="number" class="form-control-modern @error('monthly_rate') is-invalid @enderror"
                                id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate', $car->monthly_rate) }}"
                                min="0" step="0.01">
                            @error('monthly_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status & Image Card -->
                <div class="modern-card">
                    <div class="modern-card-header">
                        <h3 class="modern-card-title">
                            <i class="bi bi-sliders me-2"></i>
                            Status & Image
                        </h3>
                    </div>
                    <div class="modern-card-body">
                        <div class="mb-4">
                            <label for="status" class="form-label-modern">Vehicle Status <span
                                    class="text-danger">*</span></label>
                            <select class="form-control-modern @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="available" {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>
                                    Available</option>
                                <option value="maintenance" {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="rented" {{ old('status', $car->status) == 'rented' ? 'selected' : '' }}>Rented
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="status-toggle">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fw-semibold">Available for Rent</div>
                                        <div class="text-muted small">Show in rental listings</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="is_available"
                                            name="is_available" value="1" {{ old('is_available', $car->is_available) ? 'checked' : '' }} style="width: 48px; height: 24px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="image" class="form-label-modern">Update Image</label>
                            <input type="file" class="form-control-modern @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            <div class="text-muted small mt-2">Leave empty to keep current image</div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('styles')
        <style>
            .car-preview {
                width: 120px;
                height: 120px;
                border-radius: 20px;
                background: #f3f4f6;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                overflow: hidden;
            }

            .car-preview img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .car-preview i {
                font-size: 48px;
                color: #9ca3af;
            }

            .feature-checkbox {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 14px;
                background: #f9fafb;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .feature-checkbox:hover {
                background: #f3f4f6;
            }

            .feature-checkbox .form-check-input {
                margin: 0;
                width: 20px;
                height: 20px;
            }

            .feature-checkbox .form-check-input:checked {
                background-color: #10b981;
                border-color: #10b981;
            }

            .feature-checkbox label {
                display: flex;
                align-items: center;
                gap: 8px;
                margin: 0;
                cursor: pointer;
                font-size: 13px;
                font-weight: 500;
                color: #374151;
            }

            .feature-checkbox label i {
                font-size: 16px;
                color: #6b7280;
            }

            .status-toggle {
                padding: 16px;
                background: #f9fafb;
                border-radius: 12px;
            }

            .form-check-input:checked {
                background-color: #10b981;
                border-color: #10b981;
            }

            .is-invalid {
                border-color: #ef4444 !important;
            }

            .invalid-feedback {
                color: #ef4444;
                font-size: 13px;
                margin-top: 6px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dailyRateInput = document.getElementById('daily_rate');
                const weeklyRateInput = document.getElementById('weekly_rate');
                const monthlyRateInput = document.getElementById('monthly_rate');

                dailyRateInput.addEventListener('input', function () {
                    const dailyRate = parseFloat(this.value) || 0;
                    weeklyRateInput.value = (dailyRate * 6).toFixed(2);
                    monthlyRateInput.value = (dailyRate * 25).toFixed(2);
                });
            });
        </script>
    @endpush
@endsection