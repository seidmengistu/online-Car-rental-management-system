@extends('layouts.admin')

@section('title', 'Edit User')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('admin.users.index') }}">Users</a>
<span class="separator">/</span>
<span class="current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit User</h1>
    <p class="page-subtitle">Update information for {{ $user->name }}</p>
</div>

<div class="row g-4">
    <!-- Main Form -->
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            
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
                            <input type="text" class="form-control-modern @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label-modern">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control-modern @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label-modern">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        </div>

                        <div class="col-md-6">
                            <label for="role_id" class="form-label-modern">User Role <span class="text-danger">*</span></label>
                            <select class="form-control-modern @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id) == $role->id) ? 'selected' : '' }}>
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern">Account Status</label>
                            <div class="status-toggle">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                                    <div class="form-check form-switch mb-0">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} style="width: 48px; height: 24px;">
                                    </div>
                                </div>
                            </div>
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

                        <div class="col-md-6">
                            <label for="city" class="form-label-modern">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $user->city) }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="state" class="form-label-modern">State/Province <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state', $user->state) }}" required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label-modern">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-modern @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $user->country) }}" required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- License Fields -->
            <div class="modern-card mt-4" id="license-fields" style="{{ $user->isCustomer() ? '' : 'display: none;' }}">
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
                            <input type="text" class="form-control-modern @error('driving_license_number') is-invalid @enderror" id="driving_license_number" name="driving_license_number" value="{{ old('driving_license_number', $user->driving_license_number) }}">
                            @error('driving_license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="driving_license_expiry" class="form-label-modern">License Expiry Date</label>
                            <input type="date" class="form-control-modern @error('driving_license_expiry') is-invalid @enderror" id="driving_license_expiry" name="driving_license_expiry" value="{{ old('driving_license_expiry', $user->driving_license_expiry ? $user->driving_license_expiry->format('Y-m-d') : '') }}">
                            @error('driving_license_expiry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn-modern btn-modern-primary">
                    <i class="bi bi-check-circle"></i> Update User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-modern btn-modern-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- User Info Card -->
        <div class="modern-card mb-4">
            <div class="modern-card-body text-center">
                <div class="user-avatar-large mx-auto mb-3">
                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
                <h5 class="fw-semibold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ $user->email }}</p>
                <span class="modern-badge modern-badge-{{ $user->is_active ? 'success' : 'secondary' }}">
                    {{ $user->is_active ? 'Active Account' : 'Inactive Account' }}
                </span>
                <div class="mt-3 pt-3 border-top">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="text-muted small">Member Since</div>
                            <div class="fw-semibold">{{ $user->created_at->format('M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Role</div>
                            <div class="fw-semibold">{{ $user->role->display_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reset Password Card -->
        <div class="modern-card mb-4">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-key me-2"></i>
                    Reset Password
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
                @csrf
                @method('PUT')
                <div class="modern-card-body">
                    <div class="mb-3">
                        <label for="reset_password" class="form-label-modern">New Password</label>
                        <input type="password" class="form-control-modern @error('password') is-invalid @enderror" id="reset_password" name="password" placeholder="Enter new password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label-modern">Confirm Password</label>
                        <input type="password" class="form-control-modern" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" class="btn-modern btn-modern-sm w-100" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);">
                        <i class="bi bi-arrow-repeat"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        @if($user->id !== auth()->id())
        <div class="modern-card border-danger">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                <h3 class="modern-card-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Danger Zone
                </h3>
            </div>
            <div class="modern-card-body">
                <p class="text-muted small mb-3">Once you delete a user, there is no going back. Please be certain.</p>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modern btn-modern-danger btn-modern-sm w-100">
                        <i class="bi bi-trash"></i> Delete User
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 28px;
    }

    .status-toggle {
        padding: 12px 16px;
        background: #f9fafb;
        border-radius: 10px;
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

    .border-danger {
        border: 1px solid #fee2e2 !important;
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
    });
</script>
@endpush
@endsection
