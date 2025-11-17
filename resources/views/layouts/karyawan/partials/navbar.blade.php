<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 border-0 rounded-3 shadow-sm" id="navbarBlur" data-scroll="true" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
  <div class="container-fluid py-2 px-4">
    <nav aria-label="breadcrumb">
      @yield('breadcrumb')
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group border-0 rounded-3 shadow-sm" style="background: white; overflow: hidden;">
          <span class="input-group-text border-0 bg-transparent">
            <i class="material-symbols-rounded opacity-7" style="font-size: 1.25rem; color: #f59e0b;">search</i>
          </span>
          <input type="text" class="form-control border-0 ps-0" placeholder="Cari sesuatu..." style="box-shadow: none;">
        </div>
      </div>
      <ul class="navbar-nav d-flex align-items-center justify-content-end ms-3">
        <li class="nav-item dropdown d-flex align-items-center me-2">
          <a class="nav-link text-body p-2 position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false" style="background: #fffbeb; border-radius: 0.5rem; transition: all 0.3s ease;">
            <i class="material-symbols-rounded" style="color: #f59e0b;">notifications</i>
            @if($unreadNotificationCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); font-size: 0.65rem; padding: 0.25rem 0.4rem;">
              {{ $unreadNotificationCount }}
            </span>
            @endif
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-3" style="min-width: 320px;">
            <li class="mb-2">
              <h6 class="px-3 mb-3 font-weight-bold" style="color: #d97706;">Notifikasi Terbaru</h6>
            </li>
            @forelse($notifications as $notif)
            <li>
              <a class="dropdown-item border-radius-md mb-2 p-3 {{ $notif->is_warning ? 'border border-warning' : '' }}" href="{{ $notif->link ?? '#' }}" onclick="{{ $notif->is_warning ? 'return true;' : 'markAsRead(' . $notif->id . '); return false;' }}" style="background: #fffbeb; transition: all 0.3s ease;">
                <div class="d-flex">
                  <div class="icon icon-sm shadow text-center border-radius-md me-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="material-symbols-rounded opacity-10 text-white">{{ $notif->icon }}</i>
                  </div>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm font-weight-bold mb-1">
                      {{ $notif->title }}
                      @if($notif->is_warning)
                      <span class="badge badge-sm bg-warning ms-1">!</span>
                      @endif
                    </h6>
                    <p class="text-xs text-secondary mb-0">{{ $notif->message }}</p>
                  </div>
                </div>
              </a>
            </li>
            @empty
            <li>
              <div class="text-center py-3">
                <i class="material-symbols-rounded text-secondary" style="font-size: 2rem;">notifications_off</i>
                <p class="text-xs text-secondary mb-0">Tidak ada notifikasi</p>
              </div>
            </li>
            @endforelse
            <li>
              <a class="dropdown-item border-radius-md text-center py-2" href="#" onclick="markAllAsRead()" style="color: #f59e0b; font-weight: 600;">
                Tandai Semua Dibaca
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown d-flex align-items-center">
          <a href="#" class="nav-link d-flex align-items-center p-2 rounded-3" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); transition: all 0.3s ease;">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm rounded-circle me-2" style="background: white; display: flex; align-items: center; justify-content: center;">
                <i class="material-symbols-rounded" style="color: #f59e0b; font-size: 1.25rem;">person</i>
              </div>
              <span class="d-sm-inline d-none text-white font-weight-bold text-sm">{{ Auth::user()->nama ?? 'Karyawan' }}</span>
              <i class="material-symbols-rounded ms-2 text-white opacity-8">expand_more</i>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-3" aria-labelledby="dropdownMenuButton" style="min-width: 280px;">
            <li class="mb-2">
              <div class="px-3 py-2 mb-2 rounded-3" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
                <h6 class="text-sm font-weight-bold mb-0" style="color: #d97706;">{{ Auth::user()->nama ?? 'Karyawan' }}</h6>
                <p class="text-xs mb-0" style="color: #d97706; opacity: 0.8;">{{ Auth::user()->email ?? 'karyawan@sidowaras.com' }}</p>
              </div>
            </li>
            <li class="mb-2">
              <a class="dropdown-item border-radius-md hover-shadow-sm p-3" href="#" style="transition: all 0.3s ease;">
                <div class="d-flex align-items-center">
                  <div class="icon icon-sm shadow-sm text-center border-radius-md me-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="material-symbols-rounded opacity-10 text-white">person</i>
                  </div>
                  <div>
                    <h6 class="text-sm font-weight-bold mb-0">Profil Saya</h6>
                    <p class="text-xs text-secondary mb-0">Lihat & edit profil</p>
                  </div>
                </div>
              </a>
            </li>
            <li class="mb-2">
              <a class="dropdown-item border-radius-md hover-shadow-sm p-3" href="#" style="transition: all 0.3s ease;">
                <div class="d-flex align-items-center">
                  <div class="icon icon-sm shadow-sm text-center border-radius-md me-3" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%);">
                    <i class="material-symbols-rounded opacity-10 text-white">settings</i>
                  </div>
                  <div>
                    <h6 class="text-sm font-weight-bold mb-0">Pengaturan</h6>
                    <p class="text-xs text-secondary mb-0">Preferensi akun</p>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider my-2">
            </li>
            <li>
              <a class="dropdown-item border-radius-md p-3" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();" style="background: #fef2f2; transition: all 0.3s ease;">
                <div class="d-flex align-items-center">
                  <div class="icon icon-sm shadow-sm text-center border-radius-md me-3" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="material-symbols-rounded opacity-10 text-white">logout</i>
                  </div>
                  <div>
                    <h6 class="text-sm font-weight-bold mb-0 text-danger">Logout</h6>
                    <p class="text-xs text-secondary mb-0">Keluar dari sistem</p>
                  </div>
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

<style>
  .dropdown-item:hover {
    transform: translateX(4px);
    background: #fffbeb !important;
  }
  
  .nav-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3) !important;
  }
</style>
