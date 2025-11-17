@php
    $notifications = $notifications ?? collect();
    $unreadNotificationCount = $unreadNotificationCount ?? $notifications->whereNull('read_at')->count();
@endphp

<nav class="navbar navbar-expand-lg karyawan-navbar px-0 mx-3" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-2 px-3">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-link text-muted d-lg-none p-0" type="button" aria-label="Toggle sidebar" onclick="toggleSidebar()">
        <i class="material-symbols-rounded">menu</i>
      </button>
    </div>

    <div class="d-flex align-items-center ms-auto karyawan-navbar__actions">
      <button
        type="button"
        class="karyawan-navbar__icon-btn"
        data-bs-toggle="modal"
        data-bs-target="#notificationsModal"
        aria-label="Lihat notifikasi"
      >
        <i class="material-symbols-rounded">notifications</i>
        @if($unreadNotificationCount > 0)
          <span class="position-absolute top-0 end-0 translate-middle badge-soft" aria-label="{{ $unreadNotificationCount }} notifikasi baru">
            {{ $unreadNotificationCount }}
          </span>
        @endif
      </button>

      <div class="dropdown">
        <button
          class="karyawan-navbar__icon-btn d-flex align-items-center gap-2"
          id="dropdownMenuButton"
          data-bs-toggle="dropdown"
          aria-expanded="false"
          type="button"
        >
          <div class="avatar avatar-sm rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded">person</i>
          </div>
          <span class="d-none d-sm-inline text-sm fw-semibold">{{ Auth::user()->nama ?? 'Karyawan' }}</span>
          <i class="material-symbols-rounded d-none d-sm-inline">expand_more</i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-3" aria-labelledby="dropdownMenuButton" style="min-width: 260px;">
          <li class="mb-2">
            <div class="rounded-4 p-3" style="background: var(--sw-surface-alt);">
              <p class="text-xs text-muted mb-1">Sedang login sebagai</p>
              <h6 class="mb-0">{{ Auth::user()->nama ?? 'Karyawan' }}</h6>
              <p class="text-xs text-muted mb-0">{{ Auth::user()->email ?? 'karyawan@sidowaras.com' }}</p>
            </div>
          </li>
          <li>
            <a class="dropdown-item rounded-3 py-2" href="#" aria-disabled="true">
              <div class="d-flex align-items-center gap-2 text-muted">
                <i class="material-symbols-rounded text-sm">person</i>
                <span>Profil Saya (segera)</span>
              </div>
            </a>
          </li>
          <li>
            <a class="dropdown-item rounded-3 py-2" href="#" aria-disabled="true">
              <div class="d-flex align-items-center gap-2 text-muted">
                <i class="material-symbols-rounded text-sm">settings</i>
                <span>Pengaturan (segera)</span>
              </div>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item rounded-3 py-2 text-danger fw-semibold" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
              <div class="d-flex align-items-center gap-2">
                <i class="material-symbols-rounded text-sm">logout</i>
                <span>Logout</span>
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
