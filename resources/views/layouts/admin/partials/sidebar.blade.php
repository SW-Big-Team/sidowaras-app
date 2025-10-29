<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
      <span class="ms-1 text-sm text-dark">Admin Panel</span>
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

      {{-- Manajemen Obat --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Obat</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.obat.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.obat.index') }}">
          <i class="material-symbols-rounded opacity-5">inventory</i>
          <span class="nav-link-text ms-1">Obat</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.kategori.index') }}">
          <i class="material-symbols-rounded opacity-5">category</i>
          <span class="nav-link-text ms-1">Kategori</span>
        </a>
      </li>
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
      
      {{-- Manajemen Sistem --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Sistem</h6>
      </li>

      {{-- Pembelian --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Pembelian</span>
          </a>
      </li>

      {{-- Manajemen Pengguna --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.users.index') }}">
          <i class="material-symbols-rounded opacity-5">group</i>
          <span class="nav-link-text ms-1">Manajemen Pengguna</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.kandungan.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.kandungan.index') }}">
          <i class="material-symbols-rounded opacity-5">science</i>
          <span class="nav-link-text ms-1">Kandungan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.supplier.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.supplier.index') }}">
          <i class="material-symbols-rounded opacity-5">local_shipping</i>
          <span class="nav-link-text ms-1">Supplier</span>
        </a>
      </li>

      {{-- Manajemen Stok --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Stok</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.stok.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.stok.index') }}">
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
        <a class="nav-link {{ request()->routeIs('opname.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('opname.index') }}">
          <i class="material-symbols-rounded opacity-5">fact_check</i>
          <span class="nav-link-text ms-1">Stok Opname</span>
        </a>
      </li>

      {{-- Transaksi & Laporan --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Laporan</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.transaksi.riwayat') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.transaksi.riwayat') }}">
          <i class="material-symbols-rounded opacity-5">receipt_long</i>
          <span class="nav-link-text ms-1">Riwayat Transaksi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.laporan.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.laporan.index') }}">
          <i class="material-symbols-rounded opacity-5">description</i>
          <span class="nav-link-text ms-1">Laporan</span>
        </a>
      </li>

      {{-- Manajemen Akun --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Akun</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.users.index') }}">
          <i class="material-symbols-rounded opacity-5">people</i>
          <span class="nav-link-text ms-1">Pengguna</span>
        </a>
      </li>
    </ul>
  </div>
</aside>