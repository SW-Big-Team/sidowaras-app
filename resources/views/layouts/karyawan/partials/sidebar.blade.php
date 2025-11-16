<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start ms-2 my-2 rounded-3" id="sidenav-main" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="{{ route('karyawan.dashboard') }}" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 0.75rem; margin: 0.5rem;">
      <div class="d-flex align-items-center">
        <div style="background: white; padding: 0.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
          <i class="material-symbols-rounded" style="font-size: 1.5rem; color: #f59e0b;">badge</i>
        </div>
        <span class="ms-2 font-weight-bold text-white">Karyawan Panel</span>
      </div>
    </a>
  </div>
  <hr class="horizontal dark mt-2 mb-2 mx-3" style="opacity: 0.1;">
  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      {{-- Dashboard --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'text-white' : 'text-dark' }} mb-0 px-4" 
           href="{{ route('karyawan.dashboard') }}"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem; {{ request()->routeIs('karyawan.dashboard') ? 'background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);' : '' }}">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #f59e0b;">dashboard</i>
          </div>
          <span class="nav-link-text ms-1 font-weight-bold">Dashboard</span>
        </a>
      </li>

      {{-- Operasional --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder" style="color: #d97706; letter-spacing: 0.5px;">Operasional</h6>
      </li>

      {{-- Cart & Scanner --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('karyawan.cart.index') ? 'text-white' : 'text-dark' }} mb-0 px-4" 
           href="{{ route('karyawan.cart.index') }}"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem; {{ request()->routeIs('karyawan.cart.index') ? 'background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);' : '' }}">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #f59e0b;">qr_code_scanner</i>
          </div>
          <span class="nav-link-text ms-1">Cart / Scanner</span>
        </a>
      </li>

      {{-- Manajemen Stok --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder" style="color: #d97706; letter-spacing: 0.5px;">Manajemen Stok</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('stok.index') ? 'text-white' : 'text-dark' }} mb-0 px-4" 
           href="{{ route('stok.index') }}"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem; {{ request()->routeIs('stok.index') ? 'background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);' : '' }}">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #f59e0b;">inventory_2</i>
          </div>
          <span class="nav-link-text ms-1">Daftar Stok</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pembelian.index') ? 'text-white' : 'text-dark' }} mb-0 px-4" 
           href="{{ route('pembelian.index') }}"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem; {{ request()->routeIs('pembelian.index') ? 'background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);' : '' }}">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #f59e0b;">shopping_cart</i>
          </div>
          <span class="nav-link-text ms-1">Pembelian Obat</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('opname.index') ? 'text-white' : 'text-dark' }} mb-0 px-4" 
           href="{{ route('opname.index') }}"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem; {{ request()->routeIs('opname.index') ? 'background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);' : '' }}">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #f59e0b;">fact_check</i>
          </div>
          <span class="nav-link-text ms-1">Stok Opname</span>
        </a>
      </li>

      {{-- Notifikasi --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder" style="color: #d97706; letter-spacing: 0.5px;">Lainnya</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark mb-0 px-4" href="#"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem; position: relative;">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #f59e0b;">notifications</i>
          </div>
          <span class="nav-link-text ms-1">Notifikasi</span>
          <span class="badge badge-sm ms-auto" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">5</span>
        </a>
      </li>

      {{-- Account --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder" style="color: #d97706; letter-spacing: 0.5px;">Akun</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark mb-0 px-4" href="#"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem;">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #f59e0b;">person</i>
          </div>
          <span class="nav-link-text ms-1">Profil Saya</span>
        </a>
      </li>

      <li class="nav-item mb-2">
        <a class="nav-link text-dark mb-0 px-4" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           style="border-radius: 0.5rem; margin: 0.25rem 0.75rem; border: 2px solid #fee2e2; background: #fef2f2;">
          <div class="icon icon-sm shadow-sm border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;">
            <i class="material-symbols-rounded" style="font-size: 1.25rem; color: #dc2626;">logout</i>
          </div>
          <span class="nav-link-text ms-1 text-danger font-weight-bold">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</aside>

<style>
  .nav-link:not(.active):hover {
    background: rgba(245, 158, 11, 0.1) !important;
    transform: translateX(4px);
    transition: all 0.3s ease;
  }
  
  .nav-link {
    transition: all 0.3s ease;
  }
  
  #sidenav-main {
    transition: all 0.3s ease;
  }
</style>
