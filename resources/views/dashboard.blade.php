<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Carola Car Rental | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Carola Car Rental | Dashboard" />
    <meta name="author" content="Carola Car Rental" />
    <meta name="description" content="Customer dashboard for Carola Car Rental system" />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
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
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
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
            <div class="row">
              <!--begin::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box-->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ Auth::user()->reservations()->count() }}</h3>
                    <p>Total Reservations</p>
                  </div>
                  <div class="icon">
                    <i class="bi bi-calendar-check"></i>
                  </div>
                  <a href="{{ route('reservations.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-circle-right"></i>
                  </a>
                </div>
                <!--end::Small Box-->
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box-->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ Auth::user()->rentals()->count() }}</h3>
                    <p>Total Rentals</p>
                  </div>
                  <div class="icon">
                    <i class="bi bi-key"></i>
                  </div>
                  <a href="{{ route('rentals.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-circle-right"></i>
                  </a>
                </div>
                <!--end::Small Box-->
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box-->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ Auth::user()->reservations()->where('status', 'pending')->count() }}</h3>
                    <p>Pending Reservations</p>
                  </div>
                  <div class="icon">
                    <i class="bi bi-clock"></i>
                  </div>
                  <a href="{{ route('reservations.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-circle-right"></i>
                  </a>
                </div>
                <!--end::Small Box-->
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box-->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ Auth::user()->rentals()->where('status', 'active')->count() }}</h3>
                    <p>Active Rentals</p>
                  </div>
                  <div class="icon">
                    <i class="bi bi-car-front"></i>
                  </div>
                  <a href="{{ route('rentals.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-circle-right"></i>
                  </a>
                </div>
                <!--end::Small Box-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-lg-8">
                <!--begin::Card-->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="info-box bg-light">
                          <span class="info-box-icon bg-primary"><i class="bi bi-car-front"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Browse Available Cars</span>
                            <span class="info-box-number">Find your perfect ride</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                              <a href="{{ route('cars.index') }}" class="btn btn-primary btn-sm">Browse Cars</a>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="info-box bg-light">
                          <span class="info-box-icon bg-success"><i class="bi bi-calendar-plus"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Make a Reservation</span>
                            <span class="info-box-number">Book your car today</span>
                            <div class="progress">
                              <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                              <a href="{{ route('cars.index') }}" class="btn btn-success btn-sm">Reserve Now</a>
                            </span>
                      </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--end::Card-->
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-lg-4">
                <!--begin::Card-->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Recent Activity</h3>
                  </div>
                  <div class="card-body">
                    @php
                      $recentReservations = Auth::user()->reservations()->latest()->take(5)->get();
                      $recentRentals = Auth::user()->rentals()->latest()->take(5)->get();
                    @endphp
                    
                    @if($recentReservations->count() > 0 || $recentRentals->count() > 0)
                      <div class="timeline">
                        @foreach($recentReservations->merge($recentRentals)->sortByDesc('created_at')->take(5) as $item)
                          <div class="time-label">
                            <span class="bg-red">{{ $item->created_at->format('M d, Y') }}</span>
                  </div>
                          <div>
                            <i class="bi bi-calendar-check bg-blue"></i>
                            <div class="timeline-item">
                              <span class="time"><i class="bi bi-clock"></i> {{ $item->created_at->format('H:i') }}</span>
                              <h3 class="timeline-header">
                                @if($item instanceof \App\Models\Reservation)
                                  New Reservation
                                @else
                                  New Rental
                                @endif
                              </h3>
                              <div class="timeline-body">
                                @if($item instanceof \App\Models\Reservation)
                                  Reserved {{ $item->car->full_name }} for {{ $item->start_date->format('M d') }} - {{ $item->end_date->format('M d, Y') }}
                        @else
                                  Rented {{ $item->car->full_name }} for {{ $item->start_date->format('M d') }} - {{ $item->end_date->format('M d, Y') }}
                        @endif
                      </div>
                    </div>
                      </div>
                        @endforeach
                      </div>
                    @else
                      <p class="text-muted text-center">No recent activity</p>
                    @endif
                  </div>
                </div>
                <!--end::Card-->
              </div>
              <!--end::Col-->
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