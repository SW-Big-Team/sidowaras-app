@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
    $isAdmin = $role === 'Admin';
@endphp

@extends($layoutPath)
@section('title','Riwayat Stock Opname')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Stock Opname</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Riwayat</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">inventory</i> Stock Opname</span>
                    <h2 class="welcome-title">Riwayat Stock Opname</h2>
                    <p class="welcome-subtitle">Daftar semua stock opname yang telah dilakukan</p>
                </div>
                <div class="welcome-stats">
                    @if($isAdmin)<a href="{{ route('admin.stokopname.pending') }}" class="stat-pill warning"><i class="material-symbols-rounded">pending_actions</i><span>Pending</span></a>@endif
                    @if(in_array($role, ['Admin', 'Karyawan']))<a href="{{ route('stokopname.create') }}" class="stat-pill primary"><i class="material-symbols-rounded">add_circle</i><span>Input Stock Opname</span></a>@endif
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">fact_check</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">inventory_2</i></div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
        <span class="alert-text"><strong>Sukses!</strong> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon"><i class="material-symbols-rounded">fact_check</i></div>
            <div class="metric-content"><span class="metric-label">Total Stock Opname</span><h3 class="metric-value">{{ $opnames->total() }}</h3><span class="metric-subtext">Semua record</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon"><i class="material-symbols-rounded">check_circle</i></div>
            <div class="metric-content"><span class="metric-label">Approved</span><h3 class="metric-value">{{ $opnames->where('status', 'approved')->count() }}</h3><span class="metric-subtext">Disetujui</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card warning">
            <div class="metric-icon"><i class="material-symbols-rounded">schedule</i></div>
            <div class="metric-content"><span class="metric-label">Pending</span><h3 class="metric-value">{{ $opnames->where('status', 'pending')->count() }}</h3><span class="metric-subtext">Menunggu approval</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card danger">
            <div class="metric-icon"><i class="material-symbols-rounded">cancel</i></div>
            <div class="metric-content"><span class="metric-label">Rejected</span><h3 class="metric-value">{{ $opnames->where('status', 'rejected')->count() }}</h3><span class="metric-subtext">Ditolak</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

{{-- Data Table --}}
<div class="card pro-card">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon primary"><i class="material-symbols-rounded">list_alt</i></div>
            <div><h6 class="header-title">Daftar Stock Opname</h6><p class="header-subtitle">{{ $opnames->total() }} record</p></div>
        </div>
        <form method="GET" action="{{ route('stokopname.index') }}" class="search-form">
            <div class="search-group">
                <i class="material-symbols-rounded input-icon">search</i>
                <input type="text" name="search" value="{{ $search ?? '' }}" class="search-input" placeholder="Cari nama, status...">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            </div>
            <button type="submit" class="btn-pro"><i class="material-symbols-rounded">search</i></button>
            @if($search ?? false)<a href="{{ route('stokopname.index') }}" class="btn-outline-pro btn-sm"><i class="material-symbols-rounded">close</i></a>@endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead><tr><th>Tanggal</th><th>Dibuat Oleh</th><th class="text-center">Jumlah Item</th><th class="text-center">Status</th><th>Disetujui</th><th class="text-center">Aksi</th></tr></thead>
                <tbody>
                    @forelse($opnames as $opname)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="item-icon"><i class="material-symbols-rounded">calendar_today</i></div>
                                <div><span class="fw-bold d-block">{{ $opname->tanggal->format('d M Y') }}</span><span class="text-xs text-secondary">{{ $opname->created_at->diffForHumans() }}</span></div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm"><span>{{ substr($opname->creator->name, 0, 1) }}</span></div>
                                <div><span class="fw-bold d-block">{{ $opname->creator->name }}</span><span class="text-xs text-secondary">{{ $opname->creator->role->nama_role }}</span></div>
                            </div>
                        </td>
                        <td class="text-center"><span class="qty-badge">{{ $opname->total_items }}</span></td>
                        <td class="text-center">
                            @if($opname->status === 'approved')<span class="status-badge success"><i class="material-symbols-rounded">check_circle</i> APPROVED</span>
                            @elseif($opname->status === 'rejected')<span class="status-badge danger"><i class="material-symbols-rounded">cancel</i> REJECTED</span>
                            @else<span class="status-badge warning"><i class="material-symbols-rounded">schedule</i> PENDING</span>@endif
                        </td>
                        <td>
                            @if($opname->approver)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-xs {{ $opname->status === 'approved' ? 'success' : 'danger' }}"><span>{{ substr($opname->approver->name, 0, 1) }}</span></div>
                                    <div><span class="fw-bold d-block text-sm">{{ $opname->approver->name }}</span><span class="text-xs text-secondary">{{ $opname->approved_at?->format('d/m/Y H:i') }}</span></div>
                                </div>
                            @else<span class="text-secondary">-</span>@endif
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('stokopname.show', $opname->id) }}" class="action-btn info" title="Detail"><i class="material-symbols-rounded">visibility</i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5"><div class="empty-state"><i class="material-symbols-rounded">inventory</i><p>Belum ada data stock opname</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer pro-card-footer">
        <div class="footer-left">
            <span class="text-secondary text-sm">Tampilkan</span>
            <select class="per-page-select" onchange="window.location.href='{{ route('stokopname.index') }}?per_page='+this.value+'&search={{ $search ?? '' }}'">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-secondary text-sm">data</span>
        </div>
        <div class="footer-center"><span class="text-secondary text-sm"><strong>{{ $opnames->firstItem() ?? 0 }}</strong> - <strong>{{ $opnames->lastItem() ?? 0 }}</strong> dari <strong>{{ $opnames->total() }}</strong></span></div>
        <div class="footer-right">{{ $opnames->links('pagination::bootstrap-5') }}</div>
    </div>
</div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; }
.welcome-stats { display: flex; gap: 10px; flex-wrap: wrap; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.stat-pill.primary { background: rgba(255,255,255,0.3); }
.stat-pill.warning { background: rgba(245,158,11,0.7); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; color: white; }
.metric-card.primary .metric-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.metric-card.success .metric-icon { background: linear-gradient(135deg, #10b981, #059669); }
.metric-card.warning .metric-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
.metric-card.danger .metric-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-subtext { font-size: 0.75rem; color: var(--secondary); }
.metric-glow { position: absolute; top: -50%; right: -50%; width: 100%; height: 200%; border-radius: 50%; opacity: 0.08; }
.metric-card.primary .metric-glow { background: var(--primary); }
.metric-card.success .metric-glow { background: var(--success); }
.metric-card.warning .metric-glow { background: var(--warning); }
.metric-card.danger .metric-glow { background: var(--danger); }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 20px; }
.header-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.search-form { display: flex; gap: 8px; align-items: center; }
.search-group { position: relative; }
.search-group .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 18px; }
.search-input { padding-left: 40px; height: 40px; width: 220px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.875rem; }
.search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.15); outline: none; }
.btn-pro { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: linear-gradient(135deg, #1e293b, #334155); color: white; font-size: 0.8rem; font-weight: 500; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: white; color: var(--secondary); font-size: 0.8rem; font-weight: 500; border-radius: 8px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro.btn-sm { padding: 6px 12px; }
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #f8fafc; }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.item-icon i { color: white; font-size: 18px; }
.avatar-sm { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #1e293b, #334155); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.avatar-sm span { color: white; font-size: 0.8rem; font-weight: 600; }
.avatar-xs { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.avatar-xs.success { background: linear-gradient(135deg, #10b981, #059669); }
.avatar-xs.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
.avatar-xs span { color: white; font-size: 0.65rem; font-weight: 600; }
.qty-badge { font-size: 0.85rem; font-weight: 700; padding: 4px 12px; border-radius: 6px; background: #f1f5f9; color: #1e293b; }
.status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; padding: 4px 10px; border-radius: 6px; font-weight: 500; }
.status-badge i { font-size: 14px; }
.status-badge.success { background: rgba(16,185,129,0.1); color: var(--success); }
.status-badge.warning { background: rgba(245,158,11,0.1); color: var(--warning); }
.status-badge.danger { background: rgba(239,68,68,0.1); color: var(--danger); }
.action-buttons { display: flex; gap: 4px; justify-content: center; }
.action-btn { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; background: #f1f5f9; color: var(--secondary); cursor: pointer; transition: all 0.2s; text-decoration: none; }
.action-btn i { font-size: 16px; }
.action-btn.info:hover { background: rgba(59,130,246,0.1); color: var(--info); }
.empty-state { display: flex; flex-direction: column; align-items: center; color: var(--secondary); }
.empty-state i { font-size: 48px; margin-bottom: 8px; }
.pro-card-footer { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; background: #fafbfc; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px; }
.footer-left, .footer-center { display: flex; align-items: center; gap: 8px; }
.per-page-select { padding: 4px 8px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.8rem; }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } .welcome-stats { justify-content: center; } .pro-card-header { flex-direction: column; align-items: stretch; } .search-form { width: 100%; } .search-input { width: 100%; } }
</style>
@endpush
@endsection