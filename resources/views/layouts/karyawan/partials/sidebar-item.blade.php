{{--
  Modern Sidebar Item Component
  Props: $route, $routeIndex, $icon, $label
--}}

@php
    $targetRoute = $routeIndex ?? $route;
    $isActive = request()->routeIs($route);
@endphp

<li class="sidebar-item {{ $isActive ? 'active' : '' }}">
    <a href="{{ route($targetRoute) }}" class="sidebar-link" role="menuitem" aria-current="{{ $isActive ? 'page' : 'false' }}">
        <div class="link-icon"><i class="material-symbols-rounded">{{ $icon }}</i></div>
        <span class="link-text">{{ $label }}</span>
        @if($isActive)<span class="active-indicator"></span>@endif
    </a>
</li>

<style>
.sidebar-item { margin-bottom: 4px; }
.sidebar-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: #64748b; transition: all 0.2s ease; position: relative; overflow: hidden; }
.sidebar-link:hover { background: rgba(59,130,246,0.08); color: #1e293b; }
.sidebar-item.active .sidebar-link { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; box-shadow: 0 4px 12px rgba(59,130,246,0.3); }
.link-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(100,116,139,0.1); transition: all 0.2s; flex-shrink: 0; }
.link-icon i { font-size: 20px; }
.sidebar-item.active .link-icon { background: rgba(255,255,255,0.2); }
.sidebar-link:hover .link-icon { background: rgba(59,130,246,0.15); }
.link-text { font-size: 0.875rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.active-indicator { position: absolute; right: 12px; width: 6px; height: 6px; background: white; border-radius: 50%; animation: pulse 2s ease-in-out infinite; }
@keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
</style>
