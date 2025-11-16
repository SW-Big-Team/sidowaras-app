@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Detail Pembelian')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fas fa-search-dollar"></i> Detail Pembelian</h4>
        <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0">Informasi Utama</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <tr>
                    <th style="width: 25%;">No Faktur</th>
                    <td>{{ $pembelian->no_faktur }}</td>
                </tr>
                <tr>
                    <th>Nama Pengirim</th>
                    <td>{{ $pembelian->nama_pengirim }}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{ $pembelian->no_telepon_pengirim ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    {{-- MODIFIKASI: Beri badge --}}
                    <td>
                        @if($pembelian->metode_pembayaran == 'tunai')
                            <span class="badge bg-success">{{ ucfirst($pembelian->metode_pembayaran) }}</span>
                        @elseif($pembelian->metode_pembayaran == 'non tunai')
                            <span class="badge bg-primary">{{ ucfirst($pembelian->metode_pembayaran) }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ ucfirst($pembelian->metode_pembayaran) }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td class="fw-bold text-success">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembelian</th>
                    <td>{{ $pembelian->tgl_pembelian->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Dibuat oleh</th>
                    <td>{{ $pembelian->user->nama_lengkap ?? $pembelian->user->name ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    {{-- BARU: Tampilkan Detail Obat (stokBatches) --}}
    <div class="card shadow-sm mb-3">
         <div class="card-header bg-success text-white py-2">
            <h6 class="mb-0"><i class="fas fa-pills"></i> Detail Item Obat</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr class="text-center small">
                        <th>Obat</th>
                        <th>Harga Beli</th>
                        <th>Jumlah Masuk</th>
                        <th>Subtotal</th>
                        <th>Tgl. Kadaluarsa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelian->stokBatches as $batch)
                    <tr class="small">
                        <td>{{ $batch->obat->nama_obat ?? 'Obat Dihapus' }}</td>
                        <td class="text-end">Rp {{ number_format($batch->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $batch->jumlah_masuk }}</td>
                        <td class="text-end fw-bold">Rp {{ number_format($batch->harga_beli * $batch->jumlah_masuk, 0, ',', '.') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($batch->tgl_kadaluarsa)->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada item obat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- BARU: Tampilkan Detail Termin --}}
    @if($pembelian->metode_pembayaran == 'termin')
    <div class="card shadow-sm mb-3">
         <div class="card-header bg-warning py-2">
            <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Detail Pembayaran Termin</h6>
        </div>
        <div class="card-body p-0">
            @if($pembelian->pembayaranTermin->isNotEmpty())
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr class="text-center small">
                            <th>Termin Ke-</th>
                            <th>Jumlah Bayar</th>
                            <th>Tgl. Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian->pembayaranTermin as $termin)
                            <tr class="small">
                                <td class="text-center">{{ $termin->termin_ke }}</td>
                                <td class="text-end">Rp {{ number_format($termin->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $termin->tgl_jatuh_tempo->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($termin->status == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Belum Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-3 text-center">
                    <p class="mb-0">Tidak ada data termin untuk pembelian ini.</p>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection