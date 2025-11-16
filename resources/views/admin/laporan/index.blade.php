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
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Dari</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="from" value="{{ request('from', now()->startOfMonth()->format('Y-m-d')) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Sampai</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="to" value="{{ request('to', now()->format('Y-m-d')) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Jenis Laporan</label>
                            <div class="input-group input-group-outline">
                                <select name="type" class="form-control">
                                    <option value="all">Semua</option>
                                    <option value="transaksi">Transaksi</option>
                                    <option value="pembelian">Pembelian</option>
                                    <option value="stok">Stok</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <h4 class="mb-0">Rp 50.450.000</h4>
                        <p class="text-xs text-success mb-0">
                            <i class="material-symbols-rounded text-xs">arrow_upward</i> +15% dari bulan lalu
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
                        <h4 class="mb-0">1,245</h4>
                        <p class="text-xs text-success mb-0">
                            <i class="material-symbols-rounded text-xs">arrow_upward</i> +8% dari bulan lalu
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
                        <h4 class="mb-0">Rp 35.200.000</h4>
                        <p class="text-xs text-danger mb-0">
                            <i class="material-symbols-rounded text-xs">arrow_downward</i> -3% dari bulan lalu
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
                        <h4 class="mb-0">456</h4>
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
                        <button class="btn btn-sm btn-outline-primary mb-0">
                            <i class="material-symbols-rounded text-sm">refresh</i>
                        </button>
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
                            <span class="text-sm font-weight-bold">65%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-sm">
                                <span class="badge badge-sm bg-gradient-info"></span> Non Tunai
                            </span>
                            <span class="text-sm font-weight-bold">35%</span>
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
                        <a href="#" class="text-primary text-sm">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 text-sm">Paracetamol 500mg</h6>
                                    <p class="text-xs text-secondary mb-0">Kategori: Analgesik</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-sm bg-gradient-success">245 terjual</span>
                                    <p class="text-xs text-secondary mb-0">Rp 2.450.000</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 text-sm">Amoxicillin 500mg</h6>
                                    <p class="text-xs text-secondary mb-0">Kategori: Antibiotik</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-sm bg-gradient-success">198 terjual</span>
                                    <p class="text-xs text-secondary mb-0">Rp 3.960.000</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 text-sm">Vitamin C 1000mg</h6>
                                    <p class="text-xs text-secondary mb-0">Kategori: Vitamin</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-sm bg-gradient-success">156 terjual</span>
                                    <p class="text-xs text-secondary mb-0">Rp 1.560.000</p>
                                </div>
                            </div>
                        </li>
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
                        <li class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 text-sm">Ibuprofen 400mg</h6>
                                    <p class="text-xs text-secondary mb-0">Stok Min: 50</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-sm bg-gradient-warning">
                                        <i class="material-symbols-rounded text-xs">warning</i> 35 tersisa
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 text-sm">Cetirizine 10mg</h6>
                                    <p class="text-xs text-secondary mb-0">Stok Min: 30</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-sm bg-gradient-danger">
                                        <i class="material-symbols-rounded text-xs">warning</i> 18 tersisa
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 text-sm">Antasida Tablet</h6>
                                    <p class="text-xs text-secondary mb-0">Stok Min: 40</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-sm bg-gradient-warning">
                                        <i class="material-symbols-rounded text-xs">warning</i> 28 tersisa
                                    </span>
                                </div>
                            </div>
                        </li>
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
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Penjualan',
                    data: [65, 59, 80, 81, 56, 55, 70, 75, 85, 90, 95, 100],
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Pembelian',
                    data: [28, 48, 40, 19, 86, 27, 45, 50, 55, 60, 65, 70],
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
                        beginAtZero: true
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
                    data: [65, 35],
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