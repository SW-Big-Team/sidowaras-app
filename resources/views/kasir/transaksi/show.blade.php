@extends('layouts.kasir.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-dark text-white text-center">
                    <h5>Detail Transaksi</h5>
                </div>
                <div class="card-body">
                    <p><strong>No Transaksi:</strong> {{ $transaksi->no_transaksi }}</p>
                    <p><strong>Tanggal:</strong> {{ $transaksi->tgl_transaksi->format('d M Y H:i') }}</p>
                    <p><strong>Metode Pembayaran:</strong> 
                        @if($transaksi->metode_pembayaran === 'tunai')
                            <span class="badge bg-gradient-success">Tunai</span>
                        @else
                            <span class="badge bg-gradient-info">Non Tunai</span>
                        @endif
                    </p>
                    @if($transaksi->metode_pembayaran === 'tunai')
                        <p><strong>Total Bayar:</strong> Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
                        <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
                    @endif
                    <hr>
                    <h6>Daftar Item:</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>Batch</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail as $item)
                                <tr>
                                    <td>{{ $item->batch->obat->nama_obat }}</td>
                                    <td>{{ $item->batch->no_batch }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-end mt-3">
                        <a href="{{ route('kasir.transaksi.riwayat') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection