<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      @yield('breadcrumb')
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group input-group-outline">
          <label class="form-label">Cari...</label>
          <input type="text" class="form-control">
        </div>
      </div>
      <ul class="navbar-nav d-flex align-items-center justify-content-end">
        <li class="nav-item d-flex align-items-center">
          <a href="#" class="nav-link text-body font-weight-bold px-0">
            <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
          </a>
        </li>
        <li class="mt-1">
          <a class="nav-link text-body p-0 position-relative" href="#" target="_blank">
            <i class="material-symbols-rounded">notifications</i>
            <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
              <span class="small">12</span>
              <span class="visually-hidden">unread notifications</span>
            </span>
          </a>
        </li>
        <li class="nav-item dropdown d-flex align-items-center px-3">
          <a href="#" class="nav-link text-body font-weight-bold px-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="material-symbols-rounded">account_circle</i>
            <span class="d-sm-inline d-none ms-1">{{ Auth::user()->nama ?? 'Administrator' }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end me-sm-n4 px-2 py-3" aria-labelledby="dropdownMenuButton">
            <li class="mb-2">
              <a class="dropdown-item border-radius-md" href="#">
                <div class="d-flex py-1">
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm font-weight-normal mb-1">
                      <span class="font-weight-bold">Profil Saya</span>
                    </h6>
                    <p class="text-xs text-secondary mb-0">
                      <i class="fa fa-user me-1"></i>
                      Lihat & edit profil
                    </p>
                  </div>
                </div>
              </a>
            </li>
            <li class="mb-2">
              <a class="dropdown-item border-radius-md" href="#">
                <div class="d-flex py-1">
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm font-weight-normal mb-1">
                      <span class="font-weight-bold">Pengaturan</span>
                    </h6>
                    <p class="text-xs text-secondary mb-0">
                      <i class="fa fa-cog me-1"></i>
                      Konfigurasi sistem
                    </p>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item border-radius-md" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                <div class="d-flex py-1">
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm font-weight-normal mb-1">
                      <span class="font-weight-bold text-danger">Logout</span>
                    </h6>
                    <p class="text-xs text-secondary mb-0">
                      <i class="fa fa-sign-out me-1"></i>
                      Keluar dari sistem
                    </p>
                  </div>
                </div>
              </a>
              <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
