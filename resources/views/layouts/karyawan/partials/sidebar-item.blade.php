{{-- 
  Sidebar Item Component
  Props:
  - $route: Route pattern for active state
  - $routeIndex: Route name for navigation (optional)
  - $icon: Material Symbols icon
  - $label: Menu label
--}}

@php
    $targetRoute = $routeIndex ?? $route;
    $pattern = $routePattern ?? $route;
    $isActive = request()->routeIs($pattern);
@endphp

<li class="nav-item">
    <a 
        href="{{ route($targetRoute) }}"
        @class([
            'nav-link',
            'active bg-gradient-primary text-white' => $isActive,
            'text-dark' => ! $isActive,
        ])
    >
        <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i 
                class="material-symbols-rounded"
                @class([
                    'text-white' => $isActive,
                    'text-dark' => ! $isActive,
                ])
            >
                {{ $icon }}
            </i>
        </div>

        <span class="nav-link-text ms-1">{{ $label }}</span>
    </a>
</li>
