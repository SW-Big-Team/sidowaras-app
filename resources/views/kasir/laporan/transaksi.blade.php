@extends('layouts.kasir.app')

@section('breadcrumb', 'Laporan / Transaksi')
@section('page-title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid py-4">
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold mb-1">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="startDate" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold mb-1">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="endDate" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold mb-1">Metode Pembayaran</label>
                            <select class="form-select" id="paymentMethod">
                                <option value="">Semua Metode</option>
                                <option value="cash">Cash</option>
                                <option value="debit">Debit Card</option>
                                <option value="credit">Credit Card</option>
                                <option value="qris">QRIS</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100 mb-0">
                                <i class="material-symbols-rounded text-sm me-1">filter_alt</i>
                                Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Total Transaksi</p>
                                <h5 class="font-weight-bolder mb-0">
                                    45
                                    <span class="text-sm font-weight-normal">Transaksi</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">receipt_long</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Total Penjualan</p>
                                <h5 class="font-weight-bolder mb-0 text-success">
                                    Rp 3.7M
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">payments</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Rata-rata</p>
                                <h5 class="font-weight-bolder mb-0 text-info">
                                    Rp 82.222
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">calculate</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Item Terjual</p>
                                <h5 class="font-weight-bolder mb-0 text-warning">
                                    234
                                    <span class="text-sm font-weight-normal">Item</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 text-white" style="font-size: 2rem;">shopping_bag</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Method Breakdown -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Rincian Metode Pembayaran</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon icon-shape bg-gradient-success text-white rounded me-3">
                                    <i class="material-symbols-rounded">payments</i>
                                </div>
                                <div>
                                    <p class="text-xs mb-0 text-muted">Cash</p>
                                    <h6 class="mb-0 font-weight-bold">Rp 2.5M <span class="text-xs text-muted">(28 transaksi)</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon icon-shape bg-gradient-info text-white rounded me-3">
                                    <i class="material-symbols-rounded">credit_card</i>
                                </div>
                                <div>
                                    <p class="text-xs mb-0 text-muted">Debit Card</p>
                                    <h6 class="mb-0 font-weight-bold">Rp 850K <span class="text-xs text-muted">(10 transaksi)</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon icon-shape bg-gradient-warning text-white rounded me-3">
                                    <i class="material-symbols-rounded">qr_code</i>
                                </div>
                                <div>
                                    <p class="text-xs mb-0 text-muted">QRIS</p>
                                    <h6 class="mb-0 font-weight-bold">Rp 250K <span class="text-xs text-muted">(5 transaksi)</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon icon-shape bg-gradient-primary text-white rounded me-3">
                                    <i class="material-symbols-rounded">account_balance</i>
                                </div>
                                <div>
                                    <p class="text-xs mb-0 text-muted">Transfer</p>
                                    <h6 class="mb-0 font-weight-bold">Rp 100K <span class="text-xs text-muted">(2 transaksi)</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Top 5 Produk Terlaris</h6>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-0 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-sm">Paracetamol 500mg</h6>
                                    <p class="text-xs text-muted mb-0">45 terjual</p>
                                </div>
                                <span class="badge bg-success">Rp 675K</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-sm">Amoxicillin 500mg</h6>
                                    <p class="text-xs text-muted mb-0">38 terjual</p>
                                </div>
                                <span class="badge bg-success">Rp 950K</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-sm">Vitamin C 1000mg</h6>
                                    <p class="text-xs text-muted mb-0">32 terjual</p>
                                </div>
                                <span class="badge bg-success">Rp 1.44M</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-sm">OBH Combi</h6>
                                    <p class="text-xs text-muted mb-0">28 terjual</p>
                                </div>
                                <span class="badge bg-success">Rp 518K</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-sm">Promag Tablet</h6>
                                    <p class="text-xs text-muted mb-0">25 terjual</p>
                                </div>
                                <span class="badge bg-success">Rp 312K</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Detail Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-0">
                    <div>
                        <h6 class="text-dark font-weight-bold mb-0">Detail Transaksi Hari Ini</h6>
                        <p class="text-sm text-muted mb-0">{{ date('d F Y') }}</p>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-success mb-0 me-1">
                            <i class="material-symbols-rounded text-sm me-1">download</i>
                            Export Excel
                        </button>
                        <button class="btn btn-sm btn-danger mb-0">
                            <i class="material-symbols-rounded text-sm me-1">picture_as_pdf</i>
                            Export PDF
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Transaksi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kasir</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Metode</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">TRX-001</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">10:30 WIB</p>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">Admin Kasir</p>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">5 items</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-success">Cash</span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 125.000</p>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info mb-0" data-bs-toggle="modal" data-bs-target="#transactionModal">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary mb-0">
                                            <i class="material-symbols-rounded text-sm">print</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">TRX-002</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">11:15 WIB</p>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">Admin Kasir</p>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">3 items</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-info">Debit</span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 85.000</p>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info mb-0">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary mb-0">
                                            <i class="material-symbols-rounded text-sm">print</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">TRX-003</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">12:45 WIB</p>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">Admin Kasir</p>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0">8 items</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-warning">QRIS</span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-primary">Rp 250.000</p>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info mb-0">
                                            <i class="material-symbols-rounded text-sm">visibility</i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary mb-0">
                                            <i class="material-symbols-rounded text-sm">print</i>
                                        </button>
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

<!-- Transaction Detail Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi TRX-001</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>ID Transaksi:</strong> TRX-001</p>
                        <p class="text-sm mb-1"><strong>Waktu:</strong> 07 Okt 2025, 10:30 WIB</p>
                        <p class="text-sm mb-1"><strong>Kasir:</strong> Admin Kasir</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>Metode Pembayaran:</strong> <span class="badge bg-success">Cash</span></p>
                        <p class="text-sm mb-1"><strong>Status:</strong> <span class="badge bg-success">Selesai</span></p>
                    </div>
                </div>

                <h6 class="text-sm font-weight-bold mb-2">Detail Item:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Paracetamol 500mg</td>
                                <td>3</td>
                                <td>Rp 15.000</td>
                                <td>Rp 45.000</td>
                            </tr>
                            <tr>
                                <td>Promag Tablet</td>
                                <td>2</td>
                                <td>Rp 12.500</td>
                                <td>Rp 25.000</td>
                            </tr>
                            <tr>
                                <td>Betadine Salep</td>
                                <td>1</td>
                                <td>Rp 22.000</td>
                                <td>Rp 22.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td><strong>Rp 125.000</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Diskon:</td>
                                <td>Rp 0</td>
                            </tr>
                            <tr class="table-active">
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>Rp 125.000</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Bayar:</td>
                                <td>Rp 150.000</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Kembalian:</td>
                                <td>Rp 25.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">
                    <i class="material-symbols-rounded text-sm me-1">print</i> Print Struk
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
