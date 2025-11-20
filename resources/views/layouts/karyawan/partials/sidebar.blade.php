@php
    $navGroups = [
        [
            'title' => 'Utama',
            'items' => [
                ['icon' => 'dashboard', 'label' => 'Dashboard', 'route' => 'karyawan.dashboard'],
            ],
        ],
        [
            'title' => 'Operasional',
            'items' => [
                ['icon' => 'qr_code_scanner', 'label' => 'Cart / Scanner', 'route' => 'karyawan.cart.index'],
            ],
        ],
        [
            'title' => 'Manajemen Stok',
            'items' => [
                ['icon' => 'inventory_2', 'label' => 'Daftar Stok', 'route' => 'stok.index'],
                ['icon' => 'shopping_cart', 'label' => 'Pembelian Obat', 'route' => 'pembelian.index', 'active' => 'pembelian.*'],
                ['icon' => 'fact_check', 'label' => 'Stock Opname', 'route' => 'stokopname.index', 'active' => 'stokopname.*'],
            ],
        ],
        [
            'title' => 'Lainnya',
            'items' => [
                ['icon' => 'notifications', 'label' => 'Notifikasi', 'route' => 'karyawan.dashboard', 'disabled' => true, 'badge' => 5],
            ],
        ],
        [
            'title' => 'Akun',
            'items' => [
                ['icon' => 'person', 'label' => 'Profil Saya', 'route' => 'karyawan.dashboard', 'disabled' => true],
            ],
        ],
    ];
@endphp

{{-- SIDEBAR --}}
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
           aria-hidden="true"
           id="iconSidenav"
           onclick="toggleSidebar()"></i>

        <a class="navbar-brand m-0 d-flex align-items-center" href="{{ route('karyawan.dashboard') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-symbols-rounded text-primary text-gradient">local_pharmacy</i>
            </div>
            <span class="ms-1 font-weight-bold text-dark">Sidowaras Karyawan</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @foreach($navGroups as $group)
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ $group['title'] }}</h6>
                </li>
                @foreach($group['items'] as $item)
                    @php
                        $activePattern = $item['active'] ?? $item['route'];
                        $isActive = request()->routeIs($activePattern);
                        $isDisabled = $item['disabled'] ?? false;
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive ? 'active bg-gradient-primary text-white' : 'text-dark' }} {{ $isDisabled ? 'opacity-6 pe-none' : '' }}"
                           href="{{ $isDisabled ? 'javascript:;' : route($item['route']) }}">
                            <div class="text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-symbols-rounded {{ $isActive ? 'text-white' : 'text-dark' }}">
                                    {{ $item['icon'] }}
                                </i>
                            </div>
                            <span class="nav-link-text ms-1">{{ $item['label'] }}</span>
                            @if(isset($item['badge']))
                                <span class="badge badge-sm bg-gradient-danger ms-auto">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</aside>

{{-- TOGGLE BUTTON (BOTTOM RIGHT) --}}
<div class="sidebar-toggle-plugin">
    <a class="sidebar-toggle-button" onclick="toggleSidebar()" id="sidebarToggleBtn">
        <i class="material-symbols-rounded" id="sidebarToggleIcon">menu</i>
    </a>
</div>

{{-- STYLE & SCRIPT --}}
<style>
    /* Animasi / transisi hide-show sidebar */
    #sidenav-main {
        transition: transform 0.25s ease, opacity 0.2s ease;
    }

    /* Keadaan tersembunyi: benar-benar keluar layar + tidak bisa diklik */
    #sidenav-main.sidenav-hidden {
        transform: translateX(-150%);
        opacity: 0;
        pointer-events: none;
    }

    /* Supaya konten bisa melebar kalau sidebar disembunyikan (opsional) */
    .main-content.sidebar-collapsed {
        margin-left: 0 !important;
    }

    .sidebar-toggle-plugin {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
    }

    .sidebar-toggle-button {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.18);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        transition: all 0.2s ease-in-out;
    }

    .sidebar-toggle-button:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
    }

    .sidebar-toggle-button i {
        font-size: 28px;
        color: #333;
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar   = document.getElementById('sidenav-main');
        const main      = document.querySelector('.main-content');
        const icon      = document.getElementById('sidebarToggleIcon');

        sidebar.classList.toggle('sidenav-hidden');

        // Optional: lebarkan main-content ketika sidebar disembunyikan
        if (main) {
            main.classList.toggle('sidebar-collapsed');
        }

        // Ubah ikon antara menu / close
        if (icon) {
            const isHidden = sidebar.classList.contains('sidenav-hidden');
            icon.textContent = isHidden ? 'menu' : 'close';
        }
    }
</script>
