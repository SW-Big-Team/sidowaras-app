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


    {{-- Notifikasi Sukses/Error dari Aksi Pembayaran --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Card Informasi Utama --}}
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
   
    {{-- Card Detail Item Obat --}}
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


    {{-- PERBAIKAN: Tampilkan Detail Termin & Form Pembayaran --}}
    @if($pembelian->metode_pembayaran == 'termin')
    @php
        $total_terbayar = $pembelian->pembayaranTermin->sum('jumlah_bayar');
        $sisa_utang = $pembelian->total_harga - $total_terbayar;
    @endphp
    <div class="card shadow-sm mb-3">
         <div class="card-header bg-warning py-2 d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Detail Pembayaran Termin</h6>
           
            {{-- Tombol untuk memicu Modal Pembayaran --}}
            @if($sisa_utang > 0.01)
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalBayarTermin">
                    <i class="fas fa-dollar-sign"></i> Bayar Cicilan
                </button>
            @endif
        </div>
        <div class="card-body p-0">
            @if($pembelian->pembayaranTermin->isNotEmpty())
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr class="text-center small">
                            <th>Termin Ke-</th>
                            <th>Total Dibayar</th>
                            <th>Tgl. Jatuh Tempo</th>
                            <th>Tgl. Bayar Terakhir</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian->pembayaranTermin->sortBy('termin_ke') as $termin)
                            <tr class="small">
                                <td class="text-center">{{ $termin->termin_ke }}</td>
                                <td class="text-end">Rp {{ number_format($termin->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $termin->tgl_jatuh_tempo->format('d M Y') }}</td>
                                <td class="text-center">{{ $termin->tgl_bayar ? \Carbon\Carbon::parse($termin->tgl_bayar)->format('d M Y') : '-' }}</td>
                                <td class="text-center">
                                    @if($termin->status == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Tampilkan riwayat pembayaran --}}
                                    <pre style="font-size: 0.8em; white-space: pre-wrap; margin-bottom: 0;">{{ $termin->keterangan }}</pre>
                                </td>
                            </tr>
                        @endforeach
                       
                        {{-- Ringkasan Total --}}
                        <tr class="table-group-divider">
                            <td colspan="1" class="text-end fw-bold">TOTAL DIBAYAR:</td>
                            <td colspan="5" class="text-end fw-bold text-success">Rp {{ number_format($total_terbayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="1" class="text-end fw-bold">SISA UTANG:</td>
                            <td colspan="5" class="text-end fw-bold text-danger">Rp {{ number_format($sisa_utang, 0, ',', '.') }}</td>
                        </tr>
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


{{-- BARU: Modal untuk Pembayaran Termin --}}
@if($pembelian->metode_pembayaran == 'termin' && $sisa_utang > 0.01)
<div class="modal fade" id="modalBayarTermin" tabindex="-1" aria-labelledby="modalBayarTerminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBayarTerminLabel">Bayar Cicilan Termin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Form menunjuk ke route baru 'pembelian.bayarTermin' --}}
            <form action="{{ route('pembelian.bayarTermin', $pembelian->uuid) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sisa Utang</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($sisa_utang, 0, ',', '.') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tgl_bayar" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control"
                            placeholder="Maks: Rp {{ number_format($sisa_utang, 0, ',', '.') }}"
                            max="{{ $sisa_utang }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Misal: Transfer Bank ABC">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
