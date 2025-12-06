@php
    // Menu configuration - centralized for easy maintenance
    $menuItems = [
        [
            'type' => 'single',
            'route' => 'kasir.dashboard',
            'icon' => 'dashboard',
            'label' => 'Dashboard',
        ],
        [
            'type' => 'section',
            'label' => 'Manajemen Stok',
            'sectionIcon' => 'inventory_2',
            'items' => [
                ['route' => 'stok.index', 'routeIndex' => 'stok.index', 'icon' => 'inventory_2', 'label' => 'Daftar Stok'],
                ['route' => 'pembelian.*', 'routeIndex' => 'pembelian.index', 'icon' => 'shopping_cart', 'label' => 'Pembelian Obat'],
                ['route' => 'stokopname.*', 'routeIndex' => 'stokopname.index', 'icon' => 'fact_check', 'label' => 'Stock Opname'],
            ]
        ],
        [
            'type' => 'section',
            'label' => 'Transaksi',
            'sectionIcon' => 'receipt_long',
            'items' => [
                ['route' => 'kasir.cart.approval', 'routeIndex' => 'kasir.cart.approval', 'icon' => 'approval', 'label' => 'Approval Cart'],
                ['route' => 'kasir.transaksi.riwayat', 'routeIndex' => 'kasir.transaksi.riwayat', 'icon' => 'receipt_long', 'label' => 'Riwayat Transaksi'],
            ]
        ],
    ];
@endphp

<aside 
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start bg-white" 
    id="sidenav-main" 
    aria-label="Main navigation"
    style="
        border-radius: 0;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
        border-right: 1px solid rgba(0, 0, 0, 0.05);
    "
>
    {{-- Close Button (Mobile) --}}
    <i 
        class="material-symbols-rounded p-3 cursor-pointer text-secondary position-absolute end-0 top-0 d-xl-none" 
        style="font-size: 20px; z-index: 10;"
        aria-hidden="true" 
        id="iconSidenav"
        role="button"
        tabindex="0"
        onclick="toggleSidenav()"
    >close</i>
    
    {{-- Sidebar Header with User Profile --}}
    <div class="sidenav-header" style="padding: 1.5rem 1.25rem 1rem;">
        {{-- Brand Logo --}}
        <a class="navbar-brand m-0 p-0" href="{{ route('kasir.dashboard') }}" style="text-decoration: none;">
            <div class="d-flex align-items-center">
                <div style="
                    width: 44px;
                    height: 44px;
                    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
                    margin-right: 12px;
                ">
                    <i class="material-symbols-rounded text-white" style="font-size: 24px;">point_of_sale</i>
                </div>
                <div>
                    <span style="
                        font-size: 1.1rem;
                        font-weight: 700;
                        color: #1e293b;
                        display: block;
                        letter-spacing: -0.5px;
                    ">Sidowaras</span>
                    <span style="
                        font-size: 0.7rem;
                        color: #10b981;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    ">Kasir Panel</span>
                </div>
            </div>
        </a>
    </div>
    
    {{-- User Profile Card --}}
    <div style="padding: 0 1rem 1rem;">
        <div style="
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-radius: 12px;
            padding: 0.875rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
        ">
            <div class="d-flex align-items-center">
                <div style="
                    width: 40px;
                    height: 40px;
                    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-right: 10px;
                    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
                ">
                    <span style="color: white; font-weight: 600; font-size: 0.9rem;">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'K', 0, 1)) }}
                    </span>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="
                        font-size: 0.85rem;
                        font-weight: 600;
                        color: #0f172a;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    ">{{ Auth::user()->nama_lengkap ?? 'Kasir' }}</div>
                    <div style="
                        font-size: 0.7rem;
                        color: #10b981;
                        font-weight: 500;
                    ">Kasir Staff</div>
                </div>
                <div style="
                    width: 8px;
                    height: 8px;
                    background: #10b981;
                    border-radius: 50%;
                    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
                "></div>
            </div>
        </div>
    </div>
    
    {{-- Navigation Menu --}}
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: calc(100vh - 260px); overflow-y: auto;">
        <ul class="navbar-nav" id="sidenav-scrollbar" role="menu" style="padding: 0 0.75rem;">
            @foreach($menuItems as $menuItem)
                @if($menuItem['type'] === 'single')
                    {{-- Single Menu Item (Dashboard) --}}
                    @php
                        $isActive = request()->routeIs($menuItem['route']);
                    @endphp
                    <li class="nav-item" role="presentation" style="margin-bottom: 4px;">
                        <a 
                            class="nav-link {{ $isActive ? 'active' : '' }}" 
                            href="{{ route($menuItem['route']) }}"
                            role="menuitem"
                            style="
                                padding: 0.75rem 1rem;
                                border-radius: 10px;
                                transition: all 0.2s ease;
                                {{ $isActive ? '
                                    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
                                ' : '' }}
                            "
                            onmouseover="if(!this.classList.contains('active')) { this.style.background='#f1f5f9'; this.style.transform='translateX(4px)'; }"
                            onmouseout="if(!this.classList.contains('active')) { this.style.background='transparent'; this.style.transform='translateX(0)'; }"
                        >
                            <div class="d-flex align-items-center">
                                <div style="
                                    width: 32px;
                                    height: 32px;
                                    border-radius: 8px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    margin-right: 12px;
                                    {{ $isActive ? 'background: rgba(255,255,255,0.2);' : 'background: #f1f5f9;' }}
                                ">
                                    <i class="material-symbols-rounded" style="font-size: 20px; {{ $isActive ? 'color: white;' : 'color: #64748b;' }}">{{ $menuItem['icon'] }}</i>
                                </div>
                                <span style="
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    {{ $isActive ? 'color: white;' : 'color: #334155;' }}
                                ">{{ $menuItem['label'] }}</span>
                            </div>
                        </a>
                    </li>
                @elseif($menuItem['type'] === 'section')
                    {{-- Section Header --}}
                    <li class="nav-item" role="presentation" style="margin-top: 1.25rem; margin-bottom: 0.5rem;">
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 0 0.5rem;
                        ">
                            <div style="flex: 1; height: 1px; background: linear-gradient(90deg, #e2e8f0, transparent);"></div>
                            <span style="
                                font-size: 0.65rem;
                                font-weight: 600;
                                color: #94a3b8;
                                text-transform: uppercase;
                                letter-spacing: 0.8px;
                                padding: 0 10px;
                                white-space: nowrap;
                            ">{{ $menuItem['label'] }}</span>
                            <div style="flex: 1; height: 1px; background: linear-gradient(90deg, transparent, #e2e8f0);"></div>
                        </div>
                    </li>
                    
                    {{-- Section Items --}}
                    @foreach($menuItem['items'] as $item)
                        @php
                            $targetRoute = $item['routeIndex'] ?? $item['route'];
                            $isActive = request()->routeIs($item['route']);
                        @endphp
                        <li class="nav-item" role="presentation" style="margin-bottom: 2px;">
                            <a 
                                class="nav-link {{ $isActive ? 'active' : '' }}" 
                                href="{{ route($targetRoute) }}"
                                role="menuitem"
                                style="
                                    padding: 0.65rem 1rem;
                                    border-radius: 10px;
                                    transition: all 0.2s ease;
                                    {{ $isActive ? '
                                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
                                    ' : '' }}
                                "
                                onmouseover="if(!this.classList.contains('active')) { this.style.background='#f1f5f9'; this.style.transform='translateX(4px)'; }"
                                onmouseout="if(!this.classList.contains('active')) { this.style.background='transparent'; this.style.transform='translateX(0)'; }"
                            >
                                <div class="d-flex align-items-center">
                                    <div style="
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 8px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        margin-right: 10px;
                                        {{ $isActive ? 'background: rgba(255,255,255,0.2);' : 'background: #f8fafc;' }}
                                    ">
                                        <i class="material-symbols-rounded" style="font-size: 18px; {{ $isActive ? 'color: white;' : 'color: #64748b;' }}">{{ $item['icon'] }}</i>
                                    </div>
                                    <span style="
                                        font-size: 0.8rem;
                                        font-weight: 500;
                                        {{ $isActive ? 'color: white;' : 'color: #475569;' }}
                                    ">{{ $item['label'] }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>
    
    {{-- Logout Button at Bottom --}}
    <div style="
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: linear-gradient(180deg, transparent 0%, #f8fafc 20%);
    ">
        <a 
            href="#" 
            onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
            style="
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem;
                border-radius: 10px;
                background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
                border: 1px solid rgba(239, 68, 68, 0.1);
                text-decoration: none;
                transition: all 0.2s ease;
            "
            onmouseover="this.style.background='linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.2)';"
            onmouseout="this.style.background='linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';"
        >
            <i class="material-symbols-rounded" style="font-size: 20px; color: #dc2626; margin-right: 8px;">logout</i>
            <span style="font-size: 0.85rem; font-weight: 600; color: #dc2626;">Keluar</span>
        </a>
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</aside>

<style>
/* Custom Scrollbar for Sidebar */
#sidenav-scrollbar::-webkit-scrollbar {
    width: 4px;
}
#sidenav-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
#sidenav-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
#sidenav-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Nav Link Transitions */
.sidenav .nav-link {
    transition: all 0.2s ease !important;
}
</style>