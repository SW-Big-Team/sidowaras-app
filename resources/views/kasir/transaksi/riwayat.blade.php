@extends('layouts.kasir.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                    <p class="text-sm text-muted">Daftar transaksi penjualan yang telah disetujui</p>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Kasir</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $t)
                                    <tr>
                                        <td>{{ $t->no_transaksi }}</td>
                                        <td>{{ $t->user->nama_lengkap }}</td>
                                        <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($t->tgl_transaksi)->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('kasir.transaksi.show', $t) }}" class="btn btn-sm btn-info">
                                                <i class="material-symbols-rounded text-sm">visibility</i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Belum ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $transaksis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection