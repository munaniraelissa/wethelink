<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD professional admin dashboard template">
  <title>Dashboard | wethelink</title>

  <link rel="stylesheet" href="../dashboard/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../dashboard/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="../dashboard/assets/css/style.css">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="index.html" aria-label="adminHMD dashboard">
          <img class="brand-icon" src="/cms/logo/small_logo.png" alt="Logo" style="max-width: 100%; height: auto;">
          <span class="brand-copy">
            <img class="logo-img" src="/cms/logo/logo_word.png" alt="Logo" style="max-width: 100%; height: auto;">
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link active" href="index.html" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.dashboard') }}</span>
        </a>
        <a class="nav-link" href="users.html">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.users') }}</span>
        </a>
        <a class="nav-link" href="{{ route('roles.index') }}">
          <span class="nav-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.roles') }}</span>
        </a>
        <a class="nav-link" href="add-user.html">
          <span class="nav-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.add_user') }}</span>
        </a>
        <a class="nav-link" href="profile.html">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.profile') }}</span>
        </a>
        <a class="nav-link" href="charts.html">
          <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.charts') }}</span>
        </a>
        <a class="nav-link" href="tables.html">
          <span class="nav-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.tables') }}</span>
        </a>
        <a class="nav-link" href="forms.html">
          <span class="nav-icon"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.forms') }}</span>
        </a>
        <a class="nav-link" href="components.html">
          <span class="nav-icon"><i class="bi bi-grid-3x3-gap" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.components') }}</span>
        </a>
        <a class="nav-link" href="alerts.html">
          <span class="nav-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.alerts') }}</span>
        </a>
        <a class="nav-link" href="modals.html">
          <span class="nav-icon"><i class="bi bi-window-stack" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.modals') }}</span>
        </a>
        <a class="nav-link" href="settings.html">
          <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.settings') }}</span>
        </a>
        <a class="nav-link" href="blank.html">
          <span class="nav-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.blank_page') }}</span>
        </a>
      </nav>

      <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="../dashboard/assets/images/avatar/avatar.jpg" alt="Admin Admin">
        <strong>Admin Admin</strong>
        <small>{{ __('dashboard.sidebar.active_workspace') }}</small>
      </div>

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">{{ __('dashboard.sidebar.system_running') }}</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="{{ __('dashboard.navbar.search') }}" aria-label="Search">
          </form>

          <div class="navbar-actions ms-auto">
            <div class="dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="color: inherit; text-decoration: none;">
                {{ __('dashboard.locale.label') }} ({{ strtoupper(app()->getLocale()) }})
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">{{ __('dashboard.locale.en') }}</a></li>
                <li><a class="dropdown-item" href="{{ route('locale.switch', 'rw') }}">{{ __('dashboard.locale.rw') }}</a></li>
              </ul>
            </div>

            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <div class="dropdown">
              <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('dashboard.navbar.notifications') }}">
                <span class="notification-dot"></span>
                <i class="bi bi-bell" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end notification-menu">
                <div class="dropdown-header fw-bold text-body">{{ __('dashboard.navbar.notifications') }}</div>
                <a class="dropdown-item" href="users.html">
                  <span class="notification-title">{{ __('dashboard.navbar.new_user') }}</span>
                  <span class="notification-time">4 minutes ago</span>
                </a>
                <a class="dropdown-item" href="charts.html">
                  <span class="notification-title">{{ __('dashboard.navbar.revenue_target') }}</span>
                  <span class="notification-time">32 minutes ago</span>
                </a>
                <a class="dropdown-item" href="settings.html">
                  <span class="notification-title">{{ __('dashboard.navbar.security_review') }}</span>
                  <span class="notification-time">1 hour ago</span>
                </a>
              </div>
            </div>

            <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="avatar-img avatar-sm" src="../dashboard/assets/images/avatar/avatar.jpg" alt="Admin Admin">
                <span class="profile-name d-none d-sm-inline">Admin Admin</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.html">{{ __('dashboard.navbar.profile') }}</a></li>
                <li><a class="dropdown-item" href="settings.html">{{ __('dashboard.navbar.account_settings') }}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="login.html">{{ __('dashboard.navbar.sign_out') }}</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      @yield('content')

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>Copyright 2026 wethelink. <br> Developed by <a target="_blank" class="fw-bold text-success" href="https://elissamunanira.netrify.app">Elissa MUNANIRA</a> • Distributed by <a target="_blank" class="fw-bold text-success" href="#">EMUNAH LTD</a> </span>
          <span>Professional ecommerce dashboard.</span>
        </div>
      </footer>
    </div>
  </div>

  <script src="../dashboard/assets/js/bootstrap.bundle.min.js"></script>
  <script src="../dashboard/assets/js/main.js"></script>
</body>
</html>
