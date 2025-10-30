@extends('layouts.kasir.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent">
<<<<<<< HEAD
<<<<<<< HEAD
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                    <p class="text-sm text-muted">Daftar transaksi penjualan yang telah disetujui</p>
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
                    <h5 class="mb-0">Riwayat Transaksi Saya</h5>
                    <p class="text-sm text-muted mb-0">Daftar transaksi yang telah saya proses</p>
=======
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                    <p class="text-sm text-muted">Daftar transaksi penjualan yang telah disetujui</p>
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                    <p class="text-sm text-muted">Daftar transaksi penjualan yang telah disetujui</p>
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Kasir</th>
                                    <th>Total Harga</th>
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
                                    <th>Metode</th>
=======
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $t)
                                    <tr>
                                        <td>{{ $t->no_transaksi }}</td>
<<<<<<< HEAD
<<<<<<< HEAD
                                        <td>{{ $t->user->nama_lengkap }}</td>
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
                                        <td>
                                            {{ $t->user->nama_lengkap }}<br>
                                            <small class="text-muted">{{ $t->user->role->nama_role }}</small>
                                        </td>
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
                                        <td>{{ $t->user->nama_lengkap }}</td>
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                                        <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($t->tgl_transaksi)->format('d M Y H:i') }}</td>
                                        <td>
<<<<<<< HEAD
<<<<<<< HEAD
                                            <a href="{{ route('kasir.transaksi.show', $t) }}" class="btn btn-sm btn-info">
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                                            @if($t->metode_pembayaran === 'tunai')
                                                <span class="badge bg-gradient-success">Tunai</span>
                                            @else
                                                <span class="badge bg-gradient-info">Non Tunai</span>
                                            @endif
                                        </td>
                                        <td>{{ $t->tgl_transaksi->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('kasir.transaksi.show', $t->id) }}" class="btn btn-sm btn-info">
=======
                                        <td>{{ $t->user->nama_lengkap }}</td>
                                        <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($t->tgl_transaksi)->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('kasir.transaksi.show', $t) }}" class="btn btn-sm btn-info">
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
                                            <a href="{{ route('kasir.transaksi.show', $t) }}" class="btn btn-sm btn-info">
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
                                                <i class="material-symbols-rounded text-sm">visibility</i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
<<<<<<< HEAD
<<<<<<< HEAD
                                        <td colspan="5" class="text-center py-4">Belum ada transaksi</td>
=======
=======
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
                                        <td colspan="6" class="text-center py-4">Belum ada transaksi</td>
=======
                                        <td colspan="5" class="text-center py-4">Belum ada transaksi</td>
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
<<<<<<< HEAD
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
=======
=======
                                        <td colspan="5" class="text-center py-4">Belum ada transaksi</td>
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
>>>>>>> 476bacf (Add Cart functionality and update Bootstrap version)
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