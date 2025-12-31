@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('title', 'Profile')

@push('styles')
  <style>
    .profile-page {
      padding-bottom: 3rem;
    }

    .profile-hero {
      border: none;
      border-radius: 1.25rem;
      background: linear-gradient(120deg, #2563eb 0%, #7c3aed 60%, #a855f7 100%);
      color: white;
      padding: 2.25rem;
      box-shadow: 0 30px 55px rgba(37, 99, 235, 0.35);
      margin-bottom: 2rem;
    }

    .profile-avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 700;
    }

    .profile-stat-card {
      border: none;
      border-radius: 1rem;
      background: white;
      padding: 1.25rem;
      box-shadow: 0 18px 40px rgba(15, 23, 42, 0.07);
      height: 100%;
    }

    .profile-stat-card span {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #94a3b8;
    }

    .profile-stat-card strong {
      display: block;
      margin-top: 0.35rem;
      font-size: 1.4rem;
      color: #0f172a;
    }

    .profile-card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 25px 45px rgba(15, 23, 42, 0.08);
    }

    .profile-card .card-header {
      border-bottom: 1px solid #edf0f7;
      background: transparent;
    }

    .profile-card .card-body {
      padding: 1.75rem;
    }

    .form-label {
      font-weight: 600;
      color: #475569;
    }

    .profile-divider {
      border-color: #edf0f7;
    }
  </style>
@endpush

@section('content')
  @php
    $user = Auth::user();
    $initial = strtoupper(substr($user->name, 0, 1));
  @endphp
  <div class="profile-page container-fluid px-3 px-lg-4">
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

    <div class="profile-hero">
      <div class="d-flex flex-wrap align-items-center gap-4">
        <div class="profile-avatar">{{ $initial }}</div>
        <div>
          <h2 class="mb-1">{{ $user->name }}</h2>
          <p class="mb-2 text-white-50">{{ $user->email }}</p>
          <span class="badge bg-white text-primary fw-semibold px-3 py-2">
            {{ $user->role->display_name }}
          </span>
        </div>
        <div class="ms-auto text-lg-end">
          <p class="mb-1 text-uppercase text-white-50 small">Member since</p>
          <h5 class="mb-0">{{ $user->created_at->format('M d, Y') }}</h5>
          <small class="text-white-50">Last updated {{ $user->updated_at->format('M d, Y') }}</small>
        </div>
      </div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="profile-stat-card">
          <span>Status</span>
          <strong>{{ $user->is_active ? 'Active' : 'Inactive' }}</strong>
          <small class="text-muted">Account state</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="profile-stat-card">
          <span>Phone</span>
          <strong>{{ $user->phone ?? '—' }}</strong>
          <small class="text-muted">Primary contact</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="profile-stat-card">
          <span>Location</span>
          <strong>{{ $user->city ?? '—' }}, {{ $user->country ?? '' }}</strong>
          <small class="text-muted">Mailing address</small>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-xl-7">
        <div class="card profile-card">
          <div class="card-header">
            <h3 class="card-title mb-0">Profile Information</h3>
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

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="name" class="form-label">Full Name</label>
                  <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required>
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $user->phone) }}" required>
                  @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                  <label for="city" class="form-label">City</label>
                  <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror"
                    value="{{ old('city', $user->city) }}" required>
                  @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                  <label for="state" class="form-label">State</label>
                  <input type="text" id="state" name="state" class="form-control @error('state') is-invalid @enderror"
                    value="{{ old('state', $user->state) }}" required>
                  @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                  <label for="country" class="form-label">Country</label>
                  <input type="text" id="country" name="country"
                    class="form-control @error('country') is-invalid @enderror"
                    value="{{ old('country', $user->country) }}" required>
                  @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="driving_license_number" class="form-label">Driving License Number</label>
                  <input type="text" id="driving_license_number" name="driving_license_number"
                    class="form-control @error('driving_license_number') is-invalid @enderror"
                    value="{{ old('driving_license_number', $user->driving_license_number) }}">
                  @error('driving_license_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="driving_license_expiry" class="form-label">License Expiry Date</label>
                  <input type="date" id="driving_license_expiry" name="driving_license_expiry"
                    class="form-control @error('driving_license_expiry') is-invalid @enderror"
                    value="{{ old('driving_license_expiry', $user->driving_license_expiry ? $user->driving_license_expiry->format('Y-m-d') : '') }}">
                  @error('driving_license_expiry')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                   <label for="id_document" class="form-label">ID Document (Upload to update)</label>
                   @if($user->id_document_path)
                       <div class="mb-2">
                           <a href="{{ asset('storage/' . $user->id_document_path) }}" target="_blank" class="text-primary">
                               <i class="bi bi-file-earmark-person"></i> View Current ID
                           </a>
                       </div>
                   @endif
                   <input type="file" id="id_document" name="id_document" class="form-control @error('id_document') is-invalid @enderror" 
                          accept=".jpg,.jpeg,.png,.pdf">
                    <div class="form-text">Max 2MB. Format: JPG, PNG, PDF</div>
                   @error('id_document')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-circle me-1"></i>Update Profile
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-xl-5">
        <div class="card profile-card mb-4">
          <div class="card-header">
            <h3 class="card-title mb-0">Change Password</h3>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('profile.password') }}">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                  class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password"
                  class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                  class="form-control" required>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-warning">
                  <i class="bi bi-key me-1"></i>Change Password
                </button>
              </div>
            </form>
          </div>
        </div>

        <div class="card profile-card">
          <div class="card-header">
            <h3 class="card-title mb-0">Account Information</h3>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-6">
                <span class="text-muted text-uppercase small">Role</span>
                <p class="mb-0 fw-semibold">{{ $user->role->display_name }}</p>
              </div>
              <div class="col-6">
                <span class="text-muted text-uppercase small">Status</span>
                <p class="mb-0 fw-semibold {{ $user->is_active ? 'text-success' : 'text-danger' }}">
                  {{ $user->is_active ? 'Active' : 'Inactive' }}
                </p>
              </div>
            </div>
            <hr class="profile-divider">
            <div class="row mb-3">
              <div class="col-6">
                <span class="text-muted text-uppercase small">Member Since</span>
                <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
              </div>
              <div class="col-6">
                <span class="text-muted text-uppercase small">Last Updated</span>
                <p class="mb-0">{{ $user->updated_at->format('M d, Y') }}</p>
              </div>
            </div>
            <div class="bg-light rounded-3 p-3 mt-3">
              <p class="mb-1 fw-semibold">Need help?</p>
              <p class="text-muted mb-2">Contact support if you notice unusual activity on your account.</p>
              <a href="mailto:support@carola.com" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-envelope me-1"></i>support@zerihuncarrental.com
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection