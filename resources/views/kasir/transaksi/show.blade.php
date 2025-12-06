@extends('layouts.kasir.app')

@section('page_title', 'Riwayat Transaksi')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-0 px-0">
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="{{ route('kasir.dashboard') }}">
                                    <i class="material-symbols-rounded text-sm">home</i>
                                </a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Riwayat Transaksi</li>
                        </ol>
                    </nav>
                    <h4 class="font-weight-bolder text-dark mb-0">Riwayat Transaksi</h4>
                    <p class="text-sm text-secondary mb-0">Kelola dan pantau semua transaksi penjualan</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm mb-0 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="material-symbols-rounded text-sm">filter_list</i>
                        Filter
                    </button>
                    <button class="btn btn-dark btn-sm mb-0 d-flex align-items-center gap-2" onclick="exportData()">
                        <i class="material-symbols-rounded text-sm">download</i>
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Total Transaksi</p>
                                <h5 class="font-weight-bolder mb-0 text-dark">
                                    {{ $totalTransaksi ?? 156 }}
                                </h5>
                                <span class="text-success text-xs font-weight-bold">
                                    <i class="material-symbols-rounded text-xs">trending_up</i> +12%
                                </span>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-shape bg-gradient-primary shadow text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                <i class="material-symbols-rounded text-white">receipt_long</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Pendapatan Hari Ini</p>
                                <h5 class="font-weight-bolder mb-0 text-dark">
                                    Rp {{ number_format($pendapatanHariIni ?? 2450000, 0, ',', '.') }}
                                </h5>
                                <span class="text-success text-xs font-weight-bold">
                                    <i class="material-symbols-rounded text-xs">trending_up</i> +8%
                                </span>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-shape bg-gradient-success shadow text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                <i class="material-symbols-rounded text-white">payments</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Item Terjual</p>
                                <h5 class="font-weight-bolder mb-0 text-dark">
                                    {{ $itemTerjual ?? 423 }}
                                </h5>
                                <span class="text-success text-xs font-weight-bold">
                                    <i class="material-symbols-rounded text-xs">trending_up</i> +15%
                                </span>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-shape bg-gradient-info shadow text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                <i class="material-symbols-rounded text-white">inventory_2</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Rata-rata Transaksi</p>
                                <h5 class="font-weight-bolder mb-0 text-dark">
                                    Rp {{ number_format($rataRata ?? 157000, 0, ',', '.') }}
                                </h5>
                                <span class="text-danger text-xs font-weight-bold">
                                    <i class="material-symbols-rounded text-xs">trending_down</i> -2%
                                </span>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-shape bg-gradient-warning shadow text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; float: right;">
                                <i class="material-symbols-rounded text-white">analytics</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center text-white" role="alert">
                <i class="material-symbols-rounded me-2">check_circle</i>
                <span class="text-sm font-weight-bold">{{ session('success') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Transaction Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="material-symbols-rounded text-primary">list_alt</i>
                                Daftar Transaksi
                            </h6>
                            <p class="text-xs text-secondary mb-0">Semua transaksi yang telah diproses</p>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="input-group input-group-sm" style="max-width: 250px;">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="material-symbols-rounded text-secondary text-sm">search</i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari transaksi..." id="searchInput">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-0">
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table align-middle mb-0" id="transactionTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Kode Transaksi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kasir</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Items</th>
                                    <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis ?? [] as $transaksi)
                                <tr class="transaction-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="icon-shape bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="material-symbols-rounded text-primary text-sm">receipt</i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $transaksi->kode_transaksi }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $transaksi->metode_pembayaran ?? 'Tunai' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $transaksi->created_at->format('d M Y') }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $transaksi->created_at->format('H:i') }} WIB</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar avatar-xs rounded-circle bg-gradient-secondary d-flex align-items-center justify-content-center">
                                                <span class="text-white text-xxs">{{ substr($transaksi->kasir->nama ?? 'K', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm">{{ $transaksi->kasir->nama ?? 'Kasir' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark px-3 py-2">{{ $transaksi->items->count() ?? 0 }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($transaksi->total ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $status = $transaksi->status ?? 'selesai';
                                            $statusColors = [
                                                'selesai' => 'success',
                                                'pending' => 'warning',
                                                'dibatalkan' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-gradient-{{ $statusColors[$status] ?? 'secondary' }} text-white text-capitalize">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-link text-secondary mb-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-rounded">more_vert</i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 px-2 py-2">
                                                <li>
                                                    <a class="dropdown-item rounded-2 d-flex align-items-center gap-2 py-2" href="{{ route('kasir.transaksi.detail', $transaksi->id) }}">
                                                        <i class="material-symbols-rounded text-info text-sm">visibility</i>
                                                        <span class="text-sm">Lihat Detail</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item rounded-2 d-flex align-items-center gap-2 py-2" href="#" onclick="printReceipt({{ $transaksi->id }})">
                                                        <i class="material-symbols-rounded text-dark text-sm">print</i>
                                                        <span class="text-sm">Cetak Struk</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="icon-shape bg-gray-100 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 40px;">receipt_long</i>
                                            </div>
                                            <h6 class="text-dark font-weight-bold mb-1">Belum Ada Transaksi</h6>
                                            <p class="text-secondary text-sm mb-0">Transaksi yang selesai akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none px-3 pb-3">
                        @forelse($transaksis ?? [] as $transaksi)
                        <div class="card mb-3 border shadow-none bg-gray-100">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="icon-shape bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="material-symbols-rounded text-primary text-sm">receipt</i>
                                        </div>
                                        <div>
                                            <h6 class="text-dark font-weight-bold mb-0 text-sm">{{ $transaksi->kode_transaksi }}</h6>
                                            <span class="text-xs text-secondary">{{ $transaksi->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                    @php
                                        $status = $transaksi->status ?? 'selesai';
                                        $statusColors = [
                                            'selesai' => 'success',
                                            'pending' => 'warning',
                                            'dibatalkan' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-gradient-{{ $statusColors[$status] ?? 'secondary' }} text-white text-capitalize text-xs">
                                        {{ $status }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <p class="text-xs text-muted mb-1">{{ $transaksi->items->count() ?? 0 }} Items • {{ $transaksi->metode_pembayaran ?? 'Tunai' }}</p>
                                        <h6 class="text-primary font-weight-bold mb-0">Rp {{ number_format($transaksi->total ?? 0, 0, ',', '.') }}</h6>
                                    </div>
                                    <a href="{{ route('kasir.transaksi.detail', $transaksi->id) }}" class="btn btn-sm btn-outline-primary mb-0">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <div class="icon-shape bg-gray-200 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 40px;">receipt_long</i>
                            </div>
                            <h6 class="text-dark font-weight-bold mb-1">Belum Ada Transaksi</h6>
                            <p class="text-secondary text-sm mb-0">Transaksi akan muncul di sini</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if(isset($transaksis) && $transaksis->hasPages())
                    <div class="px-4 py-3 border-top">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                            <p class="text-sm text-secondary mb-0">
                                Menampilkan {{ $transaksis->firstItem() }} - {{ $transaksis->lastItem() }} dari {{ $transaksis->total() }} transaksi
                            </p>
                            {{ $transaksis->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold d-flex align-items-center gap-2" id="filterModalLabel">
                    <i class="material-symbols-rounded text-primary">filter_list</i> Filter Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kasir.transaksi.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-uppercase text-muted">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-uppercase text-muted">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-uppercase text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1 mb-0">Terapkan Filter</button>
                        <a href="{{ route('kasir.transaksi.index') }}" class="btn btn-outline-secondary mb-0">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.transaction-row');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Print receipt function
    function printReceipt(id) {
        window.open(`/kasir/transaksi/${id}/print`, '_blank', 'width=400,height=600');
    }

    // Export data function
    function exportData() {
        window.location.href = '{{ route("kasir.transaksi.index") }}?export=true';
    }
</script>
@endpush

@endsection