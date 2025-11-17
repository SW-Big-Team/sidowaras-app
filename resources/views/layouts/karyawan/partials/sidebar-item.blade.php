{{--
  Sidebar Item Component
  Description: Reusable navigation item for sidebar menu
  
  Props:
  - $route: Route pattern for active state matching
  - $routeIndex: Actual route to navigate to (defaults to $route)
  - $icon: Material Symbols icon name
  - $label: Display text for the menu item
--}}

@php
    $targetRoute = $routeIndex ?? $route;
    $pattern = $routePattern ?? $route;
    $isActive = request()->routeIs($pattern);
    $linkClasses = 'karyawan-nav-link'.($isActive ? ' active' : '');
@endphp

<li class="nav-item" role="presentation">
    <a 
        class="{{ $linkClasses }}" 
        href="{{ route($targetRoute) }}"
        role="menuitem"
        aria-current="{{ $isActive ? 'page' : 'false' }}"
    >
        <span class="icon" aria-hidden="true">
            <i class="material-symbols-rounded">{{ $icon }}</i>
        </span>
        <span class="nav-link-text ms-1">{{ $label }}</span>
    </a>
</li>
