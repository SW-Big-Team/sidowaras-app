<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
      <span class="ms-1 text-sm text-dark">Sidowaras App</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      {{-- Dashboard --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.dashboard') }}">
          <i class="material-symbols-rounded opacity-5">dashboard</i>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      {{-- Manajemen Sistem --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Sistem</h6>
      </li>

      {{-- Manajemen Pengguna --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.users.index') }}">
          <i class="material-symbols-rounded opacity-5">group</i>
          <span class="nav-link-text ms-1">Manajemen Pengguna</span>
        </a>
      </li>

      {{-- Dashboard Role --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.dashboard') }}">
          <i class="material-symbols-rounded opacity-5">point_of_sale</i>
          <span class="nav-link-text ms-1">Dashboard Kasir</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('karyawan.dashboard') }}">
          <i class="material-symbols-rounded opacity-5">badge</i>
          <span class="nav-link-text ms-1">Dashboard Karyawan</span>
        </a>
      </li>

      {{-- Manajemen Stok --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Stok</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.karyawan.stock.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.karyawan.stock.index') }}">
          <i class="material-symbols-rounded opacity-5">inventory_2</i>
          <span class="nav-link-text ms-1">Daftar Stok</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.karyawan.stock.tambah') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.karyawan.stock.tambah') }}">
          <i class="material-symbols-rounded opacity-5">add_box</i>
          <span class="nav-link-text ms-1">Tambah Obat Baru</span>
        </a>
      </li>

      {{-- Laporan & Monitoring --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Laporan & Monitoring</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="#">
          <i class="material-symbols-rounded opacity-5">bar_chart</i>
          <span class="nav-link-text ms-1">Laporan Keuangan</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="#">
          <i class="material-symbols-rounded opacity-5">assessment</i>
          <span class="nav-link-text ms-1">Laporan Stok</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="#">
          <i class="material-symbols-rounded opacity-5">history</i>
          <span class="nav-link-text ms-1">Aktivitas Pengguna</span>
        </a>
      </li>

      {{-- Notifikasi --}}
      <li class="nav-item">
        <a class="nav-link text-dark" href="#">
          <i class="material-symbols-rounded opacity-5">notifications</i>
          <span class="nav-link-text ms-1">Notifikasi</span>
          <span class="badge badge-sm bg-gradient-danger ms-auto">12</span>
        </a>
      </li>

      {{-- Account --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Akun</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="#">
          <i class="material-symbols-rounded opacity-5">person</i>
          <span class="nav-link-text ms-1">Profil Saya</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="material-symbols-rounded opacity-5">logout</i>
          <span class="nav-link-text ms-1">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</aside>
