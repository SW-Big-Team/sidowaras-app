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

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start ms-2 my-2 rounded-4" id="sidenav-main" aria-label="Navigasi karyawan">
  <div class="sidenav-header py-3 px-4">
    <button class="btn btn-link text-muted p-0 d-xl-none" type="button" aria-label="Tutup sidebar" onclick="toggleSidebar()">
      <i class="material-symbols-rounded">close</i>
    </button>
    <a class="navbar-brand d-flex align-items-center gap-3 py-2" href="{{ route('karyawan.dashboard') }}">
      <div class="stats-card-icon mb-0" aria-hidden="true">
        <i class="material-symbols-rounded">badge</i>
      </div>
      <div>
        <small class="text-muted d-block">Sidowaras App</small>
        <span class="fw-semibold">Panel Karyawan</span>
      </div>
    </a>
  </div>
  <div class="collapse navbar-collapse w-auto h-auto px-3 pb-4" id="sidenav-collapse-main">
    @foreach($navGroups as $group)
      <div class="mb-3">
        <p class="karyawan-nav-section-title mb-2">{{ $group['title'] }}</p>
        <ul class="navbar-nav" role="menu">
          @foreach($group['items'] as $item)
            @php
                $activePattern = $item['active'] ?? $item['route'];
                $isActive = request()->routeIs($activePattern);
                $linkClasses = 'karyawan-nav-link'.($isActive ? ' active' : '');
                $isDisabled = $item['disabled'] ?? false;
            @endphp
            <li class="nav-item mb-1" role="none">
              <a
                class="{{ $linkClasses }} {{ $isDisabled ? 'disabled opacity-60' : '' }}"
                href="{{ $isDisabled ? '#' : route($item['route']) }}"
                role="menuitem"
                aria-current="{{ $isActive ? 'page' : 'false' }}"
                aria-disabled="{{ $isDisabled ? 'true' : 'false' }}"
              >
                <span class="icon" aria-hidden="true">
                  <i class="material-symbols-rounded">{{ $item['icon'] }}</i>
                </span>
                <span>{{ $item['label'] }}</span>
                @if(isset($item['badge']))
                  <span class="badge-soft ms-auto">{{ $item['badge'] }}</span>
                @endif
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    @endforeach

    <div class="mt-4 pt-3 border-top">
      <a
        class="karyawan-nav-link text-danger"
        href="#"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
      >
        <span class="icon" aria-hidden="true" style="background: rgba(248, 113, 113, 0.12); color: #dc2626;">
          <i class="material-symbols-rounded">logout</i>
        </span>
        <span class="fw-semibold">Logout</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
  </div>
</aside>
