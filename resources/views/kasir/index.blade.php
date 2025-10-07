@extends('layouts.kasir.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h4 class="text-dark font-weight-bold mb-4">Dashboard Kasir</h4>
        </div>
    </div>

    <!-- Metrics Cards Row -->
    <div class="row">
        <!-- Pending Cart Approvals -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Cart Menunggu</p>
                                <h5 class="font-weight-bolder mb-0 text-warning">
                                    8
                                    <span class="text-sm font-weight-normal">Approval</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">pending_actions</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Transactions -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Transaksi Hari Ini</p>
                                <h5 class="font-weight-bolder mb-0 text-success">
                                    45
                                    <span class="text-sm font-weight-normal">Transaksi</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">receipt_long</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Sales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Penjualan Hari Ini</p>
                                <h5 class="font-weight-bolder mb-0 text-info">
                                    Rp 3.7M
                                    <span class="text-sm font-weight-normal">Total</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">payments</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Stok Minimum</p>
                                <h5 class="font-weight-bolder mb-0 text-danger">
                                    12
                                    <span class="text-sm font-weight-normal">Item</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">inventory</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Notifications Row -->
    <div class="row mt-4">
        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('kasir.transaksi.pos') }}" class="btn btn-lg w-100 bg-gradient-success text-white mb-0">
                                <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">point_of_sale</i>
                                <div class="text-sm">Transaksi Baru</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('kasir.cart.approval') }}" class="btn btn-lg w-100 bg-gradient-warning text-white mb-0">
                                <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">approval</i>
                                <div class="text-sm">Approval Cart</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('kasir.laporan.transaksi') }}" class="btn btn-lg w-100 bg-gradient-info text-white mb-0">
                                <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">analytics</i>
                                <div class="text-sm">Laporan Harian</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('kasir.laporan.transaksi') }}" class="btn btn-lg w-100 bg-gradient-primary text-white mb-0">
                                <i class="material-symbols-rounded mb-1" style="font-size: 2rem;">history</i>
                                <div class="text-sm">Riwayat Transaksi</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Notifications -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Notifikasi Stok Minimum</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-0 mb-2 bg-light rounded">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle">
                                        <i class="material-symbols-rounded opacity-10">warning</i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-0 text-sm font-weight-bold">Paracetamol 500mg</h6>
                                    <p class="text-xs text-muted mb-0">Stok tersisa: <strong>15 box</strong> (Min: 50)</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0 mb-2 bg-light rounded">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle">
                                        <i class="material-symbols-rounded opacity-10">warning</i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-0 text-sm font-weight-bold">Amoxicillin 500mg</h6>
                                    <p class="text-xs text-muted mb-0">Stok tersisa: <strong>28 box</strong> (Min: 40)</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0 mb-2 bg-light rounded">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle">
                                        <i class="material-symbols-rounded opacity-10">warning</i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-0 text-sm font-weight-bold">Vitamin C 1000mg</h6>
                                    <p class="text-xs text-muted mb-0">Stok tersisa: <strong>32 box</strong> (Min: 60)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-secondary w-100 mt-2">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Cart Approvals Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Cart Menunggu Approval</h6>
                    <a href="{{ route('kasir.cart.approval') }}" class="btn btn-sm btn-primary mb-0">Lihat Semua</a>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Karyawan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Budi Santoso</h6>
                                                <p class="text-xs text-secondary mb-0">ID: CART-001</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">12 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp 450.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">2 jam lalu</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('kasir.cart.approval') }}" class="btn btn-sm btn-success mb-0 me-1">Approve</a>
                                        <a href="#" class="btn btn-sm btn-danger mb-0">Reject</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Siti Aminah</h6>
                                                <p class="text-xs text-secondary mb-0">ID: CART-002</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">8 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp 320.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">3 jam lalu</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('kasir.cart.approval') }}" class="btn btn-sm btn-success mb-0 me-1">Approve</a>
                                        <a href="#" class="btn btn-sm btn-danger mb-0">Reject</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Ahmad Reza</h6>
                                                <p class="text-xs text-secondary mb-0">ID: CART-003</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">5 items</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp 180.000</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">5 jam lalu</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('kasir.cart.approval') }}" class="btn btn-sm btn-success mb-0 me-1">Approve</a>
                                        <a href="#" class="btn btn-sm btn-danger mb-0">Reject</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
