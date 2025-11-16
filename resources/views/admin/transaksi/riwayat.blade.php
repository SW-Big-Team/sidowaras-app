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
    <x-content-header title="Riwayat Transaksi" subtitle="Daftar transaksi yang telah diproses">
        <a href="{{ route('admin.transaksi.create') }}" class="btn bg-gradient-primary mb-0">
            <i class="material-symbols-rounded text-sm me-1">add_circle</i> Transaksi Baru
        </a>
    </x-content-header>

    <div class="row">
        <div class="col-12">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">receipt_long</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Transaksi</p>
                                <h4 class="mb-0">{{ $transaksis->total() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">payments</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Pendapatan</p>
                                <h4 class="mb-0">Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">credit_card</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Non Tunai</p>
                                <h4 class="mb-0">{{ $transaksis->where('metode_pembayaran', 'non_tunai')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">monetization_on</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Tunai</p>
                                <h4 class="mb-0">{{ $transaksis->where('metode_pembayaran', 'tunai')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body p-3">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Dari</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Sampai</label>
                            <div class="input-group input-group-outline">
                                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Metode Pembayaran</label>
                            <div class="input-group input-group-outline">
                                <select name="metode" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                    <option value="non_tunai" {{ request('metode') == 'non_tunai' ? 'selected' : '' }}>Non Tunai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary mb-0 w-100">
                                    <i class="material-symbols-rounded me-1">filter_alt</i> Filter
                                </button>
                                <a href="{{ route('admin.transaksi.riwayat') }}" class="btn btn-outline-secondary mb-0">
                                    <i class="material-symbols-rounded">refresh</i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <x-data-table :headers="['#', 'No Transaksi', 'Kasir', 'Total Harga', 'Metode', 'Tanggal', 'Aksi']">
                @forelse($transaksis as $index => $t)
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{ $transaksis->firstItem() + $index }}</p>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
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
                        <td>
                            <span class="badge badge-sm bg-gradient-success">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            @if($t->metode_pembayaran === 'tunai')
                                <span class="badge badge-sm bg-gradient-warning">
                                    <i class="material-symbols-rounded text-xs">monetization_on</i> Tunai
                                </span>
                            @else
                                <span class="badge badge-sm bg-gradient-info">
                                    <i class="material-symbols-rounded text-xs">credit_card</i> Non Tunai
                                </span>
                            @endif
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $t->tgl_transaksi->format('d M Y H:i') }}</p>
                        </td>
                        <td>
                            <a href="{{ route('admin.transaksi.show', $t->id) }}" 
                               class="btn btn-link text-info px-3 mb-0"
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="Lihat Detail">
                                <i class="material-symbols-rounded text-sm">visibility</i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">receipt_long</i>
                            <p class="text-secondary mb-0">Belum ada transaksi</p>
                        </td>
                    </tr>
                @endforelse
            </x-data-table>

            <div class="mt-3">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection