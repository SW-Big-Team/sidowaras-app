@extends('layouts.karyawan.app')

@section('title', 'Riwayat Transaksi')
@section('breadcrumb', 'Dashboard / Riwayat Transaksi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Transaksi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Metode</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $transaksi)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $transaksi->no_transaksi }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $transaksi->created_at->format('d M Y H:i') }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-sm bg-gradient-{{ $transaksi->metode_pembayaran == 'tunai' ? 'success' : 'info' }}">
                                        {{ ucfirst($transaksi->metode_pembayaran) }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('karyawan.transaksi.show', $transaksi->id) }}" class="btn btn-link text-secondary mb-0">
                                        <i class="material-symbols-rounded text-sm">visibility</i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
