<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg position-sticky mt-2 top-1 px-0 py-1 mx-3 shadow-sm bg-white border-radius-lg z-index-sticky" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      @yield('breadcrumb')
    </nav>
    
    <!-- Mobile & Desktop Navigation Items -->
    <div class="d-flex align-items-center ms-auto">
      <!-- Notifications Dropdown - Always Visible -->
      <div class="nav-item dropdown pe-2 pe-md-3">
        <a class="nav-link text-body p-0 position-relative cursor-pointer" id="dropdownNotif" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="material-symbols-rounded cursor-pointer">notifications</i>
          @if($unreadNotificationCount > 0)
          <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $unreadNotificationCount }}
          </span>
          @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownNotif" style="min-width: 320px; max-width: 380px;">
          <li class="mb-2">
            <div class="d-flex align-items-center justify-content-between px-2">
              <h6 class="dropdown-header text-dark font-weight-bolder d-flex align-items-center p-0 m-0">
                <i class="material-symbols-rounded me-2">notifications_active</i>
                Notifikasi
              </h6>
              <a href="#" class="text-xs text-primary font-weight-bold" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                Lihat Semua
              </a>
            </div>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <div style="max-height: 320px; overflow-y: auto; overflow-x: hidden;">
            @forelse($notifications->take(5) as $notif)
            <li class="mb-2">
              <a class="dropdown-item border-radius-md {{ $notif->is_warning ? 'bg-light-warning' : '' }}" href="{{ $notif->link ?? '#' }}" onclick="{{ $notif->is_warning ? 'return true;' : 'markAsRead(' . $notif->id . '); return false;' }}">
                <div class="d-flex py-1">
                  <div class="my-auto">
                    <div class="icon icon-shape bg-gradient-{{ $notif->icon_color }} shadow text-center border-radius-md me-2 d-flex align-items-center justify-content-center">
                      <i class="material-symbols-rounded text-sm">{{ $notif->icon }}</i>
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
          </div>
          @if($notifications->count() > 0)
          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="text-center px-2">
            <div class="d-grid gap-2">
              <button class="btn btn-sm bg-gradient-primary mb-0" onclick="markAllAsRead()">
                <i class="material-symbols-rounded text-sm me-1">done_all</i>
                Tandai Semua Dibaca
              </button>
              @if($notifications->count() > 5)
              <button class="btn btn-sm btn-outline-primary mb-0" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                <i class="material-symbols-rounded text-sm me-1">list</i>
                Lihat Semua Notifikasi ({{ $notifications->count() }})
              </button>
              @endif
            </div>
          </li>
          @endif
        </ul>
      </div>
      
      <!-- User Profile Dropdown - Always Visible -->
      <div class="nav-item dropdown">
        <a href="#" class="nav-link text-body font-weight-bold px-2 px-md-3 d-flex align-items-center" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="me-2">
            <div class="avatar avatar-sm bg-gradient-primary">
              <span class="text-white text-sm">{{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}</span>
            </div>
          </div>
          <span class="d-sm-inline d-none">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>
          <i class="material-symbols-rounded opacity-10 ms-2 d-none d-sm-inline">expand_more</i>
        </a>
          <i class="material-symbols-rounded opacity-10 ms-2 d-none d-sm-inline">expand_more</i>
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
      </div>
    </div>
  </div>
</nav>
<!-- End Navbar -->
