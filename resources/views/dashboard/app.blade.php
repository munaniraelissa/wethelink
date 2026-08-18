<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD professional admin dashboard template">
  <title>Dashboard | wethelink</title>

  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Ensure DataTables controls appear above other layout elements and are visible */
    .dataTables_wrapper {
      overflow: visible !important;
    }
    .dataTables_wrapper .dt-buttons {
      position: relative !important;
      z-index: 1100 !important; /* higher than sidebar (1040) */
      display: flex !important;
      gap: 0.5rem;
      flex-wrap: wrap;
      margin-bottom: .75rem;
    }
    .dataTables_wrapper .dataTables_filter {
      position: relative !important;
      z-index: 1100 !important;
      margin-left: auto;
    }
    /* Prevent DataTables popups or printed overlays from being clipped by parent containers */
    .dt-button, .dt-button:active, .dt-button:focus {
      z-index: 1100 !important;
    }
  </style>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
  <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
  <meta name="apple-mobile-web-app-title" content="wethelink" />
  <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('dashboard.index') }}" aria-label="adminHMD dashboard">
          <img class="brand-icon" src="{{ asset('cms/logo/small_logo.png') }}" alt="Logo" style="max-width: 100%; height: auto;">
          <span class="brand-copy">
            <img class="logo-img" src="{{ asset('cms/logo/logo_word.png') }}" alt="Logo" style="max-width: 100%; height: auto;">
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link active" href="{{ route('dashboard.index') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.dashboard') }}</span>
        </a>
        @can('user-list')
        <a class="nav-link" href="{{ route('users.index') }}">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.users') }}</span>
        </a>
        @endcan
        @can('product-list')
        <a class="nav-link" href="{{ route('products.index') }}">
          <span class="nav-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('products.products') }}</span>
        </a>
        @endcan
        @can('category-list')
        <a class="nav-link" href="{{ route('categories.index') }}">
          <span class="nav-icon"><i class="bi bi-tags" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('messages.categories') }}</span>
        </a>
        @endcan
        @can('company-list')
        <a class="nav-link" href="{{ route('companies.index') }}">
          <span class="nav-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('users.company') }}</span>
        </a>
        @endcan
        {{-- <a class="nav-link" href="{{ route('subscription-packages.index') }}">
          <span class="nav-icon"><i class="bi bi-box2-heart" aria-hidden="true"></i></span>
          <span class="nav-text">Subscription Packages</span>
        </a>
        <a class="nav-link" href="{{ route('subscription-packages.index') }}">
          <span class="nav-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
          <span class="nav-text">Packages</span> --}}
        </a>
        @can('brand-list')
        <a class="nav-link" href="{{ route('brands.index') }}">
          <span class="nav-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('messages.brands') }}</span>
        </a>
        @endcan
        @can('size-list')
        <a class="nav-link" href="{{ route('sizes.index') }}">
          <span class="nav-icon"><i class="bi bi-aspect-ratio" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('messages.sizes') }}</span>
        </a>
        @endcan
        @can('color-list')
        <a class="nav-link" href="{{ route('colors.index') }}">
            <span class="nav-icon"><i class="bi bi-palette" aria-hidden="true"></i></span>
            <span class="nav-text">{{ __('messages.colors') }}</span>
        </a>
        @endcan
        @can('role-list')
        <a class="nav-link" href="{{ route('roles.index') }}">
            <span class="nav-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
            <span class="nav-text">{{ __('dashboard.sidebar.roles') }}</span>
        </a>
        @endcan
        <a class="nav-link {{ Route::is('dashboard.contact-messages.*') ? 'active' : '' }}" href="{{ route('dashboard.contact-messages.index') }}">
            <span class="nav-icon"><i class="bi bi-envelope" aria-hidden="true"></i></span>
            <span class="nav-text">{{ __('dashboard.sidebar.contact_messages') }}</span>
        </a>
        @can('manage-feature')
        <a class="nav-link" href="{{ route('dashboard.homepage-features.index') }}">
          <span class="nav-icon"><i class="bi bi-stars" aria-hidden="true"></i></span>
          <span class="nav-text">{{ __('dashboard.sidebar.home_settings') }}</span>
        </a>
        @endcan
        {{-- <a class="nav-link" href="add-user.html">
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
        <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('dashboard/assets/images/avatar/avatar.jpg') }}" alt="Admin Admin">
        <strong>Admin Admin</strong>
        <small>{{ __('dashboard.sidebar.active_workspace') }}</small>
      </div> --}}

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
            <a class="btn btn-sm btn-outline-secondary" href="/" target="blank"><i class="bi bi-eye"></i> View Site</a>
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
            {{-- <div class="dropdown">
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
            </div> --}}

            <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="profile-name d-none d-sm-inline">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h6></li>
                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>{{ __('dashboard.navbar.profile') }}</a></li>
                <li><a class="dropdown-item" href="{{ route('profile') }}#password-section"><i class="bi bi-key me-2"></i>{{ __('dashboard.navbar.change_password') }}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.navbar.sign_out') }}</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      @yield('content')

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>&copy; {{ date('Y') }} wethelink.com. All Rights Reserved.</span>
          {{-- <span>Professional ecommerce dashboard.</span> --}}
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ asset('dashboard/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/main.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleButtons = document.querySelectorAll('.toggle-password');
      
      toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
          const targetSelector = button.getAttribute('data-target');
          const passwordInput = document.querySelector(targetSelector);
          const icon = button.querySelector('i');
          
          if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
          } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
          }
        });
      });
    });
  </script>

  @yield('scripts')
</body>
</html>
