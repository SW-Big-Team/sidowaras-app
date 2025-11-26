@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Laporan Apotek')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Laporan</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard Laporan</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">analytics</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Dashboard Laporan</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Monitoring dan analisis data apotek</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <button type="button" class="btn btn-outline-white mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1" onclick="window.print()">
                                    <i class="material-symbols-rounded text-sm">print</i> Cetak
                                </button>
                                <button type="button" class="btn bg-white text-dark mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                    <i class="material-symbols-rounded text-sm">download</i> Export Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Period Selector -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal Dari</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="from" value="{{ request('from', $from->format('Y-m-d')) }}" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal Sampai</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="to" value="{{ request('to', $to->format('Y-m-d')) }}" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn bg-gradient-dark btn-sm mb-0 w-100 d-flex align-items-center justify-content-center gap-1">
                                <i class="material-symbols-rounded text-sm">search</i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Total Pendapatan
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            <p class="mb-0 text-xxs mt-1 {{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                                <span class="font-weight-bolder">{{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}%</span> dari periode lalu
                            </p>
                        </div>
                        <div class="summary-icon bg-soft-success">
                            <i class="material-symbols-rounded text-success">trending_up</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Total Transaksi
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">{{ number_format($totalTransactions) }}</h4>
                            <p class="mb-0 text-xxs mt-1 {{ $transactionsChange >= 0 ? 'text-success' : 'text-danger' }}">
                                <span class="font-weight-bolder">{{ $transactionsChange >= 0 ? '+' : '' }}{{ number_format($transactionsChange, 1) }}%</span> dari periode lalu
                            </p>
                        </div>
                        <div class="summary-icon bg-soft-primary">
                            <i class="material-symbols-rounded text-primary">receipt_long</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Total Pembelian
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</h4>
                            <p class="mb-0 text-xxs mt-1 {{ $purchasesChange >= 0 ? 'text-danger' : 'text-success' }}">
                                <span class="font-weight-bolder">{{ $purchasesChange >= 0 ? '+' : '' }}{{ number_format($purchasesChange, 1) }}%</span> dari periode lalu
                            </p>
                        </div>
                        <div class="summary-icon bg-soft-warning">
                            <i class="material-symbols-rounded text-warning">shopping_cart</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Jumlah Item Stok
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">{{ number_format($totalStock) }}</h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Total produk tersedia</p>
                        </div>
                        <div class="summary-icon bg-soft-info">
                            <i class="material-symbols-rounded text-info">inventory_2</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-0 fw-bold">Grafik Penjualan & Pembelian</h6>
                        <span class="text-xs text-secondary">{{ $from->format('d M Y') }} - {{ $to->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="salesChart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0 p-3">
                    <h6 class="mb-0 fw-bold">Metode Pembayaran</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="paymentChart" class="chart-canvas" height="300"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-sm">
                                <span class="badge badge-sm bg-gradient-success"></span> Tunai
                            </span>
                            <span class="text-sm font-weight-bold">{{ number_format($tunaiPercentage, 1) }}%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-sm">
                                <span class="badge badge-sm bg-gradient-info"></span> Non Tunai
                            </span>
                            <span class="text-sm font-weight-bold">{{ number_format($nonTunaiPercentage, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Reports -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">Obat Terlaris</h6>
                        <span class="text-xs text-secondary">Top 5</span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        @forelse($topSelling as $medicine)
                            <li class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0 text-sm">{{ $medicine->nama_obat }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $medicine->total_sold }} unit terjual</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge badge-sm bg-gradient-success">Rp {{ number_format($medicine->total_revenue, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item border-0 px-0 text-center text-secondary">
                                <p class="mb-0">Tidak ada data untuk periode ini</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">Stok Menipis</h6>
                        <a href="{{ route('admin.stok.index') }}" class="text-warning text-sm">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        @forelse($lowStock as $item)
                            <li class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0 text-sm">{{ $item->obat->nama_obat }}</h6>
                                        <p class="text-xs text-secondary mb-0">Stok Min: {{ $item->obat->stok_minimum }}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge badge-sm {{ $item->total_stock < ($item->obat->stok_minimum / 2) ? 'bg-gradient-danger' : 'bg-gradient-warning' }}">
                                            <i class="material-symbols-rounded text-xs">warning</i> {{ $item->total_stock }} tersisa
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item border-0 px-0 text-center text-secondary">
                                <p class="mb-0">Semua stok aman</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Pembelian (Juta Rp)',
                    data: @json($monthlyData['purchases'] ?? []),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value + 'jt';
                            }
                        }
                    }
                }
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
                    backgroundColor: ['#22c55e', '#06b6d4'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
@endpush

<style>
    .text-xxs { font-size: 0.65rem !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }

    .summary-card {
        transition: all 0.2s ease-in-out;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.07) !important;
    }
    .summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
    .bg-soft-danger  { background: rgba(220, 53, 69, 0.10) !important; }
    .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
    .bg-soft-info    { background: rgba(23, 162, 184, 0.10) !important; }
    .bg-soft-secondary { background: rgba(108, 117, 125, 0.08) !important; }
</style>
@endsection