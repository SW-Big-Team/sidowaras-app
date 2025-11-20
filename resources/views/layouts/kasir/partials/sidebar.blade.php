@php
    $navGroups = [
        [
            'title' => 'Utama',
            'items' => [
                ['icon' => 'dashboard', 'label' => 'Dashboard', 'route' => 'kasir.dashboard'],
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
            'title' => 'Transaksi',
            'items' => [
                ['icon' => 'approval', 'label' => 'Approval Cart', 'route' => 'kasir.cart.approval'],
                ['icon' => 'receipt_long', 'label' => 'Riwayat Transaksi', 'route' => 'kasir.transaksi.riwayat'],
            ],
        ],
    ];
@endphp

{{-- SIDEBAR HTML --}}
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
    <div class="sidenav-header">
        {{-- Close 'X' icon inside sidebar (for mobile) --}}
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
           aria-hidden="true"
           id="iconSidenav"
           onclick="toggleSidebar()"></i>

        <a class="navbar-brand m-0 d-flex align-items-center" href="{{ route('kasir.dashboard') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-symbols-rounded text-success text-gradient">point_of_sale</i>
            </div>
            <span class="ms-1 font-weight-bold text-dark">Kasir Panel</span>
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
                        <a class="nav-link {{ $isActive ? 'active bg-gradient-success text-white' : 'text-dark' }} {{ $isDisabled ? 'opacity-6 pe-none' : '' }}"
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