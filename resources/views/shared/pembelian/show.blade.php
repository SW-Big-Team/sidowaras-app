@php
    $role = Auth::user()->role->nama_role;
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Detail Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('pembelian.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Pembelian</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">receipt_long</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Detail Pembelian</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">
                                        Informasi lengkap faktur, item obat, dan status pembayaran.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <a href="{{ route('pembelian.index') }}" class="btn bg-white mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                <i class="material-symbols-rounded align-middle">arrow_back</i>
                                <span>Kembali</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
            <span class="alert-text"><strong>Sukses!</strong> {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
            <span class="alert-text"><strong>Error!</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        {{-- Informasi Utama --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0">
                    <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-symbols-rounded text-primary">info</i>
                        Informasi Utama
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="ps-0 text-sm text-secondary font-weight-bold" style="width: 200px;">No Faktur</td>
                                    <td class="text-sm text-dark font-weight-bold">{{ $pembelian->no_faktur }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-0 text-sm text-secondary font-weight-bold">Nama Pengirim</td>
                                    <td class="text-sm text-dark">{{ $pembelian->nama_pengirim }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-0 text-sm text-secondary font-weight-bold">No Telepon</td>
                                    <td class="text-sm text-dark">{{ $pembelian->no_telepon_pengirim ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-0 text-sm text-secondary font-weight-bold">Metode Pembayaran</td>
                                    <td>
                                        @if($pembelian->metode_pembayaran == 'tunai')
                                            <span class="badge badge-sm bg-soft-success text-success">Tunai</span>
                                        @elseif($pembelian->metode_pembayaran == 'non tunai')
                                            <span class="badge badge-sm bg-soft-primary text-primary">Non Tunai</span>
                                        @else
                                            <span class="badge badge-sm bg-soft-warning text-warning">Termin</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-0 text-sm text-secondary font-weight-bold">Total Harga</td>
                                    <td class="text-sm fw-bold text-success">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-0 text-sm text-secondary font-weight-bold">Tanggal Pembelian</td>
                                    <td class="text-sm text-dark">{{ $pembelian->tgl_pembelian->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-0 text-sm text-secondary font-weight-bold">Dibuat oleh</td>
                                    <td class="text-sm text-dark">{{ $pembelian->user->nama_lengkap ?? $pembelian->user->name ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Item Obat --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0">
                    <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-symbols-rounded text-success">medication</i>
                        Detail Item Obat
                    </h6>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Obat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Harga Beli</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Jumlah</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Subtotal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Kadaluarsa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembelian->stokBatches as $batch)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-sm font-weight-bold mb-0 text-dark">{{ $batch->obat->nama_obat ?? 'Obat Dihapus' }}</p>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-sm text-secondary">Rp {{ number_format($batch->harga_beli, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-sm text-dark font-weight-bold">{{ $batch->jumlah_masuk }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-sm fw-bold text-dark">Rp {{ number_format($batch->harga_beli * $batch->jumlah_masuk, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-xs font-weight-bold text-secondary">{{ \Carbon\Carbon::parse($batch->tgl_kadaluarsa)->format('d M Y') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">Tidak ada item obat.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Pembayaran Termin --}}
        @if($pembelian->metode_pembayaran == 'termin')
        @php
            $total_terbayar = $pembelian->pembayaranTermin->sum('jumlah_bayar');
            $sisa_utang = $pembelian->total_harga - $total_terbayar;
        @endphp
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="material-symbols-rounded text-warning">payments</i>
                        Detail Pembayaran Termin
                    </h6>
                    @if($sisa_utang > 0.01)
                        <button type="button" class="btn btn-sm bg-gradient-success mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalBayarTermin">
                            <i class="material-symbols-rounded text-sm">attach_money</i> Bayar Cicilan
                        </button>
                    @endif
                </div>
                <div class="card-body px-0 pb-2">
                    @if($pembelian->pembayaranTermin->isNotEmpty())
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 table-stok">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4 text-center">Termin Ke</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Total Dibayar</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Jatuh Tempo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Tgl Bayar</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pembelian->pembayaranTermin->sortBy('termin_ke') as $termin)
                                        <tr>
                                            <td class="text-center ps-4">
                                                <span class="text-sm font-weight-bold text-dark">{{ $termin->termin_ke }}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-sm text-dark">Rp {{ number_format($termin->jumlah_bayar, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-xs font-weight-bold text-secondary">{{ $termin->tgl_jatuh_tempo->format('d M Y') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-xs font-weight-bold text-secondary">{{ $termin->tgl_bayar ? \Carbon\Carbon::parse($termin->tgl_bayar)->format('d M Y') : '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($termin->status == 'lunas')
                                                    <span class="badge badge-sm bg-soft-success text-success">Lunas</span>
                                                @else
                                                    <span class="badge badge-sm bg-soft-danger text-danger">Belum Lunas</span>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 150px;">{{ $termin->keterangan ?? '-' }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-light">
                                        <td colspan="1" class="text-end fw-bold ps-4 text-sm">TOTAL DIBAYAR:</td>
                                        <td class="text-end fw-bold text-success text-sm">Rp {{ number_format($total_terbayar, 0, ',', '.') }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="1" class="text-end fw-bold ps-4 text-sm">SISA UTANG:</td>
                                        <td class="text-end fw-bold text-danger text-sm">Rp {{ number_format($sisa_utang, 0, ',', '.') }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center">
                            <p class="text-sm text-secondary mb-0">Tidak ada data termin untuk pembelian ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Pembayaran Termin --}}
@if($pembelian->metode_pembayaran == 'termin' && $sisa_utang > 0.01)
<div class="modal fade" id="modalBayarTermin" tabindex="-1" aria-labelledby="modalBayarTerminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <div class="modal-header bg-white border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold" id="modalBayarTerminLabel">Bayar Cicilan Termin</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pembelian.bayarTermin', $pembelian->uuid) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Sisa Utang</label>
                        <input type="text" class="form-control bg-light fw-bold text-danger" value="Rp {{ number_format($sisa_utang, 0, ',', '.') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal Bayar</label>
                        <input type="date" name="tgl_bayar" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control"
                            placeholder="Maks: Rp {{ number_format($sisa_utang, 0, ',', '.') }}"
                            max="{{ $sisa_utang }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Keterangan (Opsional)</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Misal: Transfer Bank ABC">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn bg-gradient-light mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
    .text-xxs { font-size: 0.65rem !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
    .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
    .bg-soft-danger  { background: rgba(220, 53, 69, 0.10) !important; }
    .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
    .bg-soft-secondary { background: rgba(108, 117, 125, 0.08) !important; }
    .table-stok thead tr th { border-top: none; font-weight: 600; letter-spacing: .04em; }
    .table-stok tbody tr { transition: background-color 0.15s ease; }
    .table-stok tbody tr:hover { background-color: #f8f9fe; }
    .table td, .table th { vertical-align: middle; }
</style>
@endsection
