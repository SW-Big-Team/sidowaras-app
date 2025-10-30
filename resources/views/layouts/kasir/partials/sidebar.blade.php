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

<<<<<<< HEAD
      <!-- Manajemen Stok -->
=======
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

      {{-- Transaksi --}}
>>>>>>> 1976067 (feat: update sidebar navigation to include 'Manajemen Obat' section and restore 'Pembelian' link across admin, karyawan, and kasir layouts)
      <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Manajemen Stok</h6>
      </li>
<<<<<<< HEAD
=======

      {{-- Pembelian --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Pembelian</span>
          </a>
      </li>



      {{-- Cart Approval --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.index') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded">shopping_cart</i>
              <span class="nav-link-text ms-1">Pembelian Obat</span>
          </a>
      </li>

<<<<<<< HEAD
      {{-- Kandungan Obat --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kandungan.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kandungan.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Kandungan Obat</span>
          </a>
      </li>

      {{-- Kategori Obat --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('pembelian.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Pembelian</span>
          </a>
      </li>

      {{-- Satuan Obat --}}
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('satuan.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('satuan.index') }}">
              <i class="material-symbols-rounded opacity-5">dashboard</i>
              <span class="nav-link-text">Satuan Obat</span>
          </a>
      </li>

      {{-- Transaksi --}}
=======
      <!-- Transaksi -->
>>>>>>> 63e5397 (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)
      <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Transaksi</h6>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kasir.cart.approval') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.cart.approval') }}">
              <i class="material-symbols-rounded">shopping_cart</i>
              <span class="nav-link-text ms-1">Approval Cart</span>
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
          <a class="nav-link {{ request()->routeIs('kasir.transaksi.riwayat') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.transaksi.riwayat') }}">
<<<<<<< HEAD
              <i class="material-symbols-rounded">receipt_long</i>
              <span class="nav-link-text ms-1">Riwayat Transaksi</span>
          </a>
<<<<<<< HEAD
<<<<<<< HEAD
          <a class="nav-link {{ request()->routeIs('kasir.transaksi.riwayat') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kasir.transaksi.riwayat') }}">
              <i class="material-symbols-rounded opacity-5">receipt_long</i>
              <span class="nav-link-text ms-1">Riwayat Transaksi</span>
          </a>
=======
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
=======
=======
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
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
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
