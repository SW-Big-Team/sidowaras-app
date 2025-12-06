@php
    use Illuminate\Support\Facades\Route;
    $notifications = $notifications ?? collect();
    $unreadNotificationCount = $unreadNotificationCount ?? $notifications->whereNull('read_at')->count();
    $rawSectionTitle = trim($__env->yieldContent('page_title'));
    $routeName = Route::currentRouteName();
    $routeTitleMap = [
        'admin.dashboard' => 'Dashboard',
        'admin.obat.index' => 'Master Obat',
        'admin.transaksi.riwayat' => 'Riwayat Transaksi',
        'admin.users.index' => 'Manajemen User',
        'admin.laporan.index' => 'Laporan',
    ];
    $pageTitle = $rawSectionTitle ?: ($title ?? ($routeTitleMap[$routeName] ?? 'Dashboard'));
@endphp

<!-- Modern Navbar -->
<nav class="navbar-modern" id="navbarBlur">
    <div class="navbar-inner">
        <!-- Left: Breadcrumb & Title -->
        <div class="navbar-left">
            <div class="page-info">
                <div class="breadcrumb-modern">
                    <span class="breadcrumb-item"><i class="material-symbols-rounded">home</i> Pages</span>
                    <span class="breadcrumb-sep"><i class="material-symbols-rounded">chevron_right</i></span>
                    <span class="breadcrumb-current">{{ $pageTitle }}</span>
                </div>
                <h4 class="page-title">{{ $pageTitle }}</h4>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="navbar-right">
            <!-- Mobile Toggle -->
            <button class="nav-btn mobile-toggle d-xl-none" onclick="toggleSidebar()">
                <i class="material-symbols-rounded">menu</i>
            </button>

            <!-- Notifications -->
            <button class="nav-btn notification-btn" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                <i class="material-symbols-rounded">notifications</i>
                @if($unreadNotificationCount > 0)
                    <span class="notification-badge">{{ $unreadNotificationCount > 9 ? '9+' : $unreadNotificationCount }}</span>
                @endif
            </button>

            <!-- Profile Dropdown -->
            <div class="profile-dropdown">
                <button class="profile-btn" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-avatar">
                        <span>{{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="profile-info d-none d-md-block">
                        <span class="profile-name">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>
                        <span class="profile-role">{{ Auth::user()->role->nama_role ?? 'Admin' }}</span>
                    </div>
                    <i class="material-symbols-rounded dropdown-arrow d-none d-md-block">expand_more</i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileDropdown">
                    <li class="menu-header">
                        <div class="header-avatar">
                            <span>{{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="header-info">
                            <span class="header-name">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>
                            <span class="header-email">{{ Auth::user()->email ?? 'admin@sidowaras.com' }}</span>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="menu-item" href="#"><i class="material-symbols-rounded">person</i> Profil Saya</a></li>
                    <li><a class="menu-item" href="#"><i class="material-symbols-rounded">settings</i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="menu-item logout" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                            <i class="material-symbols-rounded">logout</i> Logout
                        </a>
                        <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
.navbar-modern { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid #e2e8f0; padding: 0.75rem 1.5rem; position: sticky; top: 0; z-index: 100; }
.navbar-inner { display: flex; align-items: center; justify-content: space-between; }
.navbar-left { display: flex; align-items: center; gap: 1rem; }
.breadcrumb-modern { display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #64748b; margin-bottom: 2px; }
.breadcrumb-modern i { font-size: 14px; }
.breadcrumb-current { color: #1e293b; font-weight: 500; }
.page-title { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0; }
.navbar-right { display: flex; align-items: center; gap: 12px; }
.nav-btn { width: 40px; height: 40px; border-radius: 10px; border: none; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; position: relative; }
.nav-btn:hover { background: #e2e8f0; color: #1e293b; }
.nav-btn i { font-size: 22px; }
.notification-badge { position: absolute; top: -4px; right: -4px; min-width: 18px; height: 18px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; font-size: 0.65rem; font-weight: 700; border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 0 4px; border: 2px solid white; box-shadow: 0 2px 4px rgba(239,68,68,0.4); }
.profile-dropdown { position: relative; }
.profile-btn { display: flex; align-items: center; gap: 10px; padding: 6px 12px 6px 6px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s; }
.profile-btn:hover { background: #f1f5f9; border-color: #cbd5e1; }
.profile-avatar { width: 34px; height: 34px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem; }
.profile-info { display: flex; flex-direction: column; text-align: left; }
.profile-name { font-size: 0.8rem; font-weight: 600; color: #1e293b; line-height: 1.2; }
.profile-role { font-size: 0.7rem; color: #64748b; }
.dropdown-arrow { font-size: 18px; color: #64748b; transition: transform 0.2s; }
.profile-btn[aria-expanded="true"] .dropdown-arrow { transform: rotate(180deg); }
.profile-menu { min-width: 240px; padding: 0.75rem; border: none; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.12); margin-top: 8px; }
.menu-header { display: flex; align-items: center; gap: 12px; padding: 0.75rem; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 12px; margin-bottom: 8px; }
.header-avatar { width: 44px; height: 44px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; flex-shrink: 0; }
.header-info { display: flex; flex-direction: column; }
.header-name { font-size: 0.85rem; font-weight: 600; color: #1e293b; }
.header-email { font-size: 0.75rem; color: #64748b; }
.menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; font-size: 0.85rem; color: #475569; text-decoration: none; transition: all 0.2s; }
.menu-item i { font-size: 20px; color: #64748b; }
.menu-item:hover { background: #f1f5f9; color: #1e293b; }
.menu-item.logout { color: #ef4444; }
.menu-item.logout:hover { background: rgba(239,68,68,0.1); }
.menu-item.logout i { color: #ef4444; }
@media (max-width: 768px) { .navbar-modern { padding: 0.5rem 1rem; } .page-title { font-size: 1rem; } .breadcrumb-modern { display: none; } }
</style>
