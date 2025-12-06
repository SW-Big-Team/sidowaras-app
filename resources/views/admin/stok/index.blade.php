@php
    $layoutPath = 'layouts.admin.app';
@endphp

@extends($layoutPath)
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
                    <span class="greeting-badge"><i class="material-symbols-rounded">inventory_2</i> Manajemen Stok</span>
                    <h2 class="welcome-title">Daftar Stok Obat</h2>
                    <p class="welcome-subtitle">Monitoring persediaan, batch, dan status stok obat di apotek.</p>
                </div>
                <div class="welcome-stats">
                    <a href="{{ route('pembelian.index') }}" class="stat-pill"><i class="material-symbols-rounded">shopping_cart</i><span>Pembelian</span></a>
                    <a href="{{ route('admin.obat.create') }}" class="stat-pill primary"><i class="material-symbols-rounded">add_circle</i><span>Tambah Obat</span></a>
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">medication</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">local_pharmacy</i></div>
                <div class="floating-icon icon-3"><i class="material-symbols-rounded">vaccines</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
@php
    $totalStokRendah = $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') <= $o->stok_minimum)->count();
    $totalExpSoon = $obats->filter(fn($o) => $o->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty())->count();
    $totalAman = $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') > $o->stok_minimum)->count();
@endphp
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon"><i class="material-symbols-rounded">inventory_2</i></div>
            <div class="metric-content"><span class="metric-label">Total Item</span><h3 class="metric-value">{{ $obats->total() }}</h3><span class="metric-subtext">Produk terdaftar</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon"><i class="material-symbols-rounded">check_circle</i></div>
            <div class="metric-content"><span class="metric-label">Stok Aman</span><h3 class="metric-value">{{ $totalAman }}</h3><span class="metric-subtext">Kondisi stabil</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card warning">
            <div class="metric-icon"><i class="material-symbols-rounded">warning</i></div>
            <div class="metric-content"><span class="metric-label">Stok Rendah</span><h3 class="metric-value">{{ $totalStokRendah }}</h3><span class="metric-subtext">Perlu restock</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card danger">
            <div class="metric-icon"><i class="material-symbols-rounded">event_busy</i></div>
            <div class="metric-content"><span class="metric-label">Exp < 30 Hari</span><h3 class="metric-value">{{ $totalExpSoon }}</h3><span class="metric-subtext">Cek segera</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

{{-- Data Table Card --}}
<div class="card pro-card">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon"><i class="material-symbols-rounded">list_alt</i></div>
            <div><h6 class="header-title">Data Stok Obat</h6><p class="header-subtitle">{{ $obats->total() }} record</p></div>
        </div>
        <form action="{{ route('stok.index') }}" method="GET" class="filter-form" id="filterForm">
            <div class="filter-group">
                <i class="material-symbols-rounded filter-icon">filter_list</i>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Stok Aman</option>
                    <option value="rendah" {{ request('status') == 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Exp < 30 Hari</option>
                </select>
            </div>
            <div class="search-group">
                <i class="material-symbols-rounded search-icon">search</i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari nama / kode...">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            </div>
            <button type="submit" class="btn-filter"><i class="material-symbols-rounded">search</i></button>
            @if(request('search') || request('status'))
                <a href="{{ route('stok.index') }}" class="btn-clear" title="Hapus Filter"><i class="material-symbols-rounded">close</i></a>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Min</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($obats as $index => $obat)
                        @php
                            $totalStok = $obat->stokBatches->sum('sisa_stok');
                            $isLow = $totalStok <= $obat->stok_minimum;
                            $isExpiredSoon = $obat->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty();
                        @endphp
                        <tr class="{{ $isExpiredSoon ? 'row-danger' : ($isLow ? 'row-warning' : '') }}">
                            <td class="text-secondary">{{ $obats->firstItem() + $index }}</td>
                            <td><span class="code-badge">{{ $obat->kode_obat ?? '-' }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="item-icon"><i class="material-symbols-rounded">medication</i></div>
                                    <div><span class="fw-bold d-block">{{ $obat->nama_obat }}</span>@if($obat->lokasi_rak)<span class="text-xs text-secondary"><i class="material-symbols-rounded text-xs">location_on</i> Rak: {{ $obat->lokasi_rak }}</span>@endif</div>
                                </div>
                            </td>
                            <td><span class="text-secondary">{{ $obat->kategori->nama_kategori ?? '-' }}</span></td>
                            <td><span class="text-secondary">{{ $obat->satuan->nama_satuan ?? '-' }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="status-dot {{ $isLow ? 'warning' : 'success' }}"></span>
                                    <span class="fw-bold {{ $isLow ? 'text-warning' : '' }}">{{ $totalStok }}</span>
                                </div>
                            </td>
                            <td><span class="min-badge">{{ $obat->stok_minimum }}</span></td>
                            <td class="text-center">
                                @if($isExpiredSoon)
                                    <span class="status-badge danger"><i class="material-symbols-rounded">event_busy</i> Exp < 30 Hari</span>
                                @elseif($isLow)
                                    <span class="status-badge warning"><i class="material-symbols-rounded">warning</i> Stok Rendah</span>
                                @else
                                    <span class="status-badge success"><i class="material-symbols-rounded">check_circle</i> Aman</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.obat.edit', $obat->id) }}" class="action-btn" title="Edit"><i class="material-symbols-rounded">edit</i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-5"><div class="empty-state"><i class="material-symbols-rounded">inventory_2</i><p>Tidak ada data stok ditemukan</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer pro-card-footer">
        <div class="footer-left">
            <span class="text-secondary text-sm">Tampilkan per halaman:</span>
            <form action="{{ route('stok.index') }}" method="GET" style="display: inline;">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="per_page" class="per-page-select" onchange="this.form.submit()">
                    @foreach([10,25,50,100] as $pp)<option value="{{ $pp }}" {{ request('per_page', 10) == $pp ? 'selected' : '' }}>{{ $pp }}</option>@endforeach
                </select>
            </form>
        </div>
        <div>{{ $obats->withQueryString()->links('pagination::bootstrap-5') }}</div>
    </div>
</div>

{{-- Legend --}}
<div class="legend-bar mt-3">
    <div class="legend-item"><span class="legend-dot success"></span><span>Stok > minimum (aman)</span></div>
    <div class="legend-item"><span class="legend-dot warning"></span><span>Stok ≤ minimum (rendah)</span></div>
    <div class="legend-item"><span class="legend-line danger"></span><span>Kadaluarsa < 30 hari</span></div>
</div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.welcome-stats { display: flex; gap: 10px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.stat-pill.primary { background: rgba(255,255,255,0.3); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
.floating-icon.icon-3 { animation-delay: 1s; }
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
.pro-card-header { padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; gap: 1rem; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 20px; }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.filter-form { display: flex; align-items: center; gap: 8px; }
.filter-group, .search-group { position: relative; display: flex; align-items: center; }
.filter-icon, .search-icon { position: absolute; left: 10px; color: var(--secondary); font-size: 18px; }
.filter-select, .search-input { height: 38px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; padding-left: 36px; }
.filter-select { min-width: 140px; appearance: none; background: white; cursor: pointer; }
.search-input { width: 180px; }
.btn-filter, .btn-clear { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 8px; background: linear-gradient(135deg, #1e293b, #334155); color: white; border: none; cursor: pointer; transition: all 0.2s; }
.btn-clear { background: white; color: var(--secondary); border: 1px solid #e2e8f0; text-decoration: none; }
.btn-filter:hover, .btn-clear:hover { transform: translateY(-2px); }
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #f8fafc; }
.pro-table tbody tr.row-warning { background: rgba(245,158,11,0.04); }
.pro-table tbody tr.row-danger { background: rgba(239,68,68,0.04); }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; }
.item-icon i { color: white; font-size: 18px; }
.code-badge { font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(59,130,246,0.2)); color: var(--info); font-weight: 500; }
.min-badge { font-size: 0.75rem; padding: 4px 8px; border-radius: 6px; background: #f1f5f9; color: var(--secondary); }
.status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
.status-dot.success { background: var(--success); }
.status-dot.warning { background: var(--warning); }
.status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; padding: 4px 10px; border-radius: 6px; font-weight: 500; }
.status-badge i { font-size: 14px; }
.status-badge.success { background: rgba(16,185,129,0.1); color: var(--success); }
.status-badge.warning { background: rgba(245,158,11,0.1); color: var(--warning); }
.status-badge.danger { background: rgba(239,68,68,0.1); color: var(--danger); }
.action-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; color: var(--secondary); transition: all 0.2s; }
.action-btn:hover { background: var(--primary); color: white; }
.action-btn i { font-size: 16px; }
.pro-card-footer { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; background: #fafbfc; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 1rem; }
.footer-left { display: flex; align-items: center; gap: 8px; }
.per-page-select { height: 32px; border-radius: 6px; border: 1px solid #e2e8f0; padding: 0 8px; font-size: 0.8rem; }
.empty-state { display: flex; flex-direction: column; align-items: center; color: var(--secondary); }
.empty-state i { font-size: 48px; margin-bottom: 8px; }
.legend-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 16px; font-size: 0.75rem; color: var(--secondary); }
.legend-item { display: flex; align-items: center; gap: 6px; }
.legend-dot { width: 8px; height: 8px; border-radius: 50%; }
.legend-dot.success { background: var(--success); }
.legend-dot.warning { background: var(--warning); }
.legend-line { width: 12px; height: 4px; border-radius: 2px; background: var(--danger); }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-stats { justify-content: center; } .welcome-illustration { display: none; } .filter-form { flex-wrap: wrap; } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
});
</script>
@endpush
@endsection