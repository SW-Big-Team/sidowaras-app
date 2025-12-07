@php
    $role = Auth::user()->role->nama_role;
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title', 'Laporan Apotek')

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Laporan</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard Laporan</li>
    </ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner analytics">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge">
                        <i class="material-symbols-rounded">analytics</i>
                        Dashboard Analitik
                    </span>
                    <h2 class="welcome-title">Laporan & Statistik</h2>
                    <p class="welcome-subtitle">Monitor performa bisnis, analisis penjualan, dan kelola inventori dengan insight yang komprehensif.</p>
                </div>
                <div class="welcome-stats">
                    <div class="stat-pill">
                        <i class="material-symbols-rounded">date_range</i>
                        <span>{{ $from->format('d M') }} - {{ $to->format('d M Y') }}</span>
                    </div>
                    <form action="{{ route('admin.laporan.index') }}" method="GET" class="d-inline">
                        <input type="hidden" name="from" value="{{ $from->format('Y-m-d') }}">
                        <input type="hidden" name="to" value="{{ $to->format('Y-m-d') }}">
                        <input type="hidden" name="filter_type" value="custom">
                        <button type="submit" name="export" value="excel" class="stat-pill success">
                            <i class="material-symbols-rounded">download</i>
                            <span>Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">trending_up</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">pie_chart</i></div>
                <div class="floating-icon icon-3"><i class="material-symbols-rounded">bar_chart</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Period Filter --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card pro-card">
            <div class="card-body p-3">
                <form method="GET" class="row g-3 align-items-end" id="filterForm">
                    <div class="col-md-3">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Jenis Filter</label>
                        <select class="form-select form-select-sm filter-select" name="filter_type" id="filterType" onchange="toggleFilters()">
                            <option value="daily" {{ request('filter_type') == 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="monthly" {{ request('filter_type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="yearly" {{ request('filter_type') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            <option value="custom" {{ request('filter_type', 'custom') == 'custom' ? 'selected' : '' }}>Kustom</option>
                        </select>
                    </div>

                    <div class="col-md-3 filter-group" id="dailyFilter" style="display: none;">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal</label>
                        <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date', now()->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-3 filter-group" id="monthlyFilter" style="display: none;">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Bulan</label>
                        <input type="month" name="month" class="form-control form-control-sm" value="{{ request('month', now()->format('Y-m')) }}">
                    </div>

                    <div class="col-md-3 filter-group" id="yearlyFilter" style="display: none;">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tahun</label>
                        <select name="year" class="form-select form-select-sm">
                            @for($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6 filter-group row g-3" id="customFilter" style="display: none;">
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Dari</label>
                            <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from', $from->format('Y-m-d')) }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Sampai</label>
                            <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to', $to->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn-pro w-100">
                            <i class="material-symbols-rounded">search</i>
                            Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card success">
            <div class="metric-icon">
                <i class="material-symbols-rounded">trending_up</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Total Pendapatan</span>
                <h3 class="metric-value">Rp {{ number_format($totalRevenue / 1000000, 1) }}jt</h3>
                <div class="metric-change {{ $revenueChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="material-symbols-rounded">{{ $revenueChange >= 0 ? 'trending_up' : 'trending_down' }}</i>
                    <span>{{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}%</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card primary">
            <div class="metric-icon">
                <i class="material-symbols-rounded">receipt_long</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Total Transaksi</span>
                <h3 class="metric-value">{{ number_format($totalTransactions) }}</h3>
                <div class="metric-change {{ $transactionsChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="material-symbols-rounded">{{ $transactionsChange >= 0 ? 'trending_up' : 'trending_down' }}</i>
                    <span>{{ $transactionsChange >= 0 ? '+' : '' }}{{ number_format($transactionsChange, 1) }}%</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card warning">
            <div class="metric-icon">
                <i class="material-symbols-rounded">shopping_cart</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Total Pembelian</span>
                <h3 class="metric-value">Rp {{ number_format($totalPurchases / 1000000, 1) }}jt</h3>
                <div class="metric-change {{ $purchasesChange <= 0 ? 'positive' : 'negative' }}">
                    <i class="material-symbols-rounded">{{ $purchasesChange <= 0 ? 'trending_down' : 'trending_up' }}</i>
                    <span>{{ $purchasesChange >= 0 ? '+' : '' }}{{ number_format($purchasesChange, 1) }}%</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card info">
            <div class="metric-icon">
                <i class="material-symbols-rounded">inventory_2</i>
            </div>
            <div class="metric-content">
                <span class="metric-label">Jumlah Item Stok</span>
                <h3 class="metric-value">{{ number_format($totalStock) }}</h3>
                <div class="metric-change neutral">
                    <i class="material-symbols-rounded">store</i>
                    <span>Produk tersedia</span>
                </div>
            </div>
            <div class="metric-glow"></div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card pro-card h-100">
            <div class="card-header pro-card-header">
                <div class="header-left">
                    <div class="header-icon success">
                        <i class="material-symbols-rounded">show_chart</i>
                    </div>
                    <div>
                        <h6 class="header-title">Grafik Penjualan & Pembelian</h6>
                        <p class="header-subtitle">{{ $from->format('d M Y') }} - {{ $to->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="chart" style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card pro-card h-100">
            <div class="card-header pro-card-header">
                <div class="header-left">
                    <div class="header-icon info">
                        <i class="material-symbols-rounded">pie_chart</i>
                    </div>
                    <div>
                        <h6 class="header-title">Metode Pembayaran</h6>
                        <p class="header-subtitle">Distribusi pembayaran</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="chart" style="height: 200px;">
                    <canvas id="paymentChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm d-flex align-items-center gap-2">
                            <span class="legend-dot success"></span> Tunai
                        </span>
                        <span class="text-sm font-weight-bold">{{ number_format($tunaiPercentage, 1) }}%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-sm d-flex align-items-center gap-2">
                            <span class="legend-dot info"></span> Non Tunai
                        </span>
                        <span class="text-sm font-weight-bold">{{ number_format($nonTunaiPercentage, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Reports --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="card pro-card">
            <div class="card-header pro-card-header">
                <div class="header-left">
                    <div class="header-icon warning">
                        <i class="material-symbols-rounded">star</i>
                    </div>
                    <div>
                        <h6 class="header-title">Obat Terlaris</h6>
                        <p class="header-subtitle">Top 5 produk</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="top-list">
                    @forelse($topSelling as $index => $medicine)
                        <div class="top-item">
                            <div class="top-rank {{ $index < 3 ? 'gold' : '' }}">{{ $index + 1 }}</div>
                            <div class="top-info">
                                <span class="top-name">{{ $medicine->nama_obat }}</span>
                                <span class="top-meta">{{ $medicine->total_sold }} unit terjual</span>
                            </div>
                            <span class="top-value success">Rp {{ number_format($medicine->total_revenue / 1000, 0) }}K</span>
                        </div>
                    @empty
                        <div class="empty-state py-4">
                            <p class="text-secondary mb-0">Tidak ada data periode ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card pro-card">
            <div class="card-header pro-card-header">
                <div class="header-left">
                    <div class="header-icon danger">
                        <i class="material-symbols-rounded">warning</i>
                    </div>
                    <div>
                        <h6 class="header-title">Stok Menipis</h6>
                        <p class="header-subtitle">Perlu di-restock</p>
                    </div>
                </div>
                <a href="{{ route('admin.stok.index') }}" class="btn-link-pro">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="top-list">
                    @forelse($lowStock as $item)
                        <div class="top-item">
                            <div class="top-rank warning"><i class="material-symbols-rounded">inventory_2</i></div>
                            <div class="top-info">
                                <span class="top-name">{{ $item->obat->nama_obat }}</span>
                                <span class="top-meta">Min: {{ $item->obat->stok_minimum }}</span>
                            </div>
                            <span class="top-value {{ $item->total_stock < ($item->obat->stok_minimum / 2) ? 'danger' : 'warning' }}">
                                {{ $item->total_stock }} sisa
                            </span>
                        </div>
                    @empty
                        <div class="empty-state py-4 text-center">
                            <i class="material-symbols-rounded text-success" style="font-size: 32px;">check_circle</i>
                            <p class="text-secondary mb-0 mt-2">Semua stok aman</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
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

.welcome-banner.analytics {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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

.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
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
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.stat-pill.success { background: rgba(255,255,255,0.3); }

.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
.floating-icon.icon-3 { animation-delay: 1s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

.metric-card { background: white; border-radius: 16px; padding: 1.25rem; display: flex; gap: 1rem; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.metric-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.metric-icon i { font-size: 26px; }
.metric-card.success .metric-icon { background: rgba(16,185,129,0.12); }
.metric-card.success .metric-icon i { color: var(--success); }
.metric-card.warning .metric-icon { background: rgba(245,158,11,0.12); }
.metric-card.warning .metric-icon i { color: var(--warning); }
.metric-card.info .metric-icon { background: rgba(59,130,246,0.12); }
.metric-card.info .metric-icon i { color: var(--info); }
.metric-card.primary .metric-icon { background: rgba(139,92,246,0.12); }
.metric-card.primary .metric-icon i { color: var(--primary); }
.metric-content { flex: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.metric-value { font-size: 1.35rem; font-weight: 700; color: #1e293b; margin: 4px 0; }
.metric-change { display: flex; align-items: center; gap: 4px; font-size: 0.75rem; font-weight: 500; }
.metric-change i { font-size: 16px; }
.metric-change.positive { color: var(--success); }
.metric-change.negative { color: var(--danger); }
.metric-change.neutral { color: var(--secondary); }
.metric-glow { position: absolute; width: 120px; height: 120px; border-radius: 50%; right: -30px; bottom: -30px; opacity: 0.1; }
.metric-card.success .metric-glow { background: var(--success); }
.metric-card.warning .metric-glow { background: var(--warning); }
.metric-card.info .metric-glow { background: var(--info); }
.metric-card.primary .metric-glow { background: var(--primary); }

.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.pro-card-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; }
.header-icon i { color: #000000 !important; font-size: 20px; }
.header-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.header-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.header-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.header-icon.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
.header-title { font-size: 1rem; font-weight: 600; color: #000000 !important; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: #000000 !important; margin: 0; }

.btn-pro { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 20px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-size: 0.85rem; font-weight: 500; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,185,129,0.4); }
.btn-pro i { font-size: 18px; }

.btn-link-pro { color: var(--warning); font-size: 0.8rem; font-weight: 500; text-decoration: none; }
.btn-link-pro:hover { text-decoration: underline; }

.filter-select { border-radius: 10px; border: 1px solid #e2e8f0; padding: 8px 12px; }

.legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
.legend-dot.success { background: var(--success); }
.legend-dot.info { background: var(--info); }

.top-list { padding: 0; }
.top-item { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-bottom: 1px solid #f1f5f9; transition: background 0.2s; }
.top-item:hover { background: #f8fafc; }
.top-item:last-child { border-bottom: none; }
.top-rank { width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; color: var(--secondary); }
.top-rank.gold { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.top-rank.warning { background: rgba(245,158,11,0.12); color: var(--warning); }
.top-rank i { font-size: 18px; }
.top-info { flex: 1; }
.top-name { display: block; font-weight: 600; color: #1e293b; font-size: 0.875rem; }
.top-meta { font-size: 0.75rem; color: var(--secondary); }
.top-value { font-weight: 700; font-size: 0.85rem; padding: 4px 10px; border-radius: 6px; }
.top-value.success { background: rgba(16,185,129,0.12); color: var(--success); }
.top-value.warning { background: rgba(245,158,11,0.12); color: var(--warning); }
.top-value.danger { background: rgba(239,68,68,0.12); color: var(--danger); }

.empty-state { text-align: center; }

@media (max-width: 768px) {
    .welcome-banner.analytics { flex-direction: column; text-align: center; }
    .welcome-stats { justify-content: center; }
    .welcome-illustration { display: none; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Penjualan (Juta Rp)',
                    data: @json($monthlyData['sales'] ?? []),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                }, {
                    label: 'Pembelian (Juta Rp)',
                    data: @json($monthlyData['purchases'] ?? []),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true, position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v + 'jt' } } }
            }
        });
    }

    // Payment Chart
    const paymentCtx = document.getElementById('paymentChart');
    if (paymentCtx) {
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tunai', 'Non Tunai'],
                datasets: [{
                    data: [@json($tunaiPercentage), @json($nonTunaiPercentage)],
                    backgroundColor: ['#10b981', '#3b82f6'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    toggleFilters();
});

function toggleFilters() {
    const type = document.getElementById('filterType').value;
    document.querySelectorAll('.filter-group').forEach(el => el.style.display = 'none');
    if (type === 'daily') document.getElementById('dailyFilter').style.display = 'block';
    else if (type === 'monthly') document.getElementById('monthlyFilter').style.display = 'block';
    else if (type === 'yearly') document.getElementById('yearlyFilter').style.display = 'block';
    else document.getElementById('customFilter').style.display = 'flex';
}
</script>
@endpush