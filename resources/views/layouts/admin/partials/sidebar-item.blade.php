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
    $isActive = request()->routeIs($route);
    $linkClasses = $isActive 
        ? 'nav-link active bg-gradient-primary text-white' 
        : 'nav-link text-dark';
@endphp

<li class="nav-item" role="presentation">
    <a 
        class="{{ $linkClasses }}" 
        href="{{ route($targetRoute) }}"
        role="menuitem"
        aria-current="{{ $isActive ? 'page' : 'false' }}"
    >
        <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">{{ $icon }}</i>
        </div>
        <span class="nav-link-text ms-1">{{ $label }}</span>
    </a>
</li>
