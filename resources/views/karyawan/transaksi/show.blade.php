@extends('layouts.karyawan.app')

@section('title', 'Detail Transaksi')
@section('breadcrumb', 'Dashboard / Riwayat / Detail')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Transaksi: {{ $transaksi->no_transaksi }}</h5>
                    <a href="{{ route('karyawan.transaksi.index') }}" class="btn btn-outline-secondary btn-sm mb-0">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-6">
                            <h6 class="text-sm mb-1">Tanggal</h6>
                            <p class="text-sm font-weight-bold">{{ $transaksi->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="text-sm mb-1">Metode Pembayaran</h6>
                            <span class="badge bg-gradient-{{ $transaksi->metode_pembayaran == 'tunai' ? 'success' : 'info' }}">
                                {{ ucfirst($transaksi->metode_pembayaran) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Qty</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->detail as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->batch->obat->nama_obat ?? 'Unknown' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $item->batch->kode_batch ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->jumlah }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><h6 class="mb-0">Total</h6></td>
                                    <td class="text-end"><h6 class="mb-0">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</h6></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
