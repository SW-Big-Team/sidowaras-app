{{--
  Karyawan Sidebar Component - ENHANCED
  Description: Premium modern navigation sidebar for karyawan panel
  Features: Glassmorphism, user profile, animated hover states, section headers
--}}

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
                ['icon' => 'receipt_long', 'label' => 'Riwayat Transaksi', 'route' => 'karyawan.transaksi.index', 'active' => 'karyawan.transaksi.*'],
            ],
        ],
        [w
            'title' => 'Manajemen Stok',
            'items' => [
                ['icon' => 'inventory_2', 'label' => 'Daftar Stok', 'route' => 'stok.index'],
                ['icon' => 'shopping_cart', 'label' => 'Pembelian Obat', 'route' => 'pembelian.index', 'active' => 'pembelian.*'],
                ['icon' => 'fact_check', 'label' => 'Stock Opname', 'route' => 'stokopname.index', 'active' => 'stokopname.*'],
            ],
        ]
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
        onclick="toggleSidebar()"
    >close</i>
    
    {{-- Sidebar Header with Brand --}}
    <div class="sidenav-header" style="padding: 1.5rem 1.25rem 1rem;">
        <a class="navbar-brand m-0 p-0" href="{{ route('karyawan.dashboard') }}" style="text-decoration: none;">
            <div class="d-flex align-items-center">
                <div style="
                    width: 44px;
                    height: 44px;
                    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
                    margin-right: 12px;
                ">
                    <i class="material-symbols-rounded text-white" style="font-size: 24px;">local_pharmacy</i>
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
                        color: #3b82f6;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    ">Karyawan Panel</span>
                </div>
            </div>
        </a>
    </div>
    
    {{-- User Profile Card --}}
    <div style="padding: 0 1rem 1rem;">
        <div style="
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 12px;
            padding: 0.875rem;
            border: 1px solid rgba(59, 130, 246, 0.1);
        ">
            <div class="d-flex align-items-center">
                <div style="
                    width: 40px;
                    height: 40px;
                    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-right: 10px;
                    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
                ">
                    <span style="color: white; font-weight: 600; font-size: 0.9rem;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'K', 0, 1)) }}
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
                    ">{{ Auth::user()->name ?? 'Karyawan' }}</div>
                    <div style="
                        font-size: 0.7rem;
                        color: #3b82f6;
                        font-weight: 500;
                    ">{{ Auth::user()->role->nama_role ?? 'Karyawan' }}</div>
                </div>
                <div style="
                    width: 8px;
                    height: 8px;
                    background: #22c55e;
                    border-radius: 50%;
                    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
                "></div>
            </div>
        </div>
    </div>
    
    {{-- Navigation Menu --}}
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: calc(100vh - 260px); overflow-y: auto;">
        <ul class="navbar-nav" id="sidenav-scrollbar" role="menu" style="padding: 0 0.75rem;">
            @foreach($navGroups as $group)
                {{-- Section Header --}}
                <li class="nav-item" role="presentation" style="margin-top: 1.25rem; margin-bottom: 0.5rem;">
                    <div style="display: flex; align-items: center; padding: 0 0.5rem;">
                        <div style="flex: 1; height: 1px; background: linear-gradient(90deg, #e2e8f0, transparent);"></div>
                        <span style="
                            font-size: 0.65rem;
                            font-weight: 600;
                            color: #94a3b8;
                            text-transform: uppercase;
                            letter-spacing: 0.8px;
                            padding: 0 10px;
                            white-space: nowrap;
                        ">{{ $group['title'] }}</span>
                        <div style="flex: 1; height: 1px; background: linear-gradient(90deg, transparent, #e2e8f0);"></div>
                    </div>
                </li>
                
                {{-- Section Items --}}
                @foreach($group['items'] as $item)
                    @php
                        $activePattern = $item['active'] ?? $item['route'];
                        $isActive = request()->routeIs($activePattern);
                        $isDisabled = $item['disabled'] ?? false;
                    @endphp
                    <li class="nav-item" role="presentation" style="margin-bottom: 2px;">
                        <a 
                            class="nav-link {{ $isActive ? 'active' : '' }} {{ $isDisabled ? 'opacity-6 pe-none' : '' }}" 
                            href="{{ $isDisabled ? 'javascript:;' : route($item['route']) }}"
                            role="menuitem"
                            style="
                                padding: 0.65rem 1rem;
                                border-radius: 10px;
                                transition: all 0.2s ease;
                                {{ $isActive ? '
                                    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                                    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
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
                                @if(isset($item['badge']))
                                    <span class="badge badge-sm bg-gradient-danger ms-auto">{{ $item['badge'] }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
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

/* Mobile Sidebar Logic */
@media (max-width: 1199px) {
    #sidenav-main {
        position: fixed !important;
        left: 0 !important;
        margin-left: 0 !important; 
        transform: translateX(-110%);
        height: 100vh;
        box-shadow: none;
        transition: transform 0.3s ease-in-out;
        z-index: 1050;
    }
    #sidenav-main.mobile-visible {
        transform: translateX(0) !important;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    body.sidebar-open::before {
        content: '';
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1040;
        backdrop-filter: blur(2px);
    }
}
</style>