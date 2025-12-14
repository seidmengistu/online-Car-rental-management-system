@extends('layouts.admin')

@section('title', 'Create User')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('admin.users.index') }}">Users</a>
<span class="separator">/</span>
<span class="current">Create</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Create New User</h1>
    <p class="page-subtitle">Add a new user account to the system</p>
</div>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <div class="row g-4">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="bi bi-person me-2"></i>
                        Account Information
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label-modern">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label-modern">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control-modern @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label-modern">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control-modern @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label-modern">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control-modern" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label-modern">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label-modern">Date of Birth</label>
                            <input type="date" class="form-control-modern @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="modern-card mt-4">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="bi bi-geo-alt me-2"></i>
                        Address Information
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="address" class="form-label-modern">Street Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="Enter street address" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="city" class="form-label-modern">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" placeholder="Enter city" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="state" class="form-label-modern">State/Province <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" placeholder="Enter state" required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="zip_code" class="form-label-modern">ZIP/Postal Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="Enter ZIP code" required>
                            @error('zip_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label-modern">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" placeholder="Enter country" required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- License Fields (for customers) -->
            <div class="modern-card mt-4" id="license-fields" style="display: none;">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="bi bi-card-text me-2"></i>
                        Driving License
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="driving_license_number" class="form-label-modern">License Number</label>
                            <input type="text" class="form-control-modern @error('driving_license_number') is-invalid @enderror" id="driving_license_number" name="driving_license_number" value="{{ old('driving_license_number') }}" placeholder="Enter license number">
                            @error('driving_license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="driving_license_expiry" class="form-label-modern">License Expiry Date</label>
                            <input type="date" class="form-control-modern @error('driving_license_expiry') is-invalid @enderror" id="driving_license_expiry" name="driving_license_expiry" value="{{ old('driving_license_expiry') }}">
                            @error('driving_license_expiry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="bi bi-shield-check me-2"></i>
                        Role & Status
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div class="mb-4">
                        <label for="role_id" class="form-label-modern">User Role <span class="text-danger">*</span></label>
                        <select class="form-control-modern @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="status-toggle">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold">Account Status</div>
                                <div class="text-muted small">Enable or disable this account</div>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} style="width: 48px; height: 24px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modern-card mt-4">
                <div class="modern-card-body">
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn-modern btn-modern-primary">
                            <i class="bi bi-check-circle"></i> Create User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn-modern btn-modern-secondary text-center">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
    .status-toggle {
        padding: 16px;
        background: #f9fafb;
        border-radius: 12px;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
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
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role_id');
        const licenseFields = document.getElementById('license-fields');
        
        function toggleLicenseFields() {
            if (roleSelect.options[roleSelect.selectedIndex].text.toLowerCase() === 'customer') {
                licenseFields.style.display = 'block';
            } else {
                licenseFields.style.display = 'none';
            }
        }
        
        roleSelect.addEventListener('change', toggleLicenseFields);
        toggleLicenseFields();
    });
</script>
@endpush
@endsection
