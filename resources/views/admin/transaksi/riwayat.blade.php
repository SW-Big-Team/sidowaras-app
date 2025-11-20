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
            <div class="card bg-gradient-dark border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">receipt_long</i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-white font-weight-bolder">Riwayat Transaksi</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Daftar transaksi yang telah diproses</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <div class="text-white opacity-8">
                                <i class="material-symbols-rounded align-middle">info</i>
                                <span class="text-sm ms-1">Total: {{ $transaksis->total() }} transaksi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Summary Cards - Clean Design -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Transaksi</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $transaksis->total() }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                                        <i class="material-symbols-rounded opacity-10 text-white">receipt</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pendapatan</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            <small class="text-xs">Rp</small> {{ number_format($transaksis->sum('total_harga') / 1000, 0, ',', '.') }}K
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                        <i class="material-symbols-rounded opacity-10 text-white">payments</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Pembayaran Tunai</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $transaksis->where('metode_pembayaran', 'tunai')->count() }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                        <i class="material-symbols-rounded opacity-10 text-white">monetization_on</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Non Tunai</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $transaksis->where('metode_pembayaran', 'non_tunai')->count() }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                        <i class="material-symbols-rounded opacity-10 text-white">credit_card</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center">
                        <i class="material-symbols-rounded me-2">filter_alt</i>
                        <h6 class="mb-0">Filter Transaksi</h6>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Dari</label>
                            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Sampai</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Metode Pembayaran</label>
                            <select name="metode" class="form-control">
                                <option value="">Semua</option>
                                <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                <option value="non_tunai" {{ request('metode') == 'non_tunai' ? 'selected' : '' }}>Non Tunai</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn bg-gradient-dark mb-0 w-100">
                                    <i class="material-symbols-rounded align-middle" style="font-size: 1rem;">search</i> Filter
                                </button>
                                <a href="{{ route('admin.transaksi.riwayat') }}" class="btn btn-outline-secondary mb-0">
                                    <i class="material-symbols-rounded" style="font-size: 1rem;">refresh</i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">#</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">No Transaksi</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Kasir</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-end">Total Harga</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Metode</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Tanggal</th>
                                    <th class="text-white opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $index => $t)
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $transaksis->firstItem() + $index }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center px-2 py-1">
                                                <div class="icon icon-sm icon-shape bg-gradient-dark shadow-dark text-center border-radius-md me-2">
                                                    <i class="material-symbols-rounded opacity-10 text-white text-sm">receipt</i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $t->no_transaksi }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-sm font-weight-bold">{{ $t->user->nama_lengkap }}</span>
                                                <span class="text-xs text-secondary">{{ $t->user->role->nama_role }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-sm font-weight-bold text-dark">
                                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($t->metode_pembayaran === 'tunai')
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-money-bill-wave text-warning text-sm me-2"></i>
                                                    <span class="text-xs font-weight-bold">Tunai</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-credit-card text-info text-sm me-2"></i>
                                                    <span class="text-xs font-weight-bold">Non Tunai</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">{{ $t->tgl_transaksi->format('d M Y') }}</p>
                                            <p class="text-xxs text-secondary mb-0">{{ $t->tgl_transaksi->format('H:i') }} WIB</p>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.transaksi.show', $t->id) }}" 
                                               class="btn btn-link text-dark font-weight-bold text-xs p-0 mb-0" 
                                               data-bs-toggle="tooltip" 
                                               title="Lihat Detail">
                                                Detail <i class="fas fa-chevron-right text-xs ms-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-gray-100 shadow-none rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5 text-3xl">receipt_long</i>
                                                </div>
                                                <h6 class="text-secondary font-weight-normal">Belum ada transaksi</h6>
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
                        <div class="d-flex justify-content-end">
                            {{ $transaksis->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection