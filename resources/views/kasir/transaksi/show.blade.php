@extends('layouts.kasir.app')

@section('title', 'Detail Transaksi #' . $transaksi->no_transaksi)

@section('content')
<div class="container-fluid py-4">
    {{-- Action Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('kasir.transaksi.riwayat') }}" class="btn btn-outline-dark btn-sm mb-0">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm mb-0 bg-gradient-primary">
                <i class="fas fa-print me-2"></i> Cetak Struk
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-12">
            <div class="card shadow-lg border-0" id="invoice-card">
                
                {{-- HEADER: BRANDING & ID --}}
                <div class="card-header bg-white p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded opacity-10">receipt_long</i>
                                </div>
                                <div>
                                    <h5 class="mb-0 text-dark font-weight-bolder">Detail Transaksi</h5>
                                    <p class="text-sm text-secondary mb-0">Sidowaras Pharmacy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-start mt-3 mt-md-0">
                            <span class="badge badge-lg bg-light text-dark border mb-2">
                                {{ $transaksi->no_transaksi }}
                            </span>
                            <div class="text-sm text-secondary">
                                <i class="far fa-calendar-alt me-1"></i> {{ $transaksi->tgl_transaksi->format('d F Y') }} &nbsp;|&nbsp; 
                                <i class="far fa-clock me-1"></i> {{ $transaksi->tgl_transaksi->format('H:i') }} WIB
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- INFO GRID --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="p-3 border border-radius-lg bg-gray-100 h-100">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Metode Pembayaran</h6>
                                <div class="d-flex align-items-center">
                                    @if($transaksi->metode_pembayaran === 'tunai')
                                        <div class="icon icon-sm bg-success-soft text-success rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <span class="text-dark font-weight-bold text-sm">Tunai (Cash)</span>
                                    @else
                                        <div class="icon icon-sm bg-info-soft text-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <span class="text-dark font-weight-bold text-sm">Non Tunai (Transfer/QRIS)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <div class="p-3 border border-radius-lg bg-gray-100 h-100">
                                <h6 class="text-uppercase text-xs font-weight-bolder text-secondary mb-2">Status Pembayaran</h6>
                                <span class="badge badge-sm bg-gradient-success">LUNAS</span>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE ITEMS --}}
                    <div class="table-responsive mb-4">
                        <table class="table align-items-center mb-0 table-borderless">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Item Obat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Batch</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Qty</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end pe-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail as $item)
                                    <tr class="border-bottom">
                                        <td class="ps-3">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm text-dark">{{ $item->batch->obat->nama_obat }}</h6>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="text-xs font-weight-bold text-secondary bg-light px-2 py-1 rounded border">
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

                    {{-- PAYMENT CALCULATION SECTION --}}
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="bg-gray-100 p-4 border-radius-lg">
                                {{-- Grand Total --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-dark font-weight-bold">Total Tagihan</span>
                                    <h5 class="text-primary font-weight-bolder mb-0">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h5>
                                </div>

                                @if($transaksi->metode_pembayaran === 'tunai')
                                    <hr class="horizontal dark my-2">
                                    
                                    {{-- Tunai Specifics --}}
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="text-secondary text-sm">Uang Diterima</span>
                                        <span class="text-dark font-weight-bold">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="text-secondary text-sm">Kembalian</span>
                                        <span class="text-success font-weight-bolder text-lg">+ Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-white text-center pt-0">
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
    .bg-success-soft { background-color: #dcfce7 !important; }
    .bg-info-soft { background-color: #e0f2fe !important; }
    
    /* Print Specific Styles */
    @media print {
        body * { visibility: hidden; }
        #invoice-card, #invoice-card * { visibility: visible; }
        #invoice-card {
            position: absolute;
            left: 0; top: 0;
            width: 100%;
            margin: 0; padding: 0;
            box-shadow: none !important;
            border: none !important;
        }
        .no-print { display: none !important; }
    }
</style>
@endpush