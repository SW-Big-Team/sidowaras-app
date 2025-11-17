<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg position-sticky mt-2 top-1 px-0 py-1 mx-3 shadow-sm bg-white border-radius-lg z-index-sticky" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      @yield('breadcrumb')
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <!-- Search removed for cleaner look -->
      </div>
      <ul class="navbar-nav d-flex align-items-center justify-content-end">
        
        <!-- Notifications Dropdown -->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link text-body p-0 position-relative cursor-pointer" id="dropdownNotif" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="material-symbols-rounded cursor-pointer">notifications</i>
            @if($unreadNotificationCount > 0)
            <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
              {{ $unreadNotificationCount }}
            </span>
            @endif
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownNotif" style="min-width: 320px;">
            <li class="mb-2">
              <h6 class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-2">
                <i class="material-symbols-rounded me-2">notifications_active</i>
                Notifikasi
              </h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            @forelse($notifications as $notif)
            <li class="mb-2">
              <a class="dropdown-item border-radius-md {{ $notif->is_warning ? 'bg-light-warning' : '' }}" href="{{ $notif->link ?? '#' }}" onclick="{{ $notif->is_warning ? 'return true;' : 'markAsRead(' . $notif->id . '); return false;' }}">
                <div class="d-flex py-1">
                  <div class="my-auto">
                    <div class="icon icon-shape bg-gradient-{{ $notif->icon_color }} shadow text-center border-radius-md me-2">
                      <i class="material-symbols-rounded opacity-10 text-sm">{{ $notif->icon }}</i>
                    </div>
                  </div>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm font-weight-normal mb-1">
                      <span class="font-weight-bold">{{ $notif->title }}</span>
                      @if($notif->is_warning)
                      <span class="badge badge-sm bg-warning ms-1">!</span>
                      @endif
                    </h6>
                    <p class="text-xs text-secondary mb-0">
                      <i class="material-symbols-rounded text-xxs">schedule</i>
                      {{ $notif->message }}
                    </p>
                  </div>
                </div>
              </a>
            </li>
            @empty
            <li class="mb-2">
              <div class="text-center py-3">
                <i class="material-symbols-rounded text-secondary" style="font-size: 2rem;">notifications_off</i>
                <p class="text-xs text-secondary mb-0">Tidak ada notifikasi</p>
              </div>
            </li>
            @endforelse
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="text-center">
              <a href="#" class="btn btn-sm bg-gradient-primary mb-0 w-100" onclick="markAllAsRead()">
                Tandai Semua Dibaca
              </a>
            </li>
          </ul>
        </li>
        
        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
          <a href="#" class="nav-link text-body font-weight-bold px-3 d-flex align-items-center" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="me-2">
              <div class="avatar avatar-sm bg-gradient-primary">
                <span class="text-white text-sm">{{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}</span>
              </div>
            </div>
            <span class="d-sm-inline d-none">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>
            <i class="material-symbols-rounded opacity-10 ms-2">expand_more</i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton" style="min-width: 260px;">
            <li class="mb-2">
              <div class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-0">
                <div class="avatar avatar-sm bg-gradient-primary me-2">
                  <span class="text-white text-sm">{{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}</span>
                </div>
                <div>
                  <h6 class="text-sm mb-0">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</h6>
                  <p class="text-xs text-secondary mb-0">{{ Auth::user()->email ?? 'admin@apotek.com' }}</p>
                </div>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="mb-1">
              <a class="dropdown-item border-radius-md" href="#">
                <div class="d-flex align-items-center py-1">
                  <div class="icon icon-shape icon-sm bg-gradient-info shadow text-center me-2">
                    <i class="material-symbols-rounded opacity-10 text-sm">person</i>
                  </div>
                  <span class="text-sm">Profil Saya</span>
                </div>
              </a>
            </li>
            <li class="mb-1">
              <a class="dropdown-item border-radius-md" href="#">
                <div class="d-flex align-items-center py-1">
                  <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-center me-2">
                    <i class="material-symbols-rounded opacity-10 text-sm">settings</i>
                  </div>
                  <span class="text-sm">Pengaturan</span>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item border-radius-md" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                <div class="d-flex align-items-center py-1">
                  <div class="icon icon-shape icon-sm bg-gradient-danger shadow text-center me-2">
                    <i class="material-symbols-rounded opacity-10 text-sm">logout</i>
                  </div>
                  <span class="text-sm text-danger font-weight-bold">Logout</span>
                </div>
              </a>
              <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
