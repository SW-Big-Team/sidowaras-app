@extends('layouts.admin.app')
@section('title', 'Riwayat Transaksi')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Transaksi</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Riwayat Transaksi</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show text-white" role="alert">
                    <span class="alert-icon align-middle">
                      <i class="material-symbols-rounded text-md">warning</i>
                    </span>
                    <span class="alert-text"><strong>Perhatian!</strong> {{ session('warning') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">receipt_long</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Riwayat Transaksi</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Daftar transaksi yang telah diproses</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <div class="text-white opacity-8 d-flex align-items-center justify-content-end">
                                    <i class="material-symbols-rounded align-middle me-1">info</i>
                                    <span class="text-sm fw-bold">Total: {{ $transaksis->total() }} transaksi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card border-0 shadow-sm rounded-3 summary-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                        Total Transaksi
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">{{ $transaksis->total() }}</h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Seluruh transaksi tercatat</p>
                                </div>
                                <div class="summary-icon bg-soft-dark">
                                    <i class="material-symbols-rounded text-dark">receipt</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card border-0 shadow-sm rounded-3 summary-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                        Total Pendapatan
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">
                                        <small class="text-xs">Rp</small> {{ number_format($transaksis->sum('total_harga') / 1000, 0, ',', '.') }}K
                                    </h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Estimasi pendapatan</p>
                                </div>
                                <div class="summary-icon bg-soft-success">
                                    <i class="material-symbols-rounded text-success">payments</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card border-0 shadow-sm rounded-3 summary-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                        Pembayaran Tunai
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">
                                        {{ $transaksis->where('metode_pembayaran', 'tunai')->count() }}
                                    </h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Transaksi cash</p>
                                </div>
                                <div class="summary-icon bg-soft-warning">
                                    <i class="material-symbols-rounded text-warning">monetization_on</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-3 summary-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                        Non Tunai
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">
                                        {{ $transaksis->where('metode_pembayaran', 'non_tunai')->count() }}
                                    </h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Transaksi cashless</p>
                                </div>
                                <div class="summary-icon bg-soft-info">
                                    <i class="material-symbols-rounded text-info">credit_card</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center">
                        <i class="material-symbols-rounded me-2 text-primary">filter_alt</i>
                        <h6 class="mb-0 fw-bold">Filter Transaksi</h6>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal Dari</label>
                            <input type="date" name="from" value="{{ $from }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal Sampai</label>
                            <input type="date" name="to" value="{{ $to }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Metode Pembayaran</label>
                            <select name="metode" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <option value="tunai" {{ $metode == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                <option value="non_tunai" {{ $metode == 'non_tunai' ? 'selected' : '' }}>Non Tunai</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn bg-gradient-dark btn-sm mb-0 w-100 d-flex align-items-center justify-content-center gap-1">
                                    <i class="material-symbols-rounded text-sm">search</i> Filter
                                </button>
                                <a href="{{ route('admin.transaksi.riwayat') }}" class="btn btn-outline-secondary btn-sm mb-0 d-flex align-items-center justify-content-center" title="Reset">
                                    <i class="material-symbols-rounded text-sm">refresh</i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">#</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">No Transaksi</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Kasir</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-end">Total Harga</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2 text-center">Metode</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2 text-center">Tanggal</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $index => $t)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0 text-secondary">{{ $transaksis->firstItem() + $index }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center px-2 py-1">
                                                <div class="icon icon-sm icon-shape bg-gradient-dark shadow-sm text-center border-radius-md me-2">
                                                    <i class="material-symbols-rounded opacity-10 text-white text-xs">receipt</i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs fw-bold text-dark">{{ $t->no_transaksi }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-xs font-weight-bold text-dark">{{ $t->user->nama_lengkap }}</span>
                                                <span class="text-xxs text-secondary">{{ $t->user->role->nama_role }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-sm font-weight-bold text-dark">
                                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($t->metode_pembayaran === 'tunai')
                                                <span class="badge badge-sm bg-soft-warning text-warning d-inline-flex align-items-center gap-1">
                                                    <i class="material-symbols-rounded text-xs">payments</i>
                                                    <span>Tunai</span>
                                                </span>
                                            @else
                                                <span class="badge badge-sm bg-soft-info text-info d-inline-flex align-items-center gap-1">
                                                    <i class="material-symbols-rounded text-xs">credit_card</i>
                                                    <span>Non Tunai</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0 text-dark">{{ $t->tgl_transaksi->format('d M Y') }}</p>
                                            <p class="text-xxs text-secondary mb-0">{{ $t->tgl_transaksi->format('H:i') }} WIB</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.transaksi.show', $t->id) }}" 
                                               class="btn btn-link text-info text-gradient px-1 mb-0" 
                                               title="Lihat Detail">
                                                <i class="material-symbols-rounded text-sm me-1">visibility</i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">receipt_long</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada transaksi</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($transaksis->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <p class="text-xs text-secondary mb-0">
                                Menampilkan <span class="fw-bold">{{ $transaksis->firstItem() ?? 0 }}</span> - <span class="fw-bold">{{ $transaksis->lastItem() ?? 0 }}</span> dari <span class="fw-bold">{{ $transaksis->total() }}</span> data
                            </p>
                            {{ $transaksis->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .text-xxs { font-size: 0.65rem !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }

    .summary-card {
        transition: all 0.2s ease-in-out;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.07) !important;
    }
    .summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
    .bg-soft-danger  { background: rgba(220, 53, 69, 0.10) !important; }
    .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
    .bg-soft-secondary { background: rgba(108, 117, 125, 0.08) !important; }
    .bg-soft-info { background: rgba(23, 162, 184, 0.12) !important; }
    .bg-soft-dark { background: rgba(52, 71, 103, 0.15) !important; }

    .bg-gradient-info-soft {
        background: linear-gradient(135deg, rgba(23, 162, 184, .08), rgba(23, 162, 184, .16));
    }

    .table-stok thead tr th {
        border-top: none;
        font-weight: 600;
        letter-spacing: .04em;
    }

    .table-stok tbody tr {
        transition: background-color 0.15s ease, box-shadow 0.15s ease;
    }
    .table-stok tbody tr:hover {
        background-color: #f8f9fe;
    }

    .table td, .table th { vertical-align: middle; }
</style>
@endsection