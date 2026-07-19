<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-md-inline-block">
      <a href="{{ route('admin.dashboard') }}" class="nav-link font-weight-semibold">Dashboard</a>
    </li>
    <li class="nav-item d-none d-lg-inline-block">
      <a href="{{ url('/') }}" class="nav-link" target="_blank" rel="noopener">View store</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto align-items-center">
    <li class="nav-item d-none d-sm-inline-block mr-2">
      <a href="{{ route('admin.notifications') }}" class="nav-link" title="Notifications">
        <i class="far fa-bell"></i>
      </a>
    </li>

    @auth
      <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" aria-expanded="false">
          <span class="d-none d-md-inline text-dark mr-2 font-weight-medium">{{ Auth::user()->name }}</span>
          <i class="fas fa-chevron-down small text-muted"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow border-0 rounded-lg">
          <span class="dropdown-item-text small text-muted text-uppercase">Signed in</span>
          <span class="dropdown-item-text font-weight-bold text-truncate">{{ Auth::user()->email }}</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('admin.dashboard') }}" class="dropdown-item"><i class="fas fa-tachometer-alt mr-2 text-muted"></i> Dashboard</a>
          <a href="{{ route('admin.auth.logout') }}" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </div>
      </li>
    @endauth
  </ul>
</nav>
