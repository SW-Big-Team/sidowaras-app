{{--
  Admin Sidebar Component
  Description: Main navigation sidebar for admin panel
  Features: Hierarchical menu, active state indicators, responsive design
--}}

@php
    // Menu configuration - centralized for easy maintenance
    $menuItems = [
        [
            'type' => 'single',
            'route' => 'admin.dashboard',
            'icon' => 'dashboard',
            'label' => 'Dashboard',
        ],
        [
            'type' => 'section',
            'label' => 'Manajemen Obat',
            'items' => [
                ['route' => 'admin.obat.*', 'routeIndex' => 'admin.obat.index', 'icon' => 'medication', 'label' => 'Data Obat'],
                ['route' => 'admin.kategori.*', 'routeIndex' => 'admin.kategori.index', 'icon' => 'category', 'label' => 'Kategori'],
                ['route' => 'admin.satuan.*', 'routeIndex' => 'admin.satuan.index', 'icon' => 'straighten', 'label' => 'Satuan'],
                ['route' => 'admin.kandungan.*', 'routeIndex' => 'admin.kandungan.index', 'icon' => 'science', 'label' => 'Kandungan'],
                ['route' => 'admin.supplier.*', 'routeIndex' => 'admin.supplier.index', 'icon' => 'local_shipping', 'label' => 'Supplier'],
            ]
        ],
        [
            'type' => 'section',
            'label' => 'Manajemen Stok',
            'items' => [
                ['route' => 'admin.stok.index', 'routeIndex' => 'admin.stok.index', 'icon' => 'inventory_2', 'label' => 'Daftar Stok'],
                ['route' => 'pembelian.*', 'routeIndex' => 'pembelian.index', 'icon' => 'shopping_cart', 'label' => 'Pembelian Obat'],
                ['route' => 'stokopname.*', 'routeIndex' => 'stokopname.index', 'icon' => 'inventory', 'label' => 'Riwayat Opname'],
                ['route' => 'admin.stokopname.*', 'routeIndex' => 'admin.stokopname.pending', 'icon' => 'pending_actions', 'label' => 'Approval Opname'],
            ]
        ],
        [
            'type' => 'section',
            'label' => 'Laporan',
            'items' => [
                ['route' => 'admin.transaksi.riwayat', 'routeIndex' => 'admin.transaksi.riwayat', 'icon' => 'receipt_long', 'label' => 'Riwayat Transaksi'],
                ['route' => 'admin.laporan.index', 'routeIndex' => 'admin.laporan.index', 'icon' => 'analytics', 'label' => 'Dashboard Laporan'],
            ]
        ],
        [
            'type' => 'section',
            'label' => 'Sistem',
            'items' => [
                ['route' => 'admin.users.*', 'routeIndex' => 'admin.users.index', 'icon' => 'group', 'label' => 'Pengguna'],
            ]
        ],
    ];
@endphp

<aside 
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start ms-2 bg-white my-2 shadow-lg" 
    id="sidenav-main" 
    style="border-radius: 1rem;"
    aria-label="Main navigation"
>
    {{-- Sidebar Header --}}
    <div class="sidenav-header">
        <i 
            class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" 
            aria-hidden="true" 
            id="iconSidenav"
            role="button"
            tabindex="0"
        ></i>
        
        <a class="navbar-brand px-4 py-3 m-0" href="{{ route('admin.dashboard') }}" aria-label="Sidowaras Admin Panel">
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
    
    {{-- Navigation Menu --}}
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav" id="sidenav-scrollbar" role="menu">
            @foreach($menuItems as $menuItem)
                @if($menuItem['type'] === 'single')
                    {{-- Single Menu Item --}}
                    @include('layouts.admin.partials.sidebar-item', [
                        'route' => $menuItem['route'],
                        'icon' => $menuItem['icon'],
                        'label' => $menuItem['label'],
                    ])
                @elseif($menuItem['type'] === 'section')
                    {{-- Section Header --}}
                    <li class="nav-item mt-3" role="presentation">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
                            {{ $menuItem['label'] }}
                        </h6>
                    </li>
                    
                    {{-- Section Items --}}
                    @foreach($menuItem['items'] as $item)
                        @include('layouts.admin.partials.sidebar-item', [
                            'route' => $item['route'],
                            'routeIndex' => $item['routeIndex'],
                            'icon' => $item['icon'],
                            'label' => $item['label'],
                        ])
                    @endforeach
                @endif
            @endforeach
            
            {{-- Logout Button --}}
            <li class="nav-item mt-4 mb-2" role="presentation">
                <a 
                    class="nav-link text-danger" 
                    href="#" 
                    onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                    role="menuitem"
                >
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
