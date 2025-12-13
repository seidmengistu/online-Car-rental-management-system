<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Carola Car Rental | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Carola Car Rental | Dashboard" />
    <meta name="author" content="Carola Car Rental" />
    <meta name="description" content="Customer dashboard for Carola Car Rental system" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />
    <style>
      body { background: #f5f6fb; }
      .hero-card {
        background: linear-gradient(120deg, #2563eb 0%, #7c3aed 70%, #b67dfa 100%);
        color: white;
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 30px 80px rgba(37, 99, 235, 0.3);
        position: relative;
        overflow: hidden;
      }
      .hero-card::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        top: -60px;
        right: -70px;
      }
      .hero-card > * { position: relative; z-index: 2; }
      .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.18);
        font-weight: 600;
      }
      .insight-card {
        border: none;
        border-radius: 1.25rem;
        padding: 1.35rem;
        box-shadow: 0 25px 60px rgba(15,23,42,0.08);
        background: white;
        height: 100%;
      }
      .insight-card span {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
      }
      .insight-card h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.5rem 0;
      }
      .cta-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 20px 50px rgba(15,23,42,0.08);
        height: 100%;
      }
      .cta-card p { color: #6b7280; }
      .timeline-modern .timeline-item {
        border: 1px solid #edf0f7;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: #fff;
      }
    </style>
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('cars.index') }}" class="nav-link">Cars</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('reservations.index') }}" class="nav-link">Reservations</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('rentals.index') }}" class="nav-link">Rentals</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="{{ asset('adminlte/dist/assets/img/user2-160x160.jpg') }}"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="{{ asset('adminlte/dist/assets/img/user2-160x160.jpg') }}"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    {{ Auth::user()->name }} - {{ Auth::user()->role->display_name }}
                    <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Body-->
                <li class="user-body">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="col-4 text-center"><a href="{{ route('reservations.index') }}">Reservations</a></div>
                    <div class="col-4 text-center"><a href="{{ route('rentals.index') }}">Rentals</a></div>
                    <div class="col-4 text-center"><a href="{{ route('profile') }}">Profile</a></div>
                  </div>
                  <!--end::Row-->
                </li>
                <!--end::Menu Body-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
                  </form>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ route('dashboard') }}" class="brand-link">
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Carola</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item menu-open">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('cars.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-car-front"></i>
                  <p>Browse Cars</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('reservations.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-calendar-check"></i>
                  <p>My Reservations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rentals.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-key"></i>
                  <p>My Rentals</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('profile') }}" class="nav-link">
                  <i class="nav-icon bi bi-person"></i>
                  <p>Profile</p>
                </a>
              </li>
              @if(Auth::user()->isStaff() || Auth::user()->isManager())
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                  <i class="nav-icon bi bi-gear"></i>
                  <p>Admin Panel</p>
                </a>
              </li>
              @endif
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="hero-card mb-4">
              <div class="d-flex flex-wrap gap-3 align-items-center">
                <div>
                  <span class="status-pill">
                    <i class="bi bi-speedometer2"></i>
                    Personal dashboard
                  </span>
                  <h1 class="mt-2 mb-1">Welcome back, {{ Auth::user()->name }}.</h1>
                  <p class="mb-0 text-white-75">Track reservations, stay on top of rentals, and plan your next trip.</p>
                </div>
                <div class="ms-auto text-end">
                  <small class="text-uppercase text-white-50">Member since</small>
                  <h3 class="mb-0">{{ Auth::user()->created_at->format('M d, Y') }}</h3>
              </div>
              </div>
            </div>
          </div>
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
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
            <div class="row g-3 mb-4">
              <div class="col-md-3 col-6">
                <div class="insight-card">
                  <span>Total reservations</span>
                    <h3>{{ Auth::user()->reservations()->count() }}</h3>
                  <small class="text-muted">Lifetime</small>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="insight-card">
                  <span>Total rentals</span>
                    <h3>{{ Auth::user()->rentals()->count() }}</h3>
                  <small class="text-muted">Completed + active</small>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="insight-card">
                  <span>Pending reservations</span>
                    <h3>{{ Auth::user()->reservations()->where('status', 'pending')->count() }}</h3>
                  <small class="text-warning">Awaiting confirmation</small>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="insight-card">
                  <span>Active rentals</span>
                    <h3>{{ Auth::user()->rentals()->where('status', 'active')->count() }}</h3>
                  <small class="text-success">In progress</small>
                </div>
              </div>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-4">
              <div class="col-lg-8">
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="card cta-card">
                  <div class="card-body">
                        <h5>Browse cars</h5>
                        <p>Discover vehicles by brand, size, and perks—all in one place.</p>
                        <a href="{{ route('cars.index') }}" class="btn btn-primary w-100">
                          <i class="bi bi-car-front me-2"></i>Browse cars
                        </a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                    <div class="card cta-card">
                      <div class="card-body">
                        <h5>Plan a trip</h5>
                        <p>Reserve a vehicle for your upcoming travel dates in seconds.</p>
                        <a href="{{ route('reservations.create') }}" class="btn btn-success w-100">
                          <i class="bi bi-calendar-plus me-2"></i>Create reservation
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card detail-card mb-4">
                  <div class="card-header">
                    <h5 class="card-title mb-0">Language</h5>
                  </div>
                  <div class="card-body">
                    <p class="text-muted mb-2">Switch between English and Amharic instantly.</p>
                    <div id="google_translate_element_dashboard"></div>
                  </div>
                </div>
                <div class="card detail-card">
                  <div class="card-header">
                    <h5 class="card-title mb-0">Recent activity</h5>
                  </div>
                  <div class="card-body">
                    @php
                      $recentReservations = Auth::user()->reservations()->latest()->take(5)->get();
                      $recentRentals = Auth::user()->rentals()->latest()->take(5)->get();
                      $recentItems = $recentReservations->concat($recentRentals)->sortByDesc('created_at')->take(6);
                    @endphp
                    @if($recentItems->count())
                      <div class="timeline-modern">
                        @foreach($recentItems as $item)
                            <div class="timeline-item">
                            <div class="d-flex justify-content-between">
                              <strong>
                                @if($item instanceof \App\Models\Reservation)
                                  Reservation
                                @else
                                  Rental
                                @endif
                              </strong>
                              <small class="text-muted">{{ $item->created_at->format('M d, H:i') }}</small>
                      </div>
                            <p class="mb-0 text-muted">
                              {{ $item->car->full_name }} — {{ $item->start_date->format('M d') }} to {{ $item->end_date->format('M d, Y') }}
                            </p>
                      </div>
                        @endforeach
                      </div>
                    @else
                      <p class="text-muted text-center mb-0">No recent activity</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::Main-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Footer-->
    <footer class="app-footer">
      <!--begin::To the right-->
      <div class="float-end d-none d-sm-inline">
        Carola Car Rental System
      </div>
      <!--end::To the right-->
      <!--begin::Copyright-->
      <strong>Copyright &copy; 2024 <a href="#">Carola Car Rental</a>.</strong> All rights reserved.
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
    <!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)-->
  </body>
  <!--end::Body-->
</html> 