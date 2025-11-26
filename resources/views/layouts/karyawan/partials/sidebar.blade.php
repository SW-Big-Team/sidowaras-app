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
        ]
    ];
@endphp

{{-- SIDEBAR HTML --}}
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
    <div class="sidenav-header">
        {{-- Close 'X' icon inside sidebar (optional, strictly for mobile internal closing) --}}
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
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

{{-- NOTE: The Toggle Button HTML is REMOVED from here because you have it in sidebar-toggle.blade.php --}}

{{-- STYLE & SCRIPT FOR SIDEBAR BEHAVIOR --}}
<style>
    /* --- DESKTOP --- */
    #sidenav-main {
        transition: transform 0.3s ease-in-out;
        z-index: 1050;
    }

    /* --- MOBILE LOGIC (Max-width 1199px) --- */
    @media (max-width: 1199px) {
        #sidenav-main {
            /* Fixed off-screen to the left */
            position: fixed !important;
            left: 0 !important;
            margin-left: 0 !important; 
            transform: translateX(-110%); /* Hidden */
            height: 100vh;
            box-shadow: none;
        }

        /* Class added by JS to show sidebar */
        #sidenav-main.mobile-visible {
            transform: translateX(0) !important; /* Show */
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        
        /* Dark Backdrop */
        body.sidebar-open::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040; /* Behind sidebar, above content */
            backdrop-filter: blur(2px);
        }
    }
</style>