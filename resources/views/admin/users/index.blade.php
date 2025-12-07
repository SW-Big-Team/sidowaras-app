@extends('layouts.admin.app')

@section('title', 'Daftar User')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen User</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar User</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge">
                        <i class="material-symbols-rounded">group</i>
                        Manajemen Pengguna
                    </span>
                    <h2 class="welcome-title">Kelola Pengguna Sistem</h2>
                    <p class="welcome-subtitle">Atur akses, role, dan status pengguna untuk sistem apotek Anda.</p>
                </div>
                <div class="welcome-stats">
                    <a href="{{ route('admin.shift.index') }}" class="stat-pill">
                        <i class="material-symbols-rounded">schedule</i>
                        <span>Kelola Shift</span>
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="stat-pill success">
                        <i class="material-symbols-rounded">person_add</i>
                        <span>Tambah User</span>
                    </a>
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">person</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">shield</i></div>
                <div class="floating-icon icon-3"><i class="material-symbols-rounded">admin_panel_settings</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon">
                <i class="material-symbols-rounded">group</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Total User</span>
                <h3 class="metric-value">{{ $users->count() }}</h3>
                <div class="metric-change neutral">
                    <i class="material-symbols-rounded">people</i>
                    <span>Pengguna terdaftar</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon">
                <i class="material-symbols-rounded">person_add</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">User Baru</span>
                <h3 class="metric-value">{{ $users->where('created_at', '>=', now()->subDays(7))->count() }}</h3>
                <div class="metric-change neutral">
                    <i class="material-symbols-rounded">calendar_today</i>
                    <span>7 hari terakhir</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="metric-card info">
            <div class="metric-icon">
                <i class="material-symbols-rounded">verified_user</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">User Aktif</span>
                <h3 class="metric-value">{{ $users->where('is_active', true)->count() }}</h3>
                <div class="metric-change neutral">
                    <i class="material-symbols-rounded">check_circle</i>
                    <span>Status akun aktif</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
        <span class="alert-text fw-bold">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
        <span class="alert-text fw-bold">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- Users Table --}}
<div class="card pro-card">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="material-symbols-rounded">people</i>
            </div>
            <div>
                <h6 class="header-title">Data Pengguna</h6>
                <p class="header-subtitle">{{ $users->count() }} user terdaftar</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 220px;">
                <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                    <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                </span>
                <input type="text" class="form-control ps-0" id="searchInput" 
                       style="border-radius: 0 8px 8px 0; border-left: 0;"
                       placeholder="Cari user...">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="user-row" data-name="{{ strtolower($user->nama_lengkap) }}" data-email="{{ strtolower($user->email) }}">
                            <td>
                                <span class="id-badge">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}</div>
                                    <span class="fw-bold">{{ $user->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="email-text">{{ $user->email }}</span>
                            </td>
                            <td>
                                @php
                                    $roleClass = match($user->role->nama_role ?? '') {
                                        'Admin' => 'primary',
                                        'Kasir' => 'warning',
                                        'Karyawan' => 'info',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="role-badge {{ $roleClass }}">
                                    {{ $user->role->nama_role ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input 
                                        class="form-check-input status-switch" 
                                        type="checkbox" 
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->nama_lengkap }}"
                                        {{ $user->is_active ? 'checked' : '' }}
                                        {{ $user->id === Auth::id() ? 'disabled' : '' }}
                                        id="status-switch-{{ $user->id }}"
                                    >
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn edit" title="Edit">
                                        <i class="material-symbols-rounded">edit</i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus user {{ $user->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus">
                                            <i class="material-symbols-rounded">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="material-symbols-rounded">person_off</i></div>
                                    <h6>Belum ada data user</h6>
                                    <p>Tambahkan user baru untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ===== Variables ===== */
:root {
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --primary: #8b5cf6;
    --secondary: #64748b;
}

/* ===== Welcome Banner ===== */
.welcome-banner {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.welcome-content { position: relative; z-index: 2; }

.greeting-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    color: white;
    font-weight: 500;
    margin-bottom: 12px;
}

.welcome-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: white;
    margin: 0 0 8px;
}

.welcome-subtitle {
    color: rgba(255,255,255,0.85);
    font-size: 0.9rem;
    margin: 0 0 16px;
    max-width: 500px;
}

.welcome-stats { display: flex; gap: 10px; flex-wrap: wrap; }

.stat-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.2);
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 0.8rem;
    color: white;
    font-weight: 500;
    backdrop-filter: blur(10px);
    text-decoration: none;
    transition: all 0.2s;
}

.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; transform: translateY(-2px); }
.stat-pill.success { background: rgba(16, 185, 129, 0.5); }

.welcome-illustration {
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    gap: 1rem;
}

.floating-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: float 3s ease-in-out infinite;
    backdrop-filter: blur(10px);
}

.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
.floating-icon.icon-3 { animation-delay: 1s; }

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* ===== Metric Cards ===== */
.metric-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    display: flex;
    gap: 1rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.metric-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.metric-icon i { font-size: 26px; }

.metric-card.success .metric-icon { background: rgba(16,185,129,0.12); }
.metric-card.success .metric-icon i { color: var(--success); }
.metric-card.info .metric-icon { background: rgba(59,130,246,0.12); }
.metric-card.info .metric-icon i { color: var(--info); }
.metric-card.primary .metric-icon { background: rgba(139,92,246,0.12); }
.metric-card.primary .metric-icon i { color: var(--primary); }

.metric-content { flex: 1; min-width: 0; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }

.metric-change {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}
.metric-change i { font-size: 16px; }
.metric-change.neutral { color: var(--secondary); }

.metric-glow {
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    right: -30px;
    bottom: -30px;
    opacity: 0.1;
}

.metric-card.success .metric-glow { background: var(--success); }
.metric-card.info .metric-glow { background: var(--info); }
.metric-card.primary .metric-glow { background: var(--primary); }

/* ===== Pro Cards ===== */
.pro-card {
    background: white;
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}

.pro-card-header {
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #f1f5f9;
    background: white;
}

.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    display: flex;
    align-items: center;
    justify-content: center;
}
.header-icon i { color: #000000 !important; font-size: 20px; }

.header-title { font-size: 1rem; font-weight: 600; color: #000000 !important; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: #000000 !important; margin: 2px 0 0; }

/* ===== Pro Table ===== */
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th {
    font-size: 0.7rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border: none;
}
.pro-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.pro-table tbody tr:hover { background: #f8fafc; }

.id-badge {
    font-family: monospace;
    font-weight: 600;
    color: var(--secondary);
    font-size: 0.8rem;
}

.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
}

.email-text { font-size: 0.85rem; color: var(--secondary); }

.role-badge {
    font-size: 0.7rem;
    padding: 5px 10px;
    border-radius: 6px;
    font-weight: 600;
}
.role-badge.primary { background: rgba(139,92,246,0.12); color: var(--primary); }
.role-badge.warning { background: rgba(245,158,11,0.12); color: var(--warning); }
.role-badge.info { background: rgba(59,130,246,0.12); color: var(--info); }
.role-badge.secondary { background: #f1f5f9; color: var(--secondary); }

.action-buttons { display: flex; gap: 6px; justify-content: center; }
.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.action-btn i { font-size: 18px; }
.action-btn.edit { background: rgba(245,158,11,0.12); color: var(--warning); }
.action-btn.edit:hover { background: var(--warning); color: white; }
.action-btn.delete { background: rgba(239,68,68,0.12); color: var(--danger); }
.action-btn.delete:hover { background: var(--danger); color: white; }

.empty-state { text-align: center; padding: 2rem; }
.empty-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}
.empty-icon i { font-size: 28px; color: var(--secondary); }
.empty-state h6 { color: #475569; margin-bottom: 4px; }
.empty-state p { font-size: 0.8rem; color: var(--secondary); margin: 0; }

/* ===== Responsive ===== */
@media (max-width: 768px) {
    .welcome-banner { flex-direction: column; text-align: center; }
    .welcome-stats { justify-content: center; }
    .welcome-illustration { display: none; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.user-row').forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                row.style.display = (name.includes(searchTerm) || email.includes(searchTerm)) ? '' : 'none';
            });
        });
    }

    // Status toggle
    const statusSwitches = document.querySelectorAll('.status-switch');
    statusSwitches.forEach(function(switchElement) {
        switchElement.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const isChecked = this.checked;
            const switchEl = this;
            
            switchEl.disabled = true;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/adminx/users/${userId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    switchEl.checked = !isChecked;
                    alert(data.message || 'Gagal mengubah status user');
                }
            })
            .catch(error => {
                switchEl.checked = !isChecked;
                alert('Terjadi kesalahan saat mengubah status user');
            })
            .finally(() => {
                switchEl.disabled = false;
            });
        });
    });
});
</script>
@endpush
