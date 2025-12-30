<!doctype html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>@yield('title', 'Admin Dashboard') - EthioRental</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="EthioRental | Admin Dashboard" />
  <meta name="author" content="EthioRental" />
  <meta name="description" content="Admin dashboard for EthioRental system" />
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
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --sidebar-bg: linear-gradient(180deg, #1e1e2d 0%, #1a1a27 100%);
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
      background: #f4f7fe;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Sidebar */
    .admin-sidebar {
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

    .admin-sidebar::-webkit-scrollbar {
      width: 4px;
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
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
      box-shadow: 0 8px 24px rgba(102, 126, 234, 0.35);
    }

    .sidebar-brand-text {
      color: white;
      font-size: 20px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .sidebar-brand-text span {
      color: #a78bfa;
    }

    .sidebar-menu {
      padding: 20px 16px;
    }

    .sidebar-menu-title {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: #6b7280;
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
      color: #9ca3af;
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
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
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
      object-fit: cover;
      border: 2px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-user-name {
      color: white;
      font-size: 14px;
      font-weight: 600;
    }

    .sidebar-user-role {
      color: #6b7280;
      font-size: 12px;
    }

    /* Main Content */
    .admin-main {
      margin-left: var(--sidebar-width);
      min-height: 100vh;
      transition: var(--hover-transition);
    }

    /* Header */
    .admin-header {
      height: var(--header-height);
      background: white;
      border-bottom: 1px solid #e5e7eb;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 32px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 24px;
    }

    .sidebar-toggle {
      display: none;
      width: 40px;
      height: 40px;
      border: none;
      background: #f3f4f6;
      border-radius: 10px;
      cursor: pointer;
      font-size: 20px;
      color: #374151;
      transition: var(--hover-transition);
    }

    .sidebar-toggle:hover {
      background: #e5e7eb;
    }

    .header-breadcrumb {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #6b7280;
    }

    .header-breadcrumb a {
      color: #6b7280;
      text-decoration: none;
      transition: color 0.2s;
    }

    .header-breadcrumb a:hover {
      color: #667eea;
    }

    .header-breadcrumb .separator {
      color: #d1d5db;
    }

    .header-breadcrumb .current {
      color: #111827;
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
      color: #6b7280;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      border-radius: 8px;
      transition: var(--hover-transition);
    }

    .header-quick-link:hover {
      color: #667eea;
      background: #f3f4f6;
    }

    .header-icon-btn {
      width: 42px;
      height: 42px;
      border: none;
      background: #f3f4f6;
      border-radius: 12px;
      cursor: pointer;
      font-size: 18px;
      color: #6b7280;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--hover-transition);
      position: relative;
    }

    .header-icon-btn:hover {
      background: #e5e7eb;
      color: #374151;
    }

    .header-icon-btn .badge {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 8px;
      height: 8px;
      background: #ef4444;
      border-radius: 50%;
      border: 2px solid white;
    }

    .header-user-dropdown {
      position: relative;
    }

    .header-user-btn {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 6px 12px 6px 6px;
      background: #f3f4f6;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: var(--hover-transition);
    }

    .header-user-btn:hover {
      background: #e5e7eb;
    }

    .header-user-btn img {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      object-fit: cover;
    }

    .header-user-btn span {
      font-size: 14px;
      font-weight: 500;
      color: #374151;
    }

    .header-user-btn i {
      font-size: 12px;
      color: #6b7280;
    }

    /* Content Area */
    .admin-content {
      padding: 32px;
      padding-bottom: 100px;
    }

    .page-header {
      margin-bottom: 32px;
    }

    .page-title {
      font-size: 28px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .page-subtitle {
      font-size: 15px;
      color: #6b7280;
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

    /* Modern Card Styles */
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
      border-bottom: 1px solid #f3f4f6;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .modern-card-title {
      font-size: 16px;
      font-weight: 600;
      color: #111827;
      margin: 0;
    }

    .modern-card-body {
      padding: 24px;
    }

    .modern-card-footer {
      padding: 16px 24px;
      background: #f9fafb;
      border-top: 1px solid #f3f4f6;
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
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
      color: #667eea;
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
      color: #111827;
      margin-bottom: 6px;
      letter-spacing: -1px;
    }

    .stat-card-label {
      font-size: 14px;
      color: #6b7280;
      font-weight: 500;
    }

    .stat-card-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      font-weight: 500;
      color: #667eea;
      text-decoration: none;
      margin-top: 16px;
      transition: gap 0.2s;
    }

    .stat-card-link:hover {
      gap: 10px;
      color: #764ba2;
    }

    /* Modern Table */
    .modern-table {
      width: 100%;
      border-collapse: collapse;
    }

    .modern-table thead th {
      padding: 14px 20px;
      text-align: left;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #6b7280;
      background: #f9fafb;
      border-bottom: 1px solid #e5e7eb;
    }

    .modern-table tbody td {
      padding: 16px 20px;
      font-size: 14px;
      color: #374151;
      border-bottom: 1px solid #f3f4f6;
      vertical-align: middle;
    }

    .modern-table tbody tr:hover {
      background: #f9fafb;
    }

    .modern-table tbody tr:last-child td {
      border-bottom: none;
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
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);
    }

    .btn-modern-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.45);
      color: white;
    }

    .btn-modern-secondary {
      background: #f3f4f6;
      color: #374151;
    }

    .btn-modern-secondary:hover {
      background: #e5e7eb;
      color: #111827;
    }

    .btn-modern-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
    }

    .btn-modern-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
      color: white;
    }

    .btn-modern-danger {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(239, 68, 68, 0.35);
    }

    .btn-modern-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.45);
      color: white;
    }

    .btn-modern-sm {
      padding: 6px 12px;
      font-size: 13px;
      border-radius: 8px;
    }

    .btn-icon {
      width: 36px;
      height: 36px;
      padding: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      transition: var(--hover-transition);
    }

    .btn-icon-primary {
      background: rgba(102, 126, 234, 0.1);
      color: #667eea;
    }

    .btn-icon-primary:hover {
      background: #667eea;
      color: white;
    }

    .btn-icon-success {
      background: rgba(16, 185, 129, 0.1);
      color: #10b981;
    }

    .btn-icon-success:hover {
      background: #10b981;
      color: white;
    }

    .btn-icon-warning {
      background: rgba(245, 158, 11, 0.1);
      color: #f59e0b;
    }

    .btn-icon-warning:hover {
      background: #f59e0b;
      color: white;
    }

    .btn-icon-danger {
      background: rgba(239, 68, 68, 0.1);
      color: #ef4444;
    }

    .btn-icon-danger:hover {
      background: #ef4444;
      color: white;
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
      background: rgba(102, 126, 234, 0.1);
      color: #667eea;
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

    .modern-badge-secondary {
      background: #f3f4f6;
      color: #6b7280;
    }

    /* Form Styles */
    .form-label-modern {
      font-size: 13px;
      font-weight: 600;
      color: #374151;
      margin-bottom: 8px;
      display: block;
    }

    .form-control-modern {
      width: 100%;
      padding: 12px 16px;
      font-size: 14px;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      background: white;
      color: #111827;
      transition: var(--hover-transition);
    }

    .form-control-modern:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }

    .form-control-modern::placeholder {
      color: #9ca3af;
    }

    /* Search Box */
    .search-box {
      position: relative;
    }

    .search-box input {
      padding-left: 44px;
    }

    .search-box i {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 16px;
    }

    /* Footer */
    .admin-footer {
      position: fixed;
      bottom: 0;
      left: var(--sidebar-width);
      right: 0;
      padding: 16px 32px;
      background: white;
      border-top: 1px solid #e5e7eb;
      font-size: 13px;
      color: #6b7280;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 50;
    }

    .admin-footer a {
      color: #667eea;
      text-decoration: none;
      font-weight: 500;
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
      background: #f3f4f6;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      color: #374151;
      cursor: pointer;
      transition: var(--hover-transition);
    }

    .lang-switcher-btn:hover {
      background: #e5e7eb;
    }

    .lang-switcher-btn i:first-child {
      color: #667eea;
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
      color: #374151;
      transition: var(--hover-transition);
    }

    .lang-item:hover {
      background: #f3f4f6;
    }

    .lang-item.active {
      background: rgba(102, 126, 234, 0.1);
      color: #667eea;
    }

    .lang-item .check {
      display: none;
      color: #667eea;
    }

    .lang-item.active .check {
      display: block;
    }

    /* Dropdown Menu */
    .dropdown-menu-modern {
      min-width: 200px;
      padding: 8px;
      border: none;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .dropdown-menu-modern .dropdown-item {
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 14px;
      color: #374151;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dropdown-menu-modern .dropdown-item:hover {
      background: #f3f4f6;
    }

    .dropdown-menu-modern .dropdown-divider {
      margin: 8px 0;
      border-color: #f3f4f6;
    }

    /* User Menu Header */
    .user-menu-header {
      padding: 16px;
      text-align: center;
      border-bottom: 1px solid #f3f4f6;
      margin-bottom: 8px;
    }

    .user-menu-header img {
      width: 64px;
      height: 64px;
      border-radius: 16px;
      margin-bottom: 12px;
      border: 3px solid #f3f4f6;
    }

    .user-menu-header h6 {
      font-size: 15px;
      font-weight: 600;
      color: #111827;
      margin-bottom: 4px;
    }

    .user-menu-header span {
      font-size: 13px;
      color: #6b7280;
    }

    /* Empty State */
    .empty-state {
      padding: 60px 20px;
      text-align: center;
    }

    .empty-state-icon {
      width: 80px;
      height: 80px;
      background: #f3f4f6;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 36px;
      color: #9ca3af;
      margin: 0 auto 20px;
    }

    .empty-state-title {
      font-size: 18px;
      font-weight: 600;
      color: #374151;
      margin-bottom: 8px;
    }

    .empty-state-text {
      font-size: 14px;
      color: #6b7280;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }

      .admin-sidebar.show {
        transform: translateX(0);
      }

      .admin-main {
        margin-left: 0;
      }

      .admin-footer {
        left: 0;
      }

      .sidebar-toggle {
        display: flex;
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
      .admin-content {
        padding: 20px;
      }

      .admin-header {
        padding: 0 20px;
      }

      .header-quick-links {
        display: none;
      }

      .page-title {
        font-size: 24px;
      }

      .stat-card-value {
        font-size: 26px;
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
  <aside class="admin-sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand-icon">
        <i class="bi bi-car-front"></i>
      </div>
      <div class="sidebar-brand-text">Ethio<span>Admin</span></div>
    </div>

    <nav class="sidebar-menu">
      <div class="sidebar-menu-title">Main</div>
      <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
          <a href="{{ route('admin.dashboard') }}"
            class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sidebar-nav-icon"><i class="bi bi-grid-1x2"></i></span>
            Dashboard
          </a>
        </li>
      </ul>

      <div class="sidebar-menu-title">Management</div>
      <ul class="sidebar-nav">
        @if(Auth::user()->isSuperAdmin())
          {{-- Admin-specific menu items --}}
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.users.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-people"></i></span>
              Users
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.settings.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-gear"></i></span>
              System Settings
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.logs.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-clock-history"></i></span>
              Activity Logs
            </a>
          </li>
        @elseif(Auth::user()->isAdmin())
          {{-- Staff/Manager menu items (isAdmin includes staff & manager) --}}
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.cars.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-car-front-fill"></i></span>
              Vehicles
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.reservations.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-calendar-check"></i></span>
              Bookings
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.rentals.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-key"></i></span>
              Rentals
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.returns.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-box-arrow-in-left"></i></span>
              Returns
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.complaints.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-chat-left-text"></i></span>
              Complaints
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.drivers.index') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-person-badge"></i></span>
              Drivers
            </a>
          </li>
        @endif
      </ul>

      @if(Auth::user()->isManager() || Auth::user()->isSuperAdmin())
        <div class="sidebar-menu-title">Analytics</div>
        <ul class="sidebar-nav">
          <li class="sidebar-nav-item">
            <a href="{{ route('admin.reports') }}"
              class="sidebar-nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
              <span class="sidebar-nav-icon"><i class="bi bi-graph-up"></i></span>
              Reports
            </a>
          </li>
        </ul>
      @endif
    </nav>

    <div class="sidebar-user">
      <div class="sidebar-user-info">
        <img src="{{ asset('adminlte/dist/assets/img/user2-160x160.jpg') }}" alt="User" class="sidebar-user-avatar">
        <div>
          <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
          <div class="sidebar-user-role">{{ Auth::user()->role->display_name }}</div>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="admin-main">
    <!-- Header -->
    <header class="admin-header">
      <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>
        <nav class="header-breadcrumb">
          <a href="{{ route('admin.dashboard') }}">Dashboard</a>
          @yield('breadcrumb')
        </nav>
      </div>

      <div class="header-right">


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
        <div id="google_translate_element_admin" style="display: none;"></div>

        <!-- Notification Dropdown -->
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

        <!-- User Dropdown -->
        <div class="dropdown header-user-dropdown">
          <button class="header-user-btn" data-bs-toggle="dropdown">
            <img src="{{ asset('adminlte/dist/assets/img/user2-160x160.jpg') }}" alt="User">
            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            <i class="bi bi-chevron-down"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
            <li class="user-menu-header">
              <img src="{{ asset('adminlte/dist/assets/img/user2-160x160.jpg') }}" alt="User">
              <h6>{{ Auth::user()->name }}</h6>
              <span>{{ Auth::user()->role->display_name }}</span>
            </li>
            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person"></i> My Profile</a></li>
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
      </div>
    </header>

    <!-- Content -->
    <div class="admin-content">
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
  <footer class="admin-footer">
    <div>© {{ date('Y') }} <a href="#">EthioRental</a>. All rights reserved.</div>
    <div>Admin Panel v2.0</div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    sidebarToggle?.addEventListener('click', () => {
      sidebar.classList.toggle('show');
      sidebarOverlay.classList.toggle('show');
    });

    sidebarOverlay?.addEventListener('click', () => {
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
        if (document.getElementById('google_translate_element_admin')) {
          new google.translate.TranslateElement(options, 'google_translate_element_admin');
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