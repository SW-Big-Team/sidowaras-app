@php
    $role = auth()->user()->role->nama_role;
    $layout = match($role) {
        'Admin' => 'layouts.admin.app',
        'Kasir' => 'layouts.kasir.app',
        'Karyawan' => 'layouts.karyawan.app',
        default => 'layouts.app',
    };
@endphp

@extends($layout)
@section('title', 'Daftar Stok')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Stok</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Stok</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">inventory_2</i> Stok Obat</span>
                    <h2 class="welcome-title">Daftar Stok Obat</h2>
                    <p class="welcome-subtitle">Monitoring persediaan, stok minimum, dan status kadaluarsa obat.</p>
                </div>
                <a href="{{ route('pembelian.index') }}" class="stat-pill"><i class="material-symbols-rounded">shopping_cart</i><span>Pembelian</span></a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">medication</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">local_pharmacy</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon"><i class="material-symbols-rounded">inventory_2</i></div>
            <div class="metric-content"><span class="metric-label">Total Item</span><h3 class="metric-value">{{ $obats->total() }}</h3><span class="metric-subtext">Seluruh item obat</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon"><i class="material-symbols-rounded">check_circle</i></div>
            <div class="metric-content"><span class="metric-label">Stok Aman</span><h3 class="metric-value">{{ $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') > $o->stok_minimum)->count() }}</h3><span class="metric-subtext">Kondisi stabil</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card warning">
            <div class="metric-icon"><i class="material-symbols-rounded">warning</i></div>
            <div class="metric-content"><span class="metric-label">Stok Rendah</span><h3 class="metric-value">{{ $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') <= $o->stok_minimum)->count() }}</h3><span class="metric-subtext">Perlu restock</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card danger">
            <div class="metric-icon"><i class="material-symbols-rounded">event_busy</i></div>
            <div class="metric-content"><span class="metric-label">Exp < 30 Hari</span><h3 class="metric-value">{{ $obats->filter(fn($o) => $o->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty())->count() }}</h3><span class="metric-subtext">Pengecekan segera</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

{{-- Data Table --}}
<div class="card pro-card">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon primary"><i class="material-symbols-rounded">list_alt</i></div>
            <div><h6 class="header-title">Data Stok Obat</h6><p class="header-subtitle">{{ $obats->total() }} record</p></div>
        </div>
        <form action="{{ route('stok.index') }}" method="GET" class="search-form">
            <div class="filter-group">
                <i class="material-symbols-rounded input-icon">filter_list</i>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Stok Aman</option>
                    <option value="rendah" {{ request('status') == 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Exp < 30 Hari</option>
                </select>
            </div>
            <div class="search-group">
                <i class="material-symbols-rounded input-icon">search</i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari nama / kode...">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            </div>
            <button type="submit" class="btn-pro"><i class="material-symbols-rounded">search</i></button>
            @if(request('search') || request('status'))<a href="{{ route('stok.index') }}" class="btn-outline-pro btn-sm"><i class="material-symbols-rounded">close</i></a>@endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead><tr><th>#</th><th>Obat</th><th class="text-center">Stok Sistem</th><th class="text-center">Stok Min</th><th class="text-center">Status</th><th class="text-center">Kadaluarsa Terdekat</th></tr></thead>
                <tbody>
                    @forelse($obats as $obat)
                    @php
                        $sisaStok = $obat->stokBatches->sum('sisa_stok');
                        $nearestExp = $obat->stokBatches->where('sisa_stok', '>', 0)->min('tgl_kadaluarsa');
                        $isLow = $sisaStok <= $obat->stok_minimum;
                        $isExp = $nearestExp && \Carbon\Carbon::parse($nearestExp)->lte(now()->addDays(30));
                    @endphp
                    <tr class="{{ $isLow ? 'row-warning' : '' }} {{ $isExp ? 'row-danger' : '' }}">
                        <td><span class="text-secondary text-sm">{{ $loop->iteration + ($obats->firstItem() - 1) }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="item-icon"><i class="material-symbols-rounded">medication</i></div>
                                <div><span class="fw-bold d-block">{{ $obat->nama_obat }}</span><span class="code-badge">{{ $obat->kode_obat }}</span></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="status-dot {{ $isLow ? 'warning' : 'success' }}"></span>
                                <span class="fw-bold text-lg">{{ $sisaStok }}</span>
                            </div>
                        </td>
                        <td class="text-center"><span class="min-badge">{{ $obat->stok_minimum }}</span></td>
                        <td class="text-center">
                            @if($isExp)<span class="status-badge danger"><i class="material-symbols-rounded">event_busy</i> Exp < 30 Hari</span>
                            @elseif($isLow)<span class="status-badge warning"><i class="material-symbols-rounded">warning</i> Rendah</span>
                            @else<span class="status-badge success"><i class="material-symbols-rounded">check_circle</i> Aman</span>@endif
                        </td>
                        <td class="text-center">
                            @if($nearestExp)
                                <span class="date-badge {{ $isExp ? 'danger' : '' }}">{{ \Carbon\Carbon::parse($nearestExp)->format('d M Y') }}</span>
                            @else<span class="date-badge">-</span>@endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5"><div class="empty-state"><i class="material-symbols-rounded">inventory_2</i><p>Tidak ada data stok</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer pro-card-footer">
        <div class="footer-left">
            <span class="text-secondary text-sm">Tampilkan</span>
            <select class="per-page-select" onchange="window.location.href='{{ route('stok.index') }}?per_page='+this.value+'&search={{ request('search') }}&status={{ request('status') }}'">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-secondary text-sm">data</span>
        </div>
        <div class="footer-center"><span class="text-secondary text-sm"><strong>{{ $obats->firstItem() ?? 0 }}</strong> - <strong>{{ $obats->lastItem() ?? 0 }}</strong> dari <strong>{{ $obats->total() }}</strong></span></div>
        <div class="footer-right">{{ $obats->links('pagination::bootstrap-5') }}</div>
    </div>
</div>

{{-- Legend --}}
<div class="legend-bar mt-3">
    <span class="legend-item"><span class="status-dot success"></span> Stok Aman</span>
    <span class="legend-item"><span class="status-dot warning"></span> Stok Rendah</span>
    <span class="legend-item"><span class="status-dot danger"></span> Exp < 30 Hari</span>
</div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #10b981; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; color: white; }
.metric-card.primary .metric-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.metric-card.success .metric-icon { background: linear-gradient(135deg, #10b981, #059669); }
.metric-card.warning .metric-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
.metric-card.danger .metric-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-subtext { font-size: 0.75rem; color: var(--secondary); }
.metric-glow { position: absolute; top: -50%; right: -50%; width: 100%; height: 200%; border-radius: 50%; opacity: 0.08; }
.metric-card.primary .metric-glow { background: var(--info); }
.metric-card.success .metric-glow { background: var(--success); }
.metric-card.warning .metric-glow { background: var(--warning); }
.metric-card.danger .metric-glow { background: var(--danger); }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 20px; }
.header-icon.primary { background: linear-gradient(135deg, #10b981, #059669); }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.search-form { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.filter-group, .search-group { position: relative; }
.filter-group .input-icon, .search-group .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 18px; z-index: 2; }
.filter-select { padding-left: 40px; height: 40px; min-width: 140px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.875rem; appearance: none; }
.search-input { padding-left: 40px; height: 40px; width: 180px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.875rem; }
.filter-select:focus, .search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(16,185,129,0.15); outline: none; }
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
.pro-table tbody tr.row-warning { background: rgba(245,158,11,0.04); }
.pro-table tbody tr.row-danger { background: rgba(239,68,68,0.04); }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.item-icon i { color: white; font-size: 18px; }
.code-badge { font-size: 0.7rem; font-weight: 500; padding: 2px 8px; border-radius: 4px; background: #f1f5f9; color: var(--secondary); font-family: monospace; }
.status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
.status-dot.success { background: var(--success); }
.status-dot.warning { background: var(--warning); }
.status-dot.danger { background: var(--danger); }
.min-badge { font-size: 0.8rem; font-weight: 600; padding: 4px 10px; border-radius: 6px; background: #fef3c7; color: #d97706; }
.status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; padding: 4px 10px; border-radius: 6px; font-weight: 500; }
.status-badge i { font-size: 14px; }
.status-badge.success { background: rgba(16,185,129,0.1); color: var(--success); }
.status-badge.warning { background: rgba(245,158,11,0.1); color: var(--warning); }
.status-badge.danger { background: rgba(239,68,68,0.1); color: var(--danger); }
.date-badge { font-size: 0.75rem; color: var(--secondary); }
.date-badge.danger { color: var(--danger); font-weight: 600; }
.empty-state { display: flex; flex-direction: column; align-items: center; color: var(--secondary); }
.empty-state i { font-size: 48px; margin-bottom: 8px; }
.pro-card-footer { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; background: #fafbfc; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px; }
.footer-left, .footer-center { display: flex; align-items: center; gap: 8px; }
.per-page-select { padding: 4px 8px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.8rem; }
.legend-bar { display: flex; gap: 20px; justify-content: center; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.legend-item { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: var(--secondary); }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } .pro-card-header { flex-direction: column; align-items: stretch; } .search-form { width: 100%; flex-direction: column; } .filter-select, .search-input { width: 100%; } }
</style>
@endpush
@endsection