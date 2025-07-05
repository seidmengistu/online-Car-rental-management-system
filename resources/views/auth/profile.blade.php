@extends('layouts.app')

@section('title', 'Profile')

@section('content')
          <div class="container-fluid">
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            <!--begin::Row-->
            <div class="row">
              <div class="col-md-6">
                <!--begin::Card-->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Profile Information</h3>
                  </div>
                  <div class="card-body">
                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                      @csrf
                      @method('PUT')
                      
                      <div class="form-group mb-3">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group mb-3">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                        @error('phone')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                               id="address" name="address" value="{{ old('address', Auth::user()->address) }}" required>
                        @error('address')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group mb-3">
                            <label for="city">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city', Auth::user()->city) }}" required>
                            @error('city')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group mb-3">
                            <label for="state">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state', Auth::user()->state) }}" required>
                            @error('state')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group mb-3">
                            <label for="zip_code">ZIP Code</label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                                   id="zip_code" name="zip_code" value="{{ old('zip_code', Auth::user()->zip_code) }}" required>
                            @error('zip_code')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group mb-3">
                            <label for="country">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                   id="country" name="country" value="{{ old('country', Auth::user()->country) }}" required>
                            @error('country')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group mb-3">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}" required>
                            @error('date_of_birth')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group mb-3">
                            <label for="driving_license_number">Driving License Number</label>
                            <input type="text" class="form-control @error('driving_license_number') is-invalid @enderror" 
                                   id="driving_license_number" name="driving_license_number" 
                                   value="{{ old('driving_license_number', Auth::user()->driving_license_number) }}" required>
                            @error('driving_license_number')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group mb-3">
                            <label for="driving_license_expiry">License Expiry Date</label>
                            <input type="date" class="form-control @error('driving_license_expiry') is-invalid @enderror" 
                                   id="driving_license_expiry" name="driving_license_expiry" 
                                   value="{{ old('driving_license_expiry', Auth::user()->driving_license_expiry) }}" required>
                            @error('driving_license_expiry')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                          <i class="bi bi-check-circle me-1"></i>Update Profile
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
                <!--end::Card-->
              </div>
            
              <div class="col-md-6 ">
                <!--begin::Card-->
                <div class="card mb-5">
                  <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="{{ route('profile.password') }}">
                      @csrf
                      @method('PUT')
                      
                      <div class="form-group mb-3">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group mb-3">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" name="new_password" required>
                        @error('new_password')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group mb-3">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" 
                               id="new_password_confirmation" name="new_password_confirmation" required>
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-warning">
                          <i class="bi bi-key me-1"></i>Change Password
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
                <!--end::Card-->

                <!--begin::Card-->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Account Information</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <strong>Role:</strong><br>
                        <span class="badge bg-secondary">{{ Auth::user()->role->display_name }}</span>
                      </div>
                      <div class="col-6">
                        <strong>Status:</strong><br>
                        <span class="badge {{ Auth::user()->is_active ? 'bg-success' : 'bg-danger' }}">
                          {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                        </span>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-6">
                        <strong>Member Since:</strong><br>
                        <small class="text-muted">{{ Auth::user()->created_at->format('M d, Y') }}</small>
                      </div>
                      <div class="col-6">
                        <strong>Last Updated:</strong><br>
                        <small class="text-muted">{{ Auth::user()->updated_at->format('M d, Y') }}</small>
                      </div>
                    </div>
                  </div>
                </div>
                <!--end::Card-->
              </div>
            </div>
            <!--end::Row-->
          </div>
@endsection
         