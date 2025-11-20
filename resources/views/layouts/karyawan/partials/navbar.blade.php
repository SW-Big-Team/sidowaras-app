@php
    use Illuminate\Support\Facades\Route;

    $notifications = $notifications ?? collect();
    $unreadNotificationCount = $unreadNotificationCount ?? $notifications->whereNull('read_at')->count();

    // 1) Ambil dari section 'page_title' kalau ada
    $rawSectionTitle = trim($__env->yieldContent('page_title'));

    // 2) Mapping route → judul fallback
    $routeName = Route::currentRouteName();
    $routeTitleMap = [
        'karyawan.dashboard'    => 'Dashboard',
        'karyawan.cart.index'   => 'Cart / Scanner',
        'stok.index'            => 'Daftar Stok',
        'pembelian.index'       => 'Pembelian Obat',
        'stokopname.index'      => 'Stock Opname',
        // tambahkan route lain di sini kalau perlu
    ];

    // 3) Susun prioritas:
    //    section('page_title') > $title > route fallback > 'Dashboard'
    $pageTitle = $rawSectionTitle
        ?: ($title ?? ($routeTitleMap[$routeName] ?? 'Dashboard'));
@endphp

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl"
     id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">Halaman</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    {{ $pageTitle }}
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $pageTitle }}</h6>
        </nav>
        
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <!-- Search or other controls could go here -->
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav" onclick="toggleSidebar()">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                
                <!-- Notifications -->
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0"
                       id="dropdownMenuButton"
                       data-bs-toggle="modal"
                       data-bs-target="#notificationsModal"
                       aria-expanded="false">
                        <i class="material-symbols-rounded cursor-pointer fixed-plugin-button-nav">notifications</i>
                        @if($unreadNotificationCount > 0)
                            <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-0 px-1" style="font-size: 0.6rem;">
                                {{ $unreadNotificationCount }}
                            </span>
                        @endif
                    </a>
                </li>

                <!-- Profile Dropdown -->
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 font-weight-bold px-0"
                       id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm rounded-circle bg-gradient-primary me-2 d-flex align-items-center justify-content-center text-white">
                                <i class="material-symbols-rounded text-sm">person</i>
                            </div>
                            <span class="d-sm-inline d-none">{{ Auth::user()->nama ?? 'Karyawan' }}</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="profileDropdown">
                        <li class="mb-2">
                            <div class="dropdown-item border-radius-md">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <div class="avatar avatar-sm bg-gradient-primary me-3 d-flex align-items-center justify-content-center text-white">
                                            <i class="material-symbols-rounded">person</i>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">{{ Auth::user()->nama ?? 'Karyawan' }}</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            {{ Auth::user()->email ?? 'karyawan@sidowaras.com' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <i class="material-symbols-rounded align-middle me-1 text-sm">person</i> Profil Saya
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <i class="material-symbols-rounded align-middle me-1 text-sm">settings</i> Pengaturan
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md text-danger" href="javascript:;"
                               onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-bold mb-1">
                                            <i class="material-symbols-rounded align-middle me-1 text-sm">logout</i> Logout
                                        </h6>
                                    </div>
                                </div>
                            </a>
                            <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                
                <!-- Settings Toggle (Desktop) -->
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 fixed-plugin-button-nav">
                        <i class="material-symbols-rounded fixed-plugin-button-nav cursor-pointer">settings</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
