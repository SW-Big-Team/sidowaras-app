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
    <x-content-header title="Dashboard Laporan" subtitle="Monitoring dan analisis data apotek">
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary mb-0" onclick="window.print()">
                <i class="material-symbols-rounded text-sm me-1">print</i> Cetak
            </button>
            <button type="button" class="btn btn-outline-success mb-0">
                <i class="material-symbols-rounded text-sm me-1">download</i> Export Excel
            </button>
        </div>
    </x-content-header>

    <!-- Period Selector -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-sm font-weight-bold">Tanggal Dari</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="from" value="{{ request('from', $from->format('Y-m-d')) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-sm font-weight-bold">Tanggal Sampai</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="to" value="{{ request('to', $to->format('Y-m-d')) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mb-0 w-100">
                                <i class="material-symbols-rounded me-1">search</i> Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-rounded opacity-10">trending_up</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Pendapatan</p>
                        <h4 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        <p class="text-xs mb-0 {{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="material-symbols-rounded text-xs">{{ $revenueChange >= 0 ? 'arrow_upward' : 'arrow_downward' }}</i> 
                            {{ number_format(abs($revenueChange), 1) }}% dari periode sebelumnya
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-rounded opacity-10">receipt_long</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Transaksi</p>
                        <h4 class="mb-0">{{ number_format($totalTransactions) }}</h4>
                        <p class="text-xs mb-0 {{ $transactionsChange >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="material-symbols-rounded text-xs">{{ $transactionsChange >= 0 ? 'arrow_upward' : 'arrow_downward' }}</i> 
                            {{ number_format(abs($transactionsChange), 1) }}% dari periode sebelumnya
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-rounded opacity-10">shopping_cart</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Pembelian</p>
                        <h4 class="mb-0">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</h4>
                        <p class="text-xs mb-0 {{ $purchasesChange >= 0 ? 'text-danger' : 'text-success' }}">
                            <i class="material-symbols-rounded text-xs">{{ $purchasesChange >= 0 ? 'arrow_upward' : 'arrow_downward' }}</i> 
                            {{ number_format(abs($purchasesChange), 1) }}% dari periode sebelumnya
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-symbols-rounded opacity-10">inventory_2</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Jumlah Item Stok</p>
                        <h4 class="mb-0">{{ number_format($totalStock) }}</h4>
                        <p class="text-xs text-secondary mb-0">
                            Total produk tersedia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-0">Grafik Penjualan & Pembelian</h6>
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
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Metode Pembayaran</h6>
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
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Obat Terlaris</h6>
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
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Stok Menipis</h6>
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
@endsection