<!doctype html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>@yield('title', 'EthioRental')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="EthioRental" />
  <meta name="author" content="EthioRental" />
  <meta name="description" content="EthioRental System" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    crossorigin="anonymous" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  @stack('styles')
  <style>
    :root {
      --sidebar-width: 280px;
      --header-height: 70px;
      --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
      --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      --card-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
      --hover-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f8fafc;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Sidebar */
    .customer-sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: var(--sidebar-width);
      height: 100vh;
      background: var(--sidebar-bg);
      z-index: 1000;
      transition: var(--hover-transition);
      overflow-y: auto;
      overflow-x: hidden;
    }

    .customer-sidebar::-webkit-scrollbar {
      width: 4px;
    }

    .customer-sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 4px;
    }

    .sidebar-brand {
      padding: 24px;
      display: flex;
      align-items: center;
      gap: 14px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sidebar-brand-icon {
      width: 48px;
      height: 48px;
      background: var(--primary-gradient);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: white;
      box-shadow: 0 8px 24px rgba(59, 130, 246, 0.35);
    }

    .sidebar-brand-text {
      color: white;
      font-size: 20px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .sidebar-brand-text span {
      color: #60a5fa;
    }

    .sidebar-menu {
      padding: 20px 16px;
    }

    .sidebar-menu-title {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: #64748b;
      padding: 0 16px;
      margin-bottom: 12px;
      margin-top: 24px;
    }

    .sidebar-menu-title:first-child {
      margin-top: 0;
    }

    .sidebar-nav {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-nav-item {
      margin-bottom: 4px;
    }

    .sidebar-nav-link {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 16px;
      color: #94a3b8;
      text-decoration: none;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 500;
      transition: var(--hover-transition);
      position: relative;
      overflow: hidden;
    }

    .sidebar-nav-link::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 0;
      height: 100%;
      background: var(--primary-gradient);
      opacity: 0;
      transition: var(--hover-transition);
      border-radius: 12px;
      z-index: -1;
    }

    .sidebar-nav-link:hover {
      color: white;
    }

    .sidebar-nav-link:hover::before {
      width: 100%;
      opacity: 0.15;
    }

    .sidebar-nav-link.active {
      color: white;
      background: var(--primary-gradient);
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .sidebar-nav-link.active::before {
      display: none;
    }

    .sidebar-nav-icon {
      width: 22px;
      height: 22px;
      font-size: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .sidebar-user {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      background: rgba(0, 0, 0, 0.2);
    }

    .sidebar-user-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .sidebar-user-avatar {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: var(--primary-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 16px;
    }

    .sidebar-user-name {
      color: white;
      font-size: 14px;
      font-weight: 600;
    }

    .sidebar-user-role {
      color: #64748b;
      font-size: 12px;
    }

    /* Main Content */
    .customer-main {
      margin-left: var(--sidebar-width);
      min-height: 100vh;
      transition: var(--hover-transition);
    }

    /* Collapsed sidebar (desktop & mobile) */
    /* Collapsed (icon-only) sidebar */
    body.sidebar-collapsed .customer-sidebar {
      width: 80px;
      transform: translateX(0);
    }

    body.sidebar-collapsed .customer-main {
      margin-left: 80px;
    }

    body.sidebar-collapsed .customer-footer {
      left: 80px;
    }

    body.sidebar-collapsed .sidebar-brand-text,
    body.sidebar-collapsed .sidebar-menu-title,
    body.sidebar-collapsed .sidebar-user-name,
    body.sidebar-collapsed .sidebar-user-role {
      display: none;
    }

    body.sidebar-collapsed .sidebar-nav {
      align-items: center;
    }

    body.sidebar-collapsed .sidebar-nav-link {
      justify-content: center;
      padding: 12px;
      gap: 0;
      font-size: 0;
      /* hide text while keeping icons */
    }

    body.sidebar-collapsed .sidebar-nav-link .sidebar-nav-icon {
      font-size: 18px;
    }

    body.sidebar-collapsed .sidebar-user {
      padding: 14px;
    }

    body.sidebar-collapsed .sidebar-user-avatar {
      margin: 0 auto;
    }

    /* Header */
    .customer-header {
      height: var(--header-height);
      background: white;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 24px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .sidebar-toggle {
      display: flex;
      width: 42px;
      height: 42px;
      border: 1px solid #e2e8f0;
      background: #f8fafc;
      border-radius: 12px;
      cursor: pointer;
      font-size: 20px;
      color: #334155;
      transition: var(--hover-transition);
      align-items: center;
      justify-content: center;
      box-shadow: none;
    }

    .sidebar-toggle:hover {
      background: #e7edf5;
    }

    .sidebar-toggle i {
      display: inline-block;
      line-height: 1;
    }

    .header-breadcrumb {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #64748b;
    }

    .header-breadcrumb a {
      color: #64748b;
      text-decoration: none;
      transition: color 0.2s;
    }

    .header-breadcrumb a:hover {
      color: #3b82f6;
    }

    .header-breadcrumb .separator {
      color: #cbd5e1;
    }

    .header-breadcrumb .current {
      color: #0f172a;
      font-weight: 500;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .header-quick-links {
      display: flex;
      gap: 8px;
    }

    .header-quick-link {
      padding: 8px 16px;
      color: #64748b;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      border-radius: 8px;
      transition: var(--hover-transition);
    }

    .header-quick-link:hover {
      color: #3b82f6;
      background: #f1f5f9;
    }

    /* Language Switcher */
    .lang-switcher {
      position: relative;
    }

    .lang-switcher-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      background: #f1f5f9;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      color: #475569;
      cursor: pointer;
      transition: var(--hover-transition);
    }

    .lang-switcher-btn:hover {
      background: #e2e8f0;
    }

    .lang-switcher-btn i:first-child {
      color: #3b82f6;
    }

    .lang-switcher-dropdown {
      position: absolute;
      top: calc(100% + 8px);
      right: 0;
      min-width: 180px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      padding: 8px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: var(--hover-transition);
      z-index: 100;
    }

    .lang-switcher.open .lang-switcher-dropdown {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .lang-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      color: #475569;
      transition: var(--hover-transition);
    }

    .lang-item:hover {
      background: #f1f5f9;
    }

    .lang-item.active {
      background: rgba(59, 130, 246, 0.1);
      color: #3b82f6;
    }

    .lang-item .check {
      display: none;
      color: #3b82f6;
    }

    .lang-item.active .check {
      display: block;
    }

    /* User Dropdown */
    .header-user-dropdown {
      position: relative;
    }

    .header-user-btn {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 6px 12px 6px 6px;
      background: #f1f5f9;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: var(--hover-transition);
    }

    .header-user-btn:hover {
      background: #e2e8f0;
    }

    .header-user-btn .avatar {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: var(--primary-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 14px;
    }

    .header-user-btn span {
      font-size: 14px;
      font-weight: 500;
      color: #475569;
    }

    .header-user-btn i.bi-chevron-down {
      font-size: 12px;
      color: #94a3b8;
    }

    .dropdown-menu-modern {
      min-width: 220px;
      padding: 8px;
      border: none;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .dropdown-menu-modern .dropdown-item {
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 14px;
      color: #475569;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dropdown-menu-modern .dropdown-item:hover {
      background: #f1f5f9;
    }

    .dropdown-menu-modern .dropdown-divider {
      margin: 8px 0;
      border-color: #f1f5f9;
    }

    .user-menu-header {
      padding: 16px;
      text-align: center;
      border-bottom: 1px solid #f1f5f9;
      margin-bottom: 8px;
    }

    .user-menu-header .avatar-lg {
      width: 64px;
      height: 64px;
      border-radius: 16px;
      background: var(--primary-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      font-size: 24px;
      margin: 0 auto 12px;
    }

    .user-menu-header h6 {
      font-size: 15px;
      font-weight: 600;
      color: #0f172a;
      margin-bottom: 4px;
    }

    .user-menu-header span {
      font-size: 13px;
      color: #64748b;
    }

    /* Content Area */
    .customer-content {
      padding: 32px;
      padding-bottom: 100px;
    }

    .page-header {
      margin-bottom: 32px;
    }

    .page-title {
      font-size: 28px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .page-subtitle {
      font-size: 15px;
      color: #64748b;
    }

    /* Alert Styles */
    .alert {
      border: none;
      border-radius: 12px;
      padding: 16px 20px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      font-weight: 500;
    }

    .alert-success {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
    }

    .alert-danger {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #991b1b;
    }

    .alert-info {
      background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
      color: #1e40af;
    }

    .alert-warning {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
      color: #92400e;
    }

    /* Modern Card */
    .modern-card {
      background: white;
      border-radius: 16px;
      box-shadow: var(--card-shadow);
      border: 1px solid rgba(0, 0, 0, 0.04);
      overflow: hidden;
      transition: var(--hover-transition);
    }

    .modern-card:hover {
      box-shadow: 0 10px 50px rgba(0, 0, 0, 0.08);
    }

    .modern-card-header {
      padding: 20px 24px;
      border-bottom: 1px solid #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .modern-card-title {
      font-size: 16px;
      font-weight: 600;
      color: #0f172a;
      margin: 0;
    }

    .modern-card-body {
      padding: 24px;
    }

    /* Stat Cards */
    .stat-card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: var(--card-shadow);
      border: 1px solid rgba(0, 0, 0, 0.04);
      transition: var(--hover-transition);
      position: relative;
      overflow: hidden;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
    }

    .stat-card.primary::before {
      background: var(--primary-gradient);
    }

    .stat-card.success::before {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-card.warning::before {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-card.danger::before {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
    }

    .stat-card-icon {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin-bottom: 16px;
    }

    .stat-card.primary .stat-card-icon {
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
      color: #3b82f6;
    }

    .stat-card.success .stat-card-icon {
      background: rgba(16, 185, 129, 0.12);
      color: #10b981;
    }

    .stat-card.warning .stat-card-icon {
      background: rgba(245, 158, 11, 0.12);
      color: #f59e0b;
    }

    .stat-card.danger .stat-card-icon {
      background: rgba(239, 68, 68, 0.12);
      color: #ef4444;
    }

    .stat-card-value {
      font-size: 32px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 6px;
      letter-spacing: -1px;
    }

    .stat-card-label {
      font-size: 14px;
      color: #64748b;
      font-weight: 500;
    }

    /* Modern Badge */
    .modern-badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 12px;
      font-size: 12px;
      font-weight: 600;
      border-radius: 20px;
    }

    .modern-badge-primary {
      background: rgba(59, 130, 246, 0.1);
      color: #3b82f6;
    }

    .modern-badge-success {
      background: rgba(16, 185, 129, 0.1);
      color: #059669;
    }

    .modern-badge-warning {
      background: rgba(245, 158, 11, 0.1);
      color: #d97706;
    }

    .modern-badge-danger {
      background: rgba(239, 68, 68, 0.1);
      color: #dc2626;
    }

    /* Modern Buttons */
    .btn-modern {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      font-size: 14px;
      font-weight: 500;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      transition: var(--hover-transition);
      text-decoration: none;
    }

    .btn-modern-primary {
      background: var(--primary-gradient);
      color: white;
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.35);
    }

    .btn-modern-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
      color: white;
    }

    .btn-modern-secondary {
      background: #f1f5f9;
      color: #475569;
    }

    .btn-modern-secondary:hover {
      background: #e2e8f0;
      color: #0f172a;
    }

    /* Footer */
    .customer-footer {
      position: fixed;
      bottom: 0;
      left: var(--sidebar-width);
      right: 0;
      padding: 16px 32px;
      background: white;
      border-top: 1px solid #e2e8f0;
      font-size: 13px;
      color: #64748b;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 50;
    }

    .customer-footer a {
      color: #3b82f6;
      text-decoration: none;
      font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .customer-sidebar {
        transform: translateX(-100%);
      }

      .customer-sidebar.show {
        transform: translateX(0);
      }

      .customer-main {
        margin-left: 0;
      }

      .customer-footer {
        left: 0;
      }

      .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: var(--hover-transition);
      }

      .sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
      }
    }

    @media (max-width: 768px) {
      .customer-content {
        padding: 20px;
      }

      .customer-header {
        padding: 0 20px;
      }

      .header-quick-links {
        display: none;
      }

      .page-title {
        font-size: 24px;
      }
    }

    /* Hide Google Translate banner */
    .goog-te-banner-frame,
    .skiptranslate>iframe,
    #goog-gt-tt,
    .VIpgJd-ZVi9od-l4eHX-hSRGPd {
      display: none !important;
    }

    body {
      top: 0 !important;
    }

    .goog-te-gadget {
      font-size: 0 !important;
    }
  </style>
</head>

<body>
  <!-- Sidebar Overlay (Mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- Sidebar -->
  <aside class="customer-sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand-icon">
        <i class="bi bi-car-front"></i>
      </div>
      <div class="sidebar-brand-text">Ethio<span>Rental</span></div>
    </div>

    <nav class="sidebar-menu">
      <div class="sidebar-menu-title">Main</div>
      <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
          <a href="{{ route('dashboard') }}"
            class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-grid-1x2"></i></span>
            Dashboard
          </a>
        </li>
        <li class="sidebar-nav-item">
          <a href="{{ route('home') }}" class="sidebar-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-house"></i></span>
            Home
          </a>
        </li>
      </ul>

      <div class="sidebar-menu-title">Rentals</div>
      <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
          <a href="{{ route('cars.index') }}"
            class="sidebar-nav-link {{ request()->routeIs('cars.*') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-car-front-fill"></i></span>
            Browse Cars
          </a>
        </li>
        <li class="sidebar-nav-item">
          <a href="{{ route('reservations.index') }}"
            class="sidebar-nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-calendar-check"></i></span>
            My Reservations
          </a>
        </li>
        <li class="sidebar-nav-item">
          <a href="{{ route('rentals.index') }}"
            class="sidebar-nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-key"></i></span>
            My Rentals
          </a>
        </li>
      </ul>

      <div class="sidebar-menu-title">Account</div>
      <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
          <a href="{{ route('profile') }}" class="sidebar-nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-person"></i></span>
            Profile
          </a>
        </li>
        <li class="sidebar-nav-item">
          <a href="{{ route('complaints.index') }}"
            class="sidebar-nav-link {{ request()->routeIs('complaints.*') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-chat-right-text"></i></span>
            My Complaints
          </a>
        </li>
        @if(Auth::user() && (Auth::user()->isStaff() || Auth::user()->isManager()))
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.dashboard') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-shield-check"></i></span>
              Admin Panel
            </a>
          </li>
        @endif
      </ul>
    </nav>

    @auth
      <div class="sidebar-user">
        <div class="sidebar-user-info">
          <div class="sidebar-user-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
          </div>
          <div>
            <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
            <div class="sidebar-user-role">{{ Auth::user()->role->display_name }}</div>
          </div>
        </div>
      </div>
    @endauth
  </aside>

  <!-- Main Content -->
  <main class="customer-main">
    <!-- Header -->
    <header class="customer-header">
      <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>
        <nav class="header-breadcrumb">
          <a href="{{ route('dashboard') }}">Dashboard</a>
          @yield('breadcrumb')
        </nav>
      </div>

      <div class="header-right">
        <div class="header-quick-links">
          <a href="{{ route('cars.index') }}" class="header-quick-link">
            <i class="bi bi-car-front me-1"></i> Browse Cars
          </a>
          <a href="{{ route('reservations.create') }}" class="header-quick-link">
            <i class="bi bi-plus-circle me-1"></i> New Booking
          </a>
        </div>

        <!-- Language Switcher -->
        <div class="lang-switcher" id="langSwitcher">
          <button class="lang-switcher-btn" id="langToggle">
            <i class="bi bi-globe2"></i>
            <span id="currentLang">English</span>
            <i class="bi bi-chevron-down"></i>
          </button>
          <div class="lang-switcher-dropdown">
            <div class="lang-item active" data-lang="en">
              <span>English</span>
              <i class="bi bi-check2 check"></i>
            </div>
            <div class="lang-item" data-lang="am">
              <span>አማርኛ (Amharic)</span>
              <i class="bi bi-check2 check"></i>
            </div>
            <div class="lang-item" data-lang="om">
              <span>Oromoo (Oromo)</span>
              <i class="bi bi-check2 check"></i>
            </div>
            <div class="lang-item" data-lang="so">
              <span>Soomaali (Somali)</span>
              <i class="bi bi-check2 check"></i>
            </div>
          </div>
        </div>
        <div id="google_translate_element_global" style="display: none;"></div>

        <!-- Notification Dropdown -->
        @auth
          <div class="dropdown me-3">
            <button class="btn btn-icon position-relative" data-bs-toggle="dropdown"
              style="border: none; background: transparent; color: inherit;">
              <i class="bi bi-bell fs-5"></i>
              @if(Auth::user()->unreadNotifications->count() > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                  style="font-size: 0.6rem;">
                  {{ Auth::user()->unreadNotifications->count() }}
                  <span class="visually-hidden">unread messages</span>
                </span>
              @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern p-0"
              style="width: 320px; max-height: 400px; overflow-y: auto;">
              <li class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
                <h6 class="m-0">Notifications</h6>
                @if(Auth::user()->unreadNotifications->count() > 0)
                  <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-xs btn-link text-decoration-none p-0">Mark all read</button>
                  </form>
                @endif
              </li>
              @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                <li>
                  <a class="dropdown-item p-3 border-bottom" href="{{ route('notifications.read', $notification->id) }}"
                    style="white-space: normal;">
                    <div class="d-flex align-items-start">
                      <div class="flex-shrink-0 me-2">
                        @if($notification->type === 'App\Notifications\ComplaintSubmitted' || $notification->type === 'App\Notifications\RentalOverdue')
                          <i class="bi bi-exclamation-circle-fill text-warning"></i>
                        @elseif($notification->type === 'App\Notifications\ComplaintResolved' || $notification->type === 'App\Notifications\BookingStatusUpdated' || $notification->type === 'App\Notifications\RentalStatusUpdated')
                          <i class="bi bi-check-circle-fill text-success"></i>
                        @elseif($notification->type === 'App\Notifications\NewBookingCreated')
                          <i class="bi bi-calendar-plus-fill text-info"></i>
                        @else
                          <i class="bi bi-info-circle-fill text-primary"></i>
                        @endif
                      </div>
                      <div>
                        <p class="mb-1 small fw-bold">{{ $notification->data['subject'] ?? 'Notification' }}</p>
                        <p class="mb-1 small text-muted">{{ Str::limit($notification->data['message'] ?? '', 50) }}</p>
                        <small class="text-secondary"
                          style="font-size: 0.7rem;">{{ $notification->created_at->diffForHumans() }}</small>
                      </div>
                    </div>
                  </a>
                </li>
              @empty
                <li class="p-4 text-center text-muted">
                  <i class="bi bi-bell-slash fs-4 mb-2 d-block"></i>
                  <small>No new notifications</small>
                </li>
              @endforelse
            </ul>
          </div>
        @endauth

        <!-- User Dropdown -->
        @auth
          <div class="dropdown header-user-dropdown">
            <button class="header-user-btn" data-bs-toggle="dropdown">
              <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
              <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              <i class="bi bi-chevron-down"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
              <li class="user-menu-header">
                <div class="avatar-lg">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <h6>{{ Auth::user()->name }}</h6>
                <span>{{ Auth::user()->role->display_name }}</span>
              </li>
              <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person"></i> My Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('reservations.index') }}"><i class="bi bi-calendar-check"></i>
                  Reservations</a></li>
              <li><a class="dropdown-item" href="{{ route('rentals.index') }}"><i class="bi bi-key"></i> Rentals</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right"></i> Sign Out
                  </button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <a href="{{ route('login') }}" class="btn-modern btn-modern-primary">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </a>
        @endauth
      </div>
    </header>

    <!-- Content -->
    <div class="customer-content">
      @if(session('success'))
        <div class="alert alert-success">
          <i class="bi bi-check-circle-fill"></i>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-circle-fill"></i>
          {{ session('error') }}
        </div>
      @endif
      @if(session('info'))
        <div class="alert alert-info">
          <i class="bi bi-info-circle-fill"></i>
          {{ session('info') }}
        </div>
      @endif
      @if(session('warning'))
        <div class="alert alert-warning">
          <i class="bi bi-exclamation-triangle-fill"></i>
          {{ session('warning') }}
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  <!-- Footer -->
  <footer class="customer-footer">
    <div>© {{ date('Y') }} <a href="{{ route('home') }}">EthioRental</a>. All rights reserved.</div>
    <div>Customer Portal</div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sidebar Toggle (icon-only collapse)
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    sidebarToggle?.addEventListener('click', () => {
      document.body.classList.toggle('sidebar-collapsed');
      sidebar.classList.remove('show');
      sidebarOverlay.classList.remove('show');
    });

    sidebarOverlay?.addEventListener('click', () => {
      document.body.classList.add('sidebar-collapsed');
      sidebar.classList.remove('show');
      sidebarOverlay.classList.remove('show');
    });

    // Language Switcher
    const langSwitcher = document.getElementById('langSwitcher');
    const langToggle = document.getElementById('langToggle');
    const langItems = document.querySelectorAll('.lang-item');
    const currentLangSpan = document.getElementById('currentLang');

    const langNames = {
      'en': 'English',
      'am': 'አማርኛ',
      'om': 'Oromoo',
      'so': 'Soomaali'
    };

    langToggle?.addEventListener('click', (e) => {
      e.stopPropagation();
      langSwitcher.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
      if (!langSwitcher?.contains(e.target)) {
        langSwitcher?.classList.remove('open');
      }
    });

    function detectCurrentLanguage() {
      const match = document.cookie.match(/googtrans=\/[a-z]{2}\/([a-z]{2})/);
      return match ? match[1] : 'en';
    }

    function updateLanguageUI() {
      const currentLang = detectCurrentLanguage();
      if (currentLangSpan) {
        currentLangSpan.textContent = langNames[currentLang] || 'English';
      }
      langItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('data-lang') === currentLang) {
          item.classList.add('active');
        }
      });
    }

    function changeLanguage(lang) {
      const select = document.querySelector('.goog-te-combo');
      if (select) {
        select.value = lang;
        select.dispatchEvent(new Event('change'));
        setTimeout(updateLanguageUI, 300);
        return;
      }

      const domain = window.location.hostname;
      if (lang === 'en') {
        document.cookie = 'googtrans=;path=/;domain=' + domain + ';expires=Thu, 01 Jan 1970 00:00:00 GMT';
        document.cookie = 'googtrans=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT';
      } else {
        document.cookie = 'googtrans=/en/' + lang + ';path=/;domain=' + domain;
        document.cookie = 'googtrans=/en/' + lang + ';path=/';
      }
      window.location.reload();
    }

    langItems.forEach(item => {
      item.addEventListener('click', () => {
        const lang = item.getAttribute('data-lang');
        langSwitcher.classList.remove('open');
        changeLanguage(lang);
      });
    });

    function initGoogleTranslateWidget() {
      if (window.google && google.translate) {
        const options = {
          pageLanguage: 'en',
          includedLanguages: 'en,am,om,so',
          layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
          autoDisplay: false
        };
        if (document.getElementById('google_translate_element_global')) {
          new google.translate.TranslateElement(options, 'google_translate_element_global');
        }
      }
      setTimeout(updateLanguageUI, 500);
      setTimeout(updateLanguageUI, 1500);
    }

    function hideGoogleTranslateBanner() {
      const banner = document.querySelector('.goog-te-banner-frame');
      if (banner) banner.style.display = 'none';
      document.body.style.top = '0px';
    }

    setInterval(hideGoogleTranslateBanner, 300);
    document.addEventListener('DOMContentLoaded', () => {
      updateLanguageUI();
      hideGoogleTranslateBanner();
    });
  </script>
  <script src="https://translate.google.com/translate_a/element.js?cb=initGoogleTranslateWidget"></script>
  @stack('scripts')
</body>

</html>