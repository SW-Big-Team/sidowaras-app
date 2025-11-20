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
            <a href="{{ route('admin.transaksi.riwayat') }}" class="btn btn-outline-dark btn-sm mb-0">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Riwayat
            </a>
            <button onclick="window.print()" class="btn bg-gradient-primary btn-sm mb-0">
                <i class="fas fa-print me-2"></i> Cetak Struk
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg border-0" id="invoice-card">
                
                {{-- HEADER: Transaction Info --}}
                <div class="card-header bg-gradient-dark p-4">
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
                            <span class="badge badge-lg bg-white text-dark mb-2">
                                {{ $transaksi->no_transaksi }}
                            </span>
                            <div class="text-sm text-white opacity-8">
                                <i class="far fa-calendar-alt me-1"></i> {{ $transaksi->tgl_transaksi->format('d F Y') }} &nbsp;|&nbsp; 
                                <i class="far fa-clock me-1"></i> {{ $transaksi->tgl_transaksi->format('H:i') }} WIB
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- INFO GRID --}}
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border border-radius-lg h-100">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Kasir Bertugas</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-gradient-primary rounded-circle me-2">
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
                            <div class="p-3 border border-radius-lg h-100">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Metode Pembayaran</h6>
                                <div class="d-flex align-items-center">
                                    @if($transaksi->metode_pembayaran === 'tunai')
                                        <div class="icon icon-sm bg-warning-soft text-warning rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <span class="text-dark font-weight-bold text-sm">Tunai (Cash)</span>
                                    @else
                                        <div class="icon icon-sm bg-info-soft text-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <span class="text-dark font-weight-bold text-sm">Non Tunai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border border-radius-lg bg-gradient-success h-100">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-white mb-2 opacity-8">Status Pembayaran</h6>
                                <div class="d-flex align-items-center">
                                    <i class="material-symbols-rounded text-white me-2">check_circle</i>
                                    <span class="badge bg-white text-success font-weight-bold">LUNAS</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE ITEMS --}}
                    <div class="table-responsive mb-4">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-3">Item Obat</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Batch</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Qty</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-end">Harga</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-end pe-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail as $item)
                                    <tr class="border-bottom">
                                        <td class="ps-3">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm text-dark">{{ $item->batch->obat->nama_obat }}</h6>
                                                <span class="text-xs text-secondary">{{ $item->batch->obat->kategori ?? 'Umum' }}</span>
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
                                        <td class="text-end align-middle pe-3">
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
                            <div class="card bg-gray-100 border-0 mb-0">
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
                                            <span class="badge bg-gradient-success font-weight-bolder">+ Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    <div class="mt-3 pt-3 border-top">
                                        <small class="text-xs text-secondary">
                                            <i class="material-symbols-rounded align-middle text-xxs me-1">info</i>
                                            Transaksi ID: {{ $transaksi->id }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-white text-center pt-0 border-top">
                    <p class="text-xs text-secondary mb-0 opacity-6">Terima kasih telah berbelanja di Sidowaras Pharmacy.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gray-100 { background-color: #f8f9fa !important; }
.bg-warning-soft { background-color: #fff3cd !important; }
.bg-info-soft { background-color: #e0f2fe !important; }

.icon-sm {
    width: 32px;
    height: 32px;
}

/* Print Specific Styles */
@media print {
    .sidenav, .navbar, .sidebar-toggle-plugin, .btn {
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
    }
}
</style>
@endpush