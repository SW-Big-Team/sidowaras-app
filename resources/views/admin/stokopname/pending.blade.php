@extends('layouts.admin.app')
@section('title', 'Stock Opname Pending')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Stock Opname</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pending Approval</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner warning">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge">
                        <i class="material-symbols-rounded">fact_check</i>
                        Approval Center
                    </span>
                    <h2 class="welcome-title">Stock Opname Pending</h2>
                    <p class="welcome-subtitle">Daftar stock opname yang memerlukan persetujuan Admin. Stok akan disesuaikan otomatis setelah disetujui.</p>
                </div>
                <div class="welcome-stats">
                    <a href="{{ route('admin.dashboard') }}" class="stat-pill">
                        <i class="material-symbols-rounded">arrow_back</i>
                        <span>Dashboard</span>
                    </a>
                    @if(!$pendingOpnames->isEmpty())
                        <div class="stat-pill highlight">
                            <i class="material-symbols-rounded">pending_actions</i>
                            <span>{{ $pendingOpnames->total() }} menunggu</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">inventory</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">check_circle</i></div>
                <div class="floating-icon icon-3"><i class="material-symbols-rounded">pending</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-white shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="material-symbols-rounded me-2">check_circle</i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="material-symbols-rounded me-2">error</i>
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($pendingOpnames->isEmpty())
    {{-- Empty State --}}
    <div class="card pro-card">
        <div class="card-body text-center py-5">
            <div class="empty-state-large">
                <div class="empty-icon-large success">
                    <i class="material-symbols-rounded">task_alt</i>
                </div>
                <h4>Tidak Ada Stock Opname Pending</h4>
                <p class="text-secondary">Semua stock opname sudah diproses. Kerja bagus!</p>
                <a href="{{ route('admin.dashboard') }}" class="btn-pro mt-3">
                    <i class="material-symbols-rounded">home</i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@else
    {{-- Summary Card --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="metric-card warning">
                <div class="metric-icon">
                    <i class="material-symbols-rounded">pending_actions</i>
                </div>
                <div class="metric-content">
                    <span class="metric-label">Total Pending</span>
                    <h3 class="metric-value">{{ $pendingOpnames->total() }}</h3>
                    <div class="metric-change neutral">
                        <i class="material-symbols-rounded">schedule</i>
                        <span>Menunggu approval</span>
                    </div>
                </div>
                <div class="metric-glow"></div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card pro-card">
        <div class="card-header pro-card-header">
            <div class="header-left">
                <div class="header-icon warning">
                    <i class="material-symbols-rounded">list_alt</i>
                </div>
                <div>
                    <h6 class="header-title">Daftar Stock Opname</h6>
                    <p class="header-subtitle">{{ $pendingOpnames->total() }} menunggu persetujuan</p>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table pro-table mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Dibuat Oleh</th>
                            <th class="text-center">Jumlah Item</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingOpnames as $opname)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="date-icon">
                                        <i class="material-symbols-rounded">calendar_today</i>
                                    </div>
                                    <div>
                                        <span class="fw-bold">{{ $opname->tanggal->format('d M Y') }}</span>
                                        <span class="d-block text-xs text-secondary">{{ $opname->tanggal->isoFormat('dddd') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($opname->creator->name ?? 'U', 0, 1)) }}</div>
                                    <div>
                                        <span class="fw-bold">{{ $opname->creator->name ?? 'Unknown' }}</span>
                                        <span class="time-ago">{{ $opname->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="item-badge">
                                    <i class="material-symbols-rounded">inventory_2</i>
                                    {{ $opname->details->count() }} item
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="status-badge warning">
                                    <i class="material-symbols-rounded">schedule</i>
                                    PENDING
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-group">
                                    <a href="{{ route('stokopname.show', $opname->id) }}" 
                                       class="action-btn view" title="Lihat Detail">
                                        <i class="material-symbols-rounded">visibility</i>
                                    </a>
                                    <form action="{{ route('admin.stokopname.approve', $opname->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Setujui stock opname ini? Stok akan disesuaikan otomatis.')">
                                        @csrf
                                        <button type="submit" class="action-btn approve" title="Setujui">
                                            <i class="material-symbols-rounded">check_circle</i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.stokopname.reject', $opname->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Tolak stock opname ini?')">
                                        @csrf
                                        <button type="submit" class="action-btn reject" title="Tolak">
                                            <i class="material-symbols-rounded">cancel</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($pendingOpnames->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-end">
                    {{ $pendingOpnames->links() }}
                </div>
            </div>
        @endif
    </div>
@endif
@endsection

@push('styles')
<style>
:root {
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --primary: #8b5cf6;
    --secondary: #64748b;
}

.welcome-banner.warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.25); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.9); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.welcome-stats { display: flex; gap: 10px; flex-wrap: wrap; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.stat-pill.highlight { background: rgba(255,255,255,0.35); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
.floating-icon.icon-3 { animation-delay: 1s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; }
.metric-card.warning .metric-icon { background: rgba(245,158,11,0.12); }
.metric-card.warning .metric-icon i { color: var(--warning); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-change { display: flex; align-items: center; gap: 4px; font-size: 0.75rem; font-weight: 500; }
.metric-change i { font-size: 16px; }
.metric-change.neutral { color: var(--secondary); }
.metric-glow { position: absolute; width: 120px; height: 120px; border-radius: 50%; right: -30px; bottom: -30px; opacity: 0.1; background: var(--warning); }

.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; }
.header-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.header-icon i { color: white; font-size: 20px; }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }

.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #fef9f0; }

.date-icon { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #1e293b, #475569); display: flex; align-items: center; justify-content: center; }
.date-icon i { color: white; font-size: 18px; }

.user-cell { display: flex; align-items: center; gap: 10px; }
.user-cell > div { display: flex; flex-direction: column; }
.user-avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600; }
.time-ago { font-size: 0.7rem; color: var(--secondary); }

.item-badge { display: inline-flex; align-items: center; gap: 4px; background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; color: var(--secondary); font-weight: 500; }
.item-badge i { font-size: 16px; }

.status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; padding: 6px 12px; border-radius: 6px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
.status-badge i { font-size: 14px; }
.status-badge.warning { background: rgba(245,158,11,0.15); color: var(--warning); }

.action-group { display: flex; gap: 6px; justify-content: center; }
.action-btn { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.action-btn i { font-size: 18px; }
.action-btn.view { background: rgba(30,41,59,0.1); color: var(--secondary); }
.action-btn.view:hover { background: #1e293b; color: white; }
.action-btn.approve { background: rgba(16,185,129,0.12); color: var(--success); }
.action-btn.approve:hover { background: var(--success); color: white; }
.action-btn.reject { background: rgba(239,68,68,0.12); color: var(--danger); }
.action-btn.reject:hover { background: var(--danger); color: white; }

.empty-state-large { padding: 2rem; }
.empty-icon-large { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
.empty-icon-large.success { background: rgba(16,185,129,0.12); }
.empty-icon-large i { font-size: 40px; color: var(--success); }
.empty-state-large h4 { color: #1e293b; font-weight: 600; margin-bottom: 8px; }
.empty-state-large p { margin-bottom: 0; }

.btn-pro { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 20px; background: linear-gradient(135deg, #1e293b, #475569); color: white; font-size: 0.85rem; font-weight: 500; border-radius: 10px; border: none; text-decoration: none; cursor: pointer; transition: all 0.2s; }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,41,59,0.4); color: white; }
.btn-pro i { font-size: 18px; }

@media (max-width: 768px) {
    .welcome-banner.warning { flex-direction: column; text-align: center; }
    .welcome-stats { justify-content: center; }
    .welcome-illustration { display: none; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush