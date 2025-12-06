@php
    $role = Auth::user()->role->nama_role;
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title','Daftar Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Transaksi</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Pembelian</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">receipt_long</i> Pembelian</span>
                    <h2 class="welcome-title">Daftar Pembelian</h2>
                    <p class="welcome-subtitle">Kelola riwayat pembelian dan stok masuk obat.</p>
                </div>
                <a href="{{ route('pembelian.create') }}" class="stat-pill primary"><i class="material-symbols-rounded">add_circle</i><span>Tambah Pembelian</span></a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">shopping_cart</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">inventory</i></div>
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
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
        <span class="alert-text"><strong>Error!</strong><ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon"><i class="material-symbols-rounded">receipt_long</i></div>
            <div class="metric-content"><span class="metric-label">Total Pembelian</span><h3 class="metric-value">{{ $pembelian->total() }}</h3><span class="metric-subtext">Semua transaksi</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon"><i class="material-symbols-rounded">payments</i></div>
            <div class="metric-content"><span class="metric-label">Tunai</span><h3 class="metric-value">{{ $pembelian->where('metode_pembayaran', 'tunai')->count() }}</h3><span class="metric-subtext">Pembayaran tunai</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card info">
            <div class="metric-icon"><i class="material-symbols-rounded">credit_card</i></div>
            <div class="metric-content"><span class="metric-label">Non Tunai</span><h3 class="metric-value">{{ $pembelian->where('metode_pembayaran', 'non tunai')->count() }}</h3><span class="metric-subtext">Transfer/kartu</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card warning">
            <div class="metric-icon"><i class="material-symbols-rounded">calendar_month</i></div>
            <div class="metric-content"><span class="metric-label">Termin</span><h3 class="metric-value">{{ $pembelian->where('metode_pembayaran', 'termin')->count() }}</h3><span class="metric-subtext">Cicilan</span></div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

{{-- Data Table --}}
<div class="card pro-card">
    <div class="card-header pro-card-header">
        <div class="header-left">
            <div class="header-icon primary"><i class="material-symbols-rounded">list_alt</i></div>
            <div><h6 class="header-title">Data Pembelian</h6><p class="header-subtitle">{{ $pembelian->total() }} transaksi</p></div>
        </div>
        <form action="{{ route('pembelian.index') }}" method="GET" class="search-form">
            <div class="search-group">
                <i class="material-symbols-rounded input-icon">search</i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari pembelian...">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            </div>
            <button type="submit" class="btn-pro"><i class="material-symbols-rounded">search</i></button>
            @if(request('search'))<a href="{{ route('pembelian.index') }}" class="btn-outline-pro btn-sm"><i class="material-symbols-rounded">close</i></a>@endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table pro-table mb-0">
                <thead><tr><th>#</th><th>No Faktur</th><th>Pengirim</th><th class="text-end">Total Harga</th><th class="text-center">Metode</th><th>User</th><th class="text-center">Tanggal</th><th class="text-center">Aksi</th></tr></thead>
                <tbody>
                    @forelse($pembelian as $p)
                        <tr>
                            <td><span class="text-secondary text-sm">{{ $loop->iteration + ($pembelian->firstItem() - 1) }}</span></td>
                            <td><span class="code-badge">{{ $p->no_faktur }}</span></td>
                            <td><div class="d-flex align-items-center gap-2"><div class="item-icon sm"><i class="material-symbols-rounded">local_shipping</i></div><span class="fw-bold">{{ $p->nama_pengirim }}</span></div></td>
                            <td class="text-end"><span class="fw-bold text-success">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span></td>
                            <td class="text-center">
                                @if($p->metode_pembayaran == 'tunai')<span class="status-badge success"><i class="material-symbols-rounded">payments</i> Tunai</span>
                                @elseif($p->metode_pembayaran == 'non tunai')<span class="status-badge info"><i class="material-symbols-rounded">credit_card</i> Non Tunai</span>
                                @else<span class="status-badge warning"><i class="material-symbols-rounded">calendar_month</i> Termin</span>@endif
                            </td>
                            <td><span class="text-secondary">{{ $p->user->nama_lengkap ?? $p->user->name ?? '-' }}</span></td>
                            <td class="text-center"><span class="date-badge">{{ $p->tgl_pembelian->format('d/m/Y H:i') }}</span></td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    @if($p->metode_pembayaran == 'termin')
                                        @php $belum_lunas = $p->pembayaranTermin->where('status', 'belum_lunas')->isNotEmpty(); @endphp
                                        @if($belum_lunas)<a href="{{ route('pembelian.show', $p->uuid) }}" class="action-btn success" title="Bayar Termin"><i class="material-symbols-rounded">payments</i></a>@endif
                                    @endif
                                    <a href="{{ route('pembelian.show', $p->uuid) }}" class="action-btn info" title="Detail"><i class="material-symbols-rounded">visibility</i></a>
                                    <a href="{{ route('pembelian.edit', $p->uuid) }}" class="action-btn warning" title="Edit"><i class="material-symbols-rounded">edit</i></a>
                                    <form action="{{ route('pembelian.destroy', $p->uuid) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">@csrf @method('DELETE')<button class="action-btn danger" title="Hapus"><i class="material-symbols-rounded">delete</i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-5"><div class="empty-state"><i class="material-symbols-rounded">receipt_long</i><p>Belum ada data pembelian</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer pro-card-footer">
        <div class="footer-left">
            <span class="text-secondary text-sm">Tampilkan</span>
            <select class="per-page-select" onchange="window.location.href='{{ route('pembelian.index') }}?per_page='+this.value+'&search={{ request('search') }}'">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-secondary text-sm">data per halaman</span>
        </div>
        <div class="footer-center">
            <span class="text-secondary text-sm"><strong>{{ $pembelian->firstItem() ?? 0 }}</strong> - <strong>{{ $pembelian->lastItem() ?? 0 }}</strong> dari <strong>{{ $pembelian->total() }}</strong> data</span>
        </div>
        <div class="footer-right">{{ $pembelian->links('pagination::bootstrap-5') }}</div>
    </div>
</div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #06b6d4; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.stat-pill.primary { background: rgba(255,255,255,0.3); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; color: white; }
.metric-card.primary .metric-icon { background: linear-gradient(135deg, #06b6d4, #0891b2); }
.metric-card.success .metric-icon { background: linear-gradient(135deg, #10b981, #059669); }
.metric-card.info .metric-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.metric-card.warning .metric-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-subtext { font-size: 0.75rem; color: var(--secondary); }
.metric-glow { position: absolute; top: -50%; right: -50%; width: 100%; height: 200%; border-radius: 50%; opacity: 0.08; }
.metric-card.primary .metric-glow { background: var(--primary); }
.metric-card.success .metric-glow { background: var(--success); }
.metric-card.info .metric-glow { background: var(--info); }
.metric-card.warning .metric-glow { background: var(--warning); }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 20px; }
.header-icon.primary { background: linear-gradient(135deg, #06b6d4, #0891b2); }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.search-form { display: flex; gap: 8px; align-items: center; }
.search-group { position: relative; }
.search-group .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 18px; }
.search-input { padding-left: 40px; height: 40px; width: 220px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.875rem; }
.search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(6,182,212,0.15); outline: none; }
.btn-pro { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: linear-gradient(135deg, #1e293b, #334155); color: white; font-size: 0.8rem; font-weight: 500; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: white; color: var(--secondary); font-size: 0.8rem; font-weight: 500; border-radius: 8px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro.btn-sm { padding: 6px 12px; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
.pro-table { margin: 0; }
.pro-table thead { background: linear-gradient(135deg, #1e293b, #334155); }
.pro-table th { font-size: 0.7rem; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; }
.pro-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.pro-table tbody tr:hover { background: #f8fafc; }
.item-icon { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #06b6d4, #0891b2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.item-icon.sm { width: 32px; height: 32px; }
.item-icon i { color: white; font-size: 18px; }
.code-badge { font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px; background: linear-gradient(135deg, rgba(6,182,212,0.1), rgba(6,182,212,0.2)); color: #0891b2; font-family: monospace; }
.status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; padding: 4px 10px; border-radius: 6px; font-weight: 500; }
.status-badge i { font-size: 14px; }
.status-badge.success { background: rgba(16,185,129,0.1); color: var(--success); }
.status-badge.info { background: rgba(59,130,246,0.1); color: var(--info); }
.status-badge.warning { background: rgba(245,158,11,0.1); color: var(--warning); }
.date-badge { font-size: 0.75rem; color: var(--secondary); }
.action-buttons { display: flex; gap: 4px; justify-content: center; }
.action-btn { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; background: #f1f5f9; color: var(--secondary); cursor: pointer; transition: all 0.2s; }
.action-btn i { font-size: 16px; }
.action-btn.info:hover { background: rgba(59,130,246,0.1); color: var(--info); }
.action-btn.warning:hover { background: rgba(245,158,11,0.1); color: var(--warning); }
.action-btn.danger:hover { background: rgba(239,68,68,0.1); color: var(--danger); }
.action-btn.success:hover { background: rgba(16,185,129,0.1); color: var(--success); }
.empty-state { display: flex; flex-direction: column; align-items: center; color: var(--secondary); }
.empty-state i { font-size: 48px; margin-bottom: 8px; }
.pro-card-footer { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; background: #fafbfc; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px; }
.footer-left, .footer-center { display: flex; align-items: center; gap: 8px; }
.per-page-select { padding: 4px 8px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.8rem; }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } .pro-card-header { flex-direction: column; align-items: stretch; } .search-form { width: 100%; } .search-input { width: 100%; } }
</style>
@endpush
@endsection