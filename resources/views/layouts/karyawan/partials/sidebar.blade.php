<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="{{ route('karyawan.dashboard') }}">
      <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
      <span class="ms-1 text-sm text-dark">Sidowaras App</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      {{-- Dashboard --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('karyawan.dashboard') }}">
          <i class="material-symbols-rounded opacity-5">dashboard</i>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      {{-- Manajemen Obat --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Obat</h6>
      {{-- Manajemen Obat --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Obat</h6>
      </li>

      {{-- Obat --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('obat.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('obat.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Obat</span>
          </a>
      </li>

      {{-- Kandungan Obat --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kandungan.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kandungan.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Kandungan Obat</span>
          </a>
      </li>
            
      {{-- Kategori Obat --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kategori.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Kategori Obat</span>
          </a>
      </li>

      {{-- Satuan Obat --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('satuan.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('satuan.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Satuan Obat</span>
          </a>
      </li>

      {{-- Operasional --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Operasional</h6>
      </li>

      {{-- Cart & Scanner --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('karyawan.cart.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('karyawan.cart.index') }}">
              <i class="material-symbols-rounded opacity-5">shopping_cart</i>
              <span class="nav-link-text ms-1">Keranjang</span>
          </a>
      </li>

      {{-- Manajemen Stok --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Stok</h6>
      </li>

      {{-- Pembelian --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Pembelian</span>
          </a>
      </li>

      {{-- Pembelian --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Pembelian</span>
          </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('stok.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('stok.index') }}">
          <i class="material-symbols-rounded opacity-5">inventory_2</i>
          <span class="nav-link-text ms-1">Daftar Stok</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pembelian.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
          <i class="material-symbols-rounded opacity-5">shopping_cart</i>
          <span class="nav-link-text ms-1">Pembelian Obat</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="{{ route('opname.index') }}">
          <i class="material-symbols-rounded opacity-5">fact_check</i>
          <span class="nav-link-text ms-1">Stok Opname</span>
        </a>
      </li>

      {{-- Notifikasi --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Lainnya</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="#">
          <i class="material-symbols-rounded opacity-5">notifications</i>
          <span class="nav-link-text ms-1">Notifikasi</span>
          <span class="badge badge-sm bg-gradient-warning ms-auto">5</span>
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
