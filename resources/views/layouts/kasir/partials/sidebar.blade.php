<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="{{ route('kasir.dashboard') }}">
      <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
      <span class="ms-1 text-sm text-dark">Sidowaras App</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      {{-- Dashboard --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.dashboard') }}">
          <i class="material-symbols-rounded opacity-5">dashboard</i>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      {{-- Manajemen Obat --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Obat</h6>
      {{-- Manajemen Obat --}}
      <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Stok</h6>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('stok.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('stok.index') }}">
              <i class="material-symbols-rounded">inventory_2</i>
              <span class="nav-link-text ms-1">Daftar Stok</span>
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded">shopping_cart</i>
              <span class="nav-link-text ms-1">Pembelian Obat</span>
          </a>
      </li>

      <!-- Transaksi -->
      <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Transaksi</h6>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kasir.cart.approval') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.cart.approval') }}">
              <i class="material-symbols-rounded">shopping_cart</i>
              <span class="nav-link-text ms-1">Approval Cart</span>
          </a>
      </li>

      {{-- POS / Transaksi --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kasir.transaksi.*') ? 'active bg-gradient-success text-white' : 'text-dark' }}" href="{{ route('kasir.transaksi.pos') }}">
          <i class="material-symbols-rounded opacity-5">point_of_sale</i>
          <span class="nav-link-text ms-1">POS / Transaksi</span>
        </a>
      </li>
      {{-- Pembelian --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Pembelian</span>
          </a>
      </li>



      {{-- Cart Approval --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kasir.cart.*') ? 'active bg-gradient-warning text-white' : 'text-dark' }}" href="{{ route('kasir.cart.approval') }}">
          <i class="material-symbols-rounded opacity-5">approval</i>
          <span class="nav-link-text ms-1">Cart Approval</span>
          <span class="badge badge-sm bg-gradient-warning ms-auto">8</span>
        </a>
      </li>

      {{-- Laporan --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Laporan</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kasir.laporan.transaksi') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.laporan.transaksi') }}">
          <i class="material-symbols-rounded opacity-5">assessment</i>
          <span class="nav-link-text ms-1">Laporan Transaksi</span>
        </a>
      </li>

      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kasir.transaksi.riwayat') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.transaksi.riwayat') }}">
              <i class="material-symbols-rounded opacity-5">receipt_long</i>
              <span class="nav-link-text ms-1">Riwayat Transaksi</span>
          </a>
          <a class="nav-link {{ request()->routeIs('kasir.transaksi.riwayat') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.transaksi.riwayat') }}">
              <i class="material-symbols-rounded opacity-5">receipt_long</i>
              <span class="nav-link-text ms-1">Riwayat Transaksi</span>
          </a>
      </li>

      {{-- Notifikasi --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Notifikasi</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark" href="#">
          <i class="material-symbols-rounded opacity-5">inventory</i>
          <span class="nav-link-text ms-1">Stok Minimum</span>
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
