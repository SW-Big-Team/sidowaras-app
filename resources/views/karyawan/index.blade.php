@extends('layouts.karyawan.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h4 class="text-dark font-weight-bold mb-1">Dashboard Karyawan</h4>
            <p class="text-sm text-muted mb-4">Bantu pelanggan, kelola cart, dan lakukan stock opname harian/bulanan</p>
        </div>
    </div>

    <!-- Metrics Cards Row -->
    <div class="row">
        <!-- Cart Active -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Cart Aktif Saya</p>
                                <h5 class="font-weight-bolder mb-0 text-primary">
                                    3
                                    <span class="text-sm font-weight-normal">Cart</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">shopping_cart</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Opname Today -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Stok Opname Hari Ini</p>
                                <h5 class="font-weight-bolder mb-0 text-success">
                                    45
                                    <span class="text-sm font-weight-normal">Item</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">fact_check</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Expired -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Obat Expired</p>
                                <h5 class="font-weight-bolder mb-0 text-danger">
                                    5
                                    <span class="text-sm font-weight-normal">Item</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">event_busy</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Low -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Stok Hampir Habis</p>
                                <h5 class="font-weight-bolder mb-0 text-warning">
                                    12
                                    <span class="text-sm font-weight-normal">Item</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">inventory</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Customer Service -->
    <div class="row mt-4">
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Aksi Cepat</h6>
                    <p class="text-sm mb-0">Fitur utama karyawan</p>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('karyawan.keranjang') }}" class="btn btn-lg bg-gradient-primary text-white mb-0">
                            <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">shopping_cart</i>
                            <div class="text-sm">Input Cart Pelanggan</div>
                        </a>
                        <a href="{{ route('scanner') }}" class="btn btn-lg bg-gradient-success text-white mb-0">
                            <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">qr_code_scanner</i>
                            <div class="text-sm">Scan Barcode Obat</div>
                        </a>
                        <a href="{{ route('karyawan.stock.index') }}" class="btn btn-lg bg-gradient-warning text-white mb-0">
                            <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">inventory_2</i>
                            <div class="text-sm">Stok Opname</div>
                        </a>
                        <a href="{{ route('karyawan.stock.tambah') }}" class="btn btn-lg bg-gradient-info text-white mb-0">
                            <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">add_box</i>
                            <div class="text-sm">Tambah Obat Baru</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Cart Saya - Status Approval</h6>
                    <p class="text-sm mb-0">Daftar cart yang sudah disubmit</p>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Cart</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <h6 class="mb-0 text-sm">CART-008</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">15 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 560.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">15 menit lalu</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-warning">Pending Approval</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <h6 class="mb-0 text-sm">CART-007</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">8 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 320.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">1 jam lalu</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-success">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <h6 class="mb-0 text-sm">CART-006</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">12 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 450.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">3 jam lalu</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-danger">Rejected</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Opname Progress -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Progress Stok Opname Bulan Ini</h6>
                    <p class="text-sm mb-0">Target: 1,245 item</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">Completed</span>
                            <span class="text-sm font-weight-bold">980 / 1,245 (78.7%)</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 78.7%" aria-valuenow="78.7" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-6 text-center">
                            <div class="p-3 bg-light border-radius-md">
                                <p class="text-xs mb-0 text-muted">Target Harian</p>
                                <h6 class="mb-0">42 item/hari</h6>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <div class="p-3 bg-light border-radius-md">
                                <p class="text-xs mb-0 text-muted">Sisa Hari</p>
                                <h6 class="mb-0">7 hari</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Aktivitas Hari Ini</h6>
                    <p class="text-sm mb-0">Timeline aktivitas karyawan</p>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-gradient-success">
                                <i class="material-symbols-rounded text-white text-sm">check_circle</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Submit cart CART-008</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">15 items - Rp 560.000</p>
                                <p class="text-xs text-muted mt-1 mb-0">15 menit yang lalu</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-gradient-info">
                                <i class="material-symbols-rounded text-white text-sm">fact_check</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Stok opname Gudang A</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">45 item tercatat</p>
                                <p class="text-xs text-muted mt-1 mb-0">2 jam yang lalu</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-gradient-warning">
                                <i class="material-symbols-rounded text-white text-sm">qr_code_scanner</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Scan barcode - Customer service</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Membantu pelanggan cari obat</p>
                                <p class="text-xs text-muted mt-1 mb-0">3 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Alerts -->
    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Notifikasi Stok</h6>
                    <p class="text-sm mb-0">Item yang perlu perhatian</p>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="list-group-item px-3 py-2 border-0 bg-light rounded">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle">
                                            <i class="material-symbols-rounded opacity-10">warning</i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0 text-sm font-weight-bold">Paracetamol 500mg - EXPIRED</h6>
                                        <p class="text-xs text-muted mb-0">Expired: 01 Okt 2025 | Stok: 15 box</p>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-outline-danger mb-0">Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="list-group-item px-3 py-2 border-0 bg-light rounded">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle">
                                            <i class="material-symbols-rounded opacity-10">inventory_2</i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0 text-sm font-weight-bold">Amoxicillin 500mg - LOW STOCK</h6>
                                        <p class="text-xs text-muted mb-0">Stok tersisa: 28 box (Min: 40)</p>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-outline-warning mb-0">Restock</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
