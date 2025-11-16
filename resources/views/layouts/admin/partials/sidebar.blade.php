<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start ms-2 bg-white my-2 shadow-lg" id="sidenav-main" style="border-radius: 1rem;">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="{{ route('admin.dashboard') }}">
      <div class="d-flex align-items-center">
        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-2">
          <i class="material-symbols-rounded opacity-10 text-white">medical_services</i>
        </div>
        <div>
          <span class="font-weight-bold text-dark d-block">Sidowaras</span>
          <span class="text-xs text-secondary">Admin Panel</span>
        </div>
      </div>
    </a>
  </div>
  <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav" id="sidenav-scrollbar">

      {{-- Dashboard --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.dashboard') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      {{-- Manajemen Obat --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Obat</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.obat.*') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.obat.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">medication</i>
          </div>
          <span class="nav-link-text ms-1">Data Obat</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.kategori.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">category</i>
          </div>
          <span class="nav-link-text ms-1">Kategori</span>
        </a>
      </li>

      {{-- Satuan Obat --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.satuan.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('admin.satuan.index') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text">Satuan Obat</span>
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
        <a class="nav-link {{ request()->routeIs('admin.satuan.*') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.satuan.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">straighten</i>
          </div>
          <span class="nav-link-text ms-1">Satuan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.kandungan.*') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.kandungan.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">science</i>
          </div>
          <span class="nav-link-text ms-1">Kandungan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.supplier.*') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.supplier.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">local_shipping</i>
          </div>
          <span class="nav-link-text ms-1">Supplier</span>
        </a>
      </li>

      {{-- Manajemen Stok --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Stok</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.stok.index') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.stok.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">inventory_2</i>
          </div>
          <span class="nav-link-text ms-1">Daftar Stok</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pembelian.index') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">shopping_cart</i>
          </div>
          <span class="nav-link-text ms-1">Pembelian Obat</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('opname.index') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('opname.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">fact_check</i>
          </div>
          <span class="nav-link-text ms-1">Stok Opname</span>
        </a>
      </li>

      {{-- Transaksi & Laporan --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Laporan</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.transaksi.riwayat') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.transaksi.riwayat') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">receipt_long</i>
          </div>
          <span class="nav-link-text ms-1">Riwayat Transaksi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.laporan.index') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.laporan.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">analytics</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard Laporan</span>
        </a>
      </li>

      {{-- Manajemen Akun --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Sistem</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active bg-gradient-primary text-white' : 'text-dark' }}" href="{{ route('admin.users.index') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">group</i>
          </div>
          <span class="nav-link-text ms-1">Pengguna</span>
        </a>
      </li>
      
      {{-- Logout --}}
      <li class="nav-item mt-4 mb-2">
        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">logout</i>
          </div>
          <span class="nav-link-text ms-1">Logout</span>
        </a>
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</aside>
