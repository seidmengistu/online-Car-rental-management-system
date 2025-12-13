<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'Carola Car Rental')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Carola Car Rental" />
    <meta name="author" content="Carola Car Rental" />
    <meta name="description" content="Carola Car Rental System" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />
    @stack('styles')
  </head>
  <body class="layout-fixed fixed-header sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <!-- Header -->
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto align-items-center gap-2">
            <li class="nav-item d-none d-md-block">
              <div class="nav-link text-muted d-flex align-items-center gap-1">
                <i class="bi bi-translate"></i>
                <div id="google_translate_element_global"></div>
              </div>
            </li>
            @auth
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="{{ asset('adminlte/dist/assets/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow" alt="User Image" />
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <img src="{{ asset('adminlte/dist/assets/img/user2-160x160.jpg') }}" class="rounded-circle shadow" alt="User Image" />
                  <p>
                    {{ Auth::user()->name }} - {{ Auth::user()->role->display_name }}
                    <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                  </p>
                </li>
                <li class="user-body">
                  <div class="row">
                    <div class="col-4 text-center"><a href="{{ route('reservations.index') }}">Reservations</a></div>
                    <div class="col-4 text-center"><a href="{{ route('rentals.index') }}">Rentals</a></div>
                    <div class="col-4 text-center"><a href="{{ route('profile') }}">Profile</a></div>
                  </div>
                </li>
                <li class="user-footer">
                  <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
                  </form>
                </li>
              </ul>
            </li>
            @else
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link">Register</a>
            </li>
            @endauth
          </ul>
        </div>
      </nav>
      <!-- Sidebar -->
      <aside class="app-sidebar bg-body shadow">
        <div class="sidebar-brand">
          <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">Carola</span>
          </a>
        </div>
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <li class="nav-item menu-open">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('cars.index') }}" class="nav-link {{ request()->routeIs('cars.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-car-front"></i>
                  <p>Browse Cars</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('reservations.index') }}" class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-calendar-check"></i>
                  <p>My Reservations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rentals.index') }}" class="nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-key"></i>
                  <p>My Rentals</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-person"></i>
                  <p>Profile</p>
                </a>
              </li>
              @if(Auth::user() && (Auth::user()->isStaff() || Auth::user()->isManager()))
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                  <i class="nav-icon bi bi-gear"></i>
                  <p>Admin Panel</p>
                </a>
              </li>
              @endif
            </ul>
          </nav>
        </div>
      </aside>
      <!-- Main -->
      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">@yield('title', 'Dashboard')</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  @yield('breadcrumb')
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
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
            @if(session('info'))
              <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @yield('content')
          </div>
        </div>
      </main>
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">
          Carola Car Rental System
        </div>
        <strong>&copy; 2024 <a href="#">Carola Car Rental</a>.</strong> All rights reserved.
      </footer>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <script>
      function initGoogleTranslateWidget() {
        if (window.google && google.translate) {
          const options = { pageLanguage: 'en', includedLanguages: 'en,am', layout: google.translate.TranslateElement.InlineLayout.SIMPLE };
          if (document.getElementById('google_translate_element_global')) {
            new google.translate.TranslateElement(options, 'google_translate_element_global');
          }
          if (document.getElementById('google_translate_element_dashboard')) {
            new google.translate.TranslateElement(options, 'google_translate_element_dashboard');
          }
        }
      }
    </script>
    <script src="https://translate.google.com/translate_a/element.js?cb=initGoogleTranslateWidget"></script>
    @stack('scripts')
  </body>
</html> 