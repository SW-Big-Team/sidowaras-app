@extends('layouts.admin.app')
@section('title', 'Detail Transaksi #' . $transaksi->no_transaksi)

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Transaksi</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.transaksi.riwayat') }}">Riwayat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Action Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('admin.transaksi.riwayat') }}" class="btn btn-outline-dark btn-sm mb-0 d-flex align-items-center gap-1">
                <i class="material-symbols-rounded text-sm">arrow_back</i> Kembali ke Riwayat
            </a>
            <button onclick="window.print()" class="btn bg-gradient-primary btn-sm mb-0 d-flex align-items-center gap-1 shadow-sm-sm">
                <i class="material-symbols-rounded text-sm">print</i> Cetak Struk
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg border-0 rounded-3" id="invoice-card">
                
                {{-- HEADER: Transaction Info --}}
                <div class="card-header bg-gradient-dark p-4 rounded-top-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">receipt_long</i>
                                </div>
                                <div>
                                    <h5 class="mb-0 text-white font-weight-bolder">Detail Transaksi</h5>
                                    <p class="text-sm text-white opacity-8 mb-0">Sidowaras Pharmacy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-start mt-3 mt-md-0">
                            <span class="badge badge-lg bg-white text-dark mb-2 shadow-sm-sm">
                                {{ $transaksi->no_transaksi }}
                            </span>
                            <div class="text-sm text-white opacity-8 d-flex align-items-center justify-content-md-end gap-2">
                                <span class="d-flex align-items-center gap-1"><i class="material-symbols-rounded text-xs">calendar_today</i> {{ $transaksi->tgl_transaksi->format('d F Y') }}</span>
                                <span>|</span>
                                <span class="d-flex align-items-center gap-1"><i class="material-symbols-rounded text-xs">schedule</i> {{ $transaksi->tgl_transaksi->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- INFO GRID --}}
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border border-radius-lg h-100 shadow-sm-sm bg-white">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Kasir Bertugas</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-gradient-primary rounded-circle me-2 shadow-sm">
                                        <span class="text-white text-xs font-weight-bold">{{ substr($transaksi->user->nama_lengkap, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-dark font-weight-bold text-sm d-block">{{ $transaksi->user->nama_lengkap }}</span>
                                        <span class="text-xs text-secondary">{{ $transaksi->user->role->nama_role }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border border-radius-lg h-100 shadow-sm-sm bg-white">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Metode Pembayaran</h6>
                                <div class="d-flex align-items-center">
                                    @if($transaksi->metode_pembayaran === 'tunai')
                                        <div class="icon icon-sm bg-soft-warning text-warning rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="material-symbols-rounded text-sm">payments</i>
                                        </div>
                                        <span class="text-dark font-weight-bold text-sm">Tunai (Cash)</span>
                                    @else
                                        <div class="icon icon-sm bg-soft-info text-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="material-symbols-rounded text-sm">credit_card</i>
                                        </div>
                                        <span class="text-dark font-weight-bold text-sm">Non Tunai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border border-radius-lg h-100 shadow-sm-sm bg-white">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Status Pembayaran</h6>
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-sm bg-soft-success text-success rounded-circle me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-symbols-rounded text-sm">check_circle</i>
                                    </div>
                                    <span class="text-dark font-weight-bold text-sm">LUNAS</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE ITEMS --}}
                    <div class="table-responsive mb-4 rounded-3 border">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Item Obat</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Batch</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Qty</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-end">Harga</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail as $item)
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm text-dark font-weight-bold">{{ $item->batch->obat->nama_obat }}</h6>
                                                <span class="text-xs text-secondary">{{ $item->batch->obat->kategori->nama_kategori ?? 'Umum' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge badge-sm bg-light text-dark border">
                                                {{ $item->batch->no_batch }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="text-sm text-dark font-weight-bold">{{ $item->jumlah }}</span>
                                        </td>
                                        <td class="text-end align-middle">
                                            <span class="text-sm text-secondary">Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-end align-middle pe-4">
                                            <span class="text-sm text-dark font-weight-bold">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAYMENT SUMMARY --}}
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="card bg-gray-100 border-0 mb-0 rounded-3">
                                <div class="card-body p-4">
                                    {{-- Grand Total --}}
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                        <span class="text-dark font-weight-bold">Total Tagihan</span>
                                        <h4 class="text-dark font-weight-bolder mb-0">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h4>
                                    </div>

                                    @if($transaksi->metode_pembayaran === 'tunai')
                                        {{-- Cash Details --}}
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="text-secondary text-sm">Uang Diterima</span>
                                            <span class="text-dark font-weight-bold">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-2 pt-3 border-top">
                                            <span class="text-secondary text-sm">Kembalian</span>
                                            <span class="badge bg-gradient-success font-weight-bolder shadow-sm">+ Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    <div class="mt-3 pt-3 border-top">
                                        <small class="text-xs text-secondary d-flex align-items-center">
                                            <i class="material-symbols-rounded align-middle text-sm me-1">info</i>
                                            Transaksi ID: {{ $transaksi->id }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-white text-center pt-0 border-top rounded-bottom-3">
                    <p class="text-xs text-secondary mb-0 opacity-6 mt-3">Terima kasih telah berbelanja di Sidowaras Pharmacy.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gray-100 { background-color: #f8f9fa !important; }
.bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
.bg-soft-info { background: rgba(23, 162, 184, 0.12) !important; }
.bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
.shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }

.icon-sm {
    width: 32px;
    height: 32px;
}

.table-stok thead tr th {
    border-top: none;
    font-weight: 600;
    letter-spacing: .04em;
}

.table-stok tbody tr {
    transition: background-color 0.15s ease;
}
.table-stok tbody tr:hover {
    background-color: #f8f9fe;
}

.table td, .table th { vertical-align: middle; }

/* Print Specific Styles */
@media print {
    .sidenav, .navbar, .sidebar-toggle-plugin, .btn, .breadcrumb {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: none !important;
    }
    
    .bg-gradient-dark, .bg-gradient-success {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    @page {
        margin: 1.5cm;
        size: A4;
    }
    
    body {
        padding: 0 !important;
        margin: 0 !important;
        background-color: white !important;
    }

    .container-fluid {
        padding: 0 !important;
    }
}
</style>
@endpush