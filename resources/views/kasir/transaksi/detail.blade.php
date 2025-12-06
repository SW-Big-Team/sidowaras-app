@extends('layouts.kasir.app')

@section('page_title', 'Detail Transaksi')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-0 px-0">
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="{{ route('kasir.dashboard') }}">
                                    <i class="material-symbols-rounded text-sm">home</i>
                                </a>
                            </li>
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="{{ route('kasir.transaksi.index') }}">Transaksi</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                    <h4 class="font-weight-bolder text-dark mb-0">Detail Transaksi</h4>
                    <p class="text-sm text-secondary mb-0">Informasi lengkap transaksi penjualan</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('kasir.transaksi.index') }}" class="btn btn-outline-secondary btn-sm mb-0 d-flex align-items-center gap-2">
                        <i class="material-symbols-rounded text-sm">arrow_back</i>
                        Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-dark btn-sm mb-0 d-flex align-items-center gap-2">
                        <i class="material-symbols-rounded text-sm">print</i>
                        Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Transaction Info Card -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-gradient-primary p-4 border-radius-top-start-lg border-radius-top-end-lg">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-white text-primary rounded-circle shadow d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="material-symbols-rounded">receipt_long</i>
                        </div>
                        <div>
                            <p class="text-white text-xs mb-0 opacity-8">Kode Transaksi</p>
                            <h5 class="text-white font-weight-bold mb-0">{{ $transaksi->kode_transaksi ?? 'TRX-001' }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <i class="material-symbols-rounded text-secondary text-sm">calendar_today</i>
                                <span class="text-sm text-secondary">Tanggal</span>
                            </div>
                            <span class="text-sm font-weight-bold text-dark">
                                {{ isset($transaksi->created_at) ? $transaksi->created_at->format('d M Y, H:i') : '07 Dec 2025, 10:30' }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <i class="material-symbols-rounded text-secondary text-sm">person</i>
                                <span class="text-sm text-secondary">Kasir</span>
                            </div>
                            <span class="text-sm font-weight-bold text-dark">{{ $transaksi->kasir->nama ?? Auth::user()->nama ?? 'Kasir' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <i class="material-symbols-rounded text-secondary text-sm">payments</i>
                                <span class="text-sm text-secondary">Metode Bayar</span>
                            </div>
                            <span class="badge bg-gradient-info text-white">{{ $transaksi->metode_pembayaran ?? 'Tunai' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="material-symbols-rounded text-secondary text-sm">check_circle</i>
                                <span class="text-sm text-secondary">Status</span>
                            </div>
                            @php
                                $status = $transaksi->status ?? 'selesai';
                                $statusColors = [
                                    'selesai' => 'success',
                                    'pending' => 'warning',
                                    'dibatalkan' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-gradient-{{ $statusColors[$status] ?? 'secondary' }} text-white text-capitalize">
                                {{ $status }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Items & Summary Card -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="material-symbols-rounded text-primary">shopping_basket</i>
                                Daftar Item
                            </h6>
                            <p class="text-xs text-secondary mb-0">Produk yang dibeli dalam transaksi ini</p>
                        </div>
                        @if(isset($transaksi->items))
                        <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill">
                            {{ $transaksi->items->count() }} Item
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Produk</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                    <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi->items ?? [] as $item)
                                @php
                                    $subtotal = $item->jumlah * $item->harga_satuan;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="icon-shape bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                                <i class="material-symbols-rounded text-primary">medication</i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $item->obat->nama_obat ?? 'Nama Obat' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $item->obat->kode_obat ?? 'KODE' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark font-weight-bold px-3 py-2">{{ $item->jumlah }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-sm text-secondary">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="material-symbols-rounded text-secondary opacity-5 mb-2" style="font-size: 48px;">inventory_2</i>
                                            <p class="text-secondary mb-0">Tidak ada item</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Section -->
                    <div class="bg-gray-100 p-4 mt-3">
                        @php
                            $total = isset($transaksi->items) ? $transaksi->items->sum(function($item) {
                                return $item->jumlah * $item->harga_satuan;
                            }) : ($transaksi->total ?? 0);
                            $bayar = $transaksi->jumlah_bayar ?? $total;
                            $kembalian = $bayar - $total;
                        @endphp
                        <div class="row justify-content-end">
                            <div class="col-lg-5">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-sm text-secondary">Subtotal</span>
                                    <span class="text-sm font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-sm text-secondary">Diskon</span>
                                    <span class="text-sm font-weight-bold text-danger">- Rp {{ number_format($transaksi->diskon ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-md font-weight-bold text-dark">Total</span>
                                    <span class="text-md font-weight-bolder text-primary">Rp {{ number_format($total - ($transaksi->diskon ?? 0), 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-sm text-secondary">Dibayar</span>
                                    <span class="text-sm font-weight-bold">Rp {{ number_format($bayar, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm text-secondary">Kembalian</span>
                                    <span class="text-sm font-weight-bold text-success">Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, nav, .sidebar, .navbar { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
    }
    .border-radius-top-start-lg { border-top-left-radius: 0.75rem !important; }
    .border-radius-top-end-lg { border-top-right-radius: 0.75rem !important; }
</style>
@endsection
