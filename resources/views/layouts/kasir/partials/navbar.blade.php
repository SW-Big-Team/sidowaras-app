@php
    use Illuminate\Support\Facades\Route;

    $notifications = $notifications ?? collect();
    $unreadNotificationCount = $unreadNotificationCount ?? $notifications->whereNull('read_at')->count();

    $rawSectionTitle = trim($__env->yieldContent('page_title'));

    $routeName = Route::currentRouteName();
    $routeTitleMap = [
        'kasir.dashboard'           => 'Dashboard',
        'kasir.cart.approval'       => 'Approval Cart',
        'kasir.transaksi.riwayat'   => 'Riwayat Transaksi',
        'stok.index'                => 'Daftar Stok',
        'pembelian.index'           => 'Pembelian Obat',
        'stokopname.index'          => 'Stock Opname',
    ];

    $pageTitle = $rawSectionTitle
        ?: ($title ?? ($routeTitleMap[$routeName] ?? 'Dashboard'));
@endphp

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
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
                <!-- Search can be added here if needed -->
            </div>
            <ul class="navbar-nav justify-content-end">
                
                <!-- Notifications -->
                <li class="nav-item pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0"
                       id="notificationsButton"
                       data-bs-toggle="modal"
                       data-bs-target="#notificationsModal"
                       aria-expanded="false">
                        <i class="material-symbols-rounded cursor-pointer">notifications</i>
                        @if($unreadNotificationCount > 0)
                            <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-success border border-white small py-0 px-1" style="font-size: 0.6rem;">
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
                            <div class="avatar avatar-sm rounded-circle bg-gradient-success me-2 d-flex align-items-center justify-content-center text-white">
                                <i class="material-symbols-rounded text-sm">person</i>
                            </div>
                            <span class="d-sm-inline d-none">{{ Auth::user()->nama ?? 'Kasir' }}</span>
                            <i class="material-symbols-rounded ms-2 opacity-8 d-none d-sm-inline">expand_more</i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="profileDropdown">
                        <li class="mb-2">
                            <div class="dropdown-header text-center">
                                <div class="avatar avatar-md rounded-circle bg-gradient-success mx-auto mb-2 d-flex align-items-center justify-content-center text-white">
                                    <i class="material-symbols-rounded">person</i>
                                </div>
                                <h6 class="text-sm font-weight-bold mb-0">{{ Auth::user()->nama ?? 'Kasir' }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ Auth::user()->email ?? 'kasir@sidowaras.com' }}</p>
                            </div>
                        </li>
                        <li>
                            <hr class="horizontal dark mt-2 mb-2">
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="#">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="material-symbols-rounded text-success">person</i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center ms-2">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Profil Saya</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">Lihat & edit profil</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="#">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="material-symbols-rounded text-secondary">settings</i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center ms-2">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Pengaturan</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">Preferensi akun</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="horizontal dark mt-2 mb-2">
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md text-danger" href="javascript:;"
                               onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="material-symbols-rounded text-danger">logout</i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center ms-2">
                                        <h6 class="text-sm font-weight-bold mb-1">Logout</h6>
                                        <p class="text-xs text-secondary mb-0">Keluar dari sistem</p>
                                    </div>
                                </div>
                            </a>
                            <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
