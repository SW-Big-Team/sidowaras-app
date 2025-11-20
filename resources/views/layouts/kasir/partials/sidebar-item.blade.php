@props(['route', 'icon', 'label', 'badge' => null, 'disabled' => false, 'active' => null])

@php
    $activePattern = $active ?? $route;
    $isActive = request()->routeIs($activePattern);
    $isDisabled = $disabled;
@endphp

<li class="nav-item">
    <a class="nav-link {{ $isActive ? 'active bg-gradient-success text-white' : 'text-dark' }} {{ $isDisabled ? 'opacity-6 pe-none' : '' }}"
       href="{{ $isDisabled ? 'javascript:;' : route($route) }}">
        <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded {{ $isActive ? 'text-white' : 'text-dark' }}">
                {{ $icon }}
            </i>
        </div>
        <span class="nav-link-text ms-1">{{ $label }}</span>
        @if($badge)
            <span class="badge badge-sm bg-gradient-danger ms-auto">{{ $badge }}</span>
        @endif
    </a>
</li>
