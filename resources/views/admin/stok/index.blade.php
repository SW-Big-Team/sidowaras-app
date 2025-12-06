@php
    $layoutPath = 'layouts.admin.app';
@endphp

@extends($layoutPath)
@section('title', 'Daftar Stok')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Stok</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Stok</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">inventory_2</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Daftar Stok Obat</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Monitoring persediaan dan status stok obat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <a href="{{ route('pembelian.index') }}" class="btn btn-outline-white mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                    <i class="material-symbols-rounded align-middle">shopping_cart</i>
                                    <span>Pembelian</span>
                                </a>
                                <a href="{{ route('admin.obat.create') }}" class="btn bg-white text-dark mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                    <i class="material-symbols-rounded align-middle">add_circle</i>
                                    <span>Tambah Obat</span>
                                </a>
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
                                        Total Item
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">{{ $obats->total() }}</h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Seluruh item obat terdaftar</p>
                                </div>
                                <div class="summary-icon bg-soft-success">
                                    <i class="material-symbols-rounded text-success">inventory_2</i>
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
                                        Stok Rendah
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">
                                        {{ $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') <= $o->stok_minimum)->count() }}
                                    </h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Perlu tindakan restock</p>
                                </div>
                                <div class="summary-icon bg-soft-warning">
                                    <i class="material-symbols-rounded text-warning">warning</i>
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
                                        Exp &lt; 30 Hari
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">
                                        {{ $obats->filter(fn($o) => $o->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty())->count() }}
                                    </h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Butuh pengecekan segera</p>
                                </div>
                                <div class="summary-icon bg-soft-danger">
                                    <i class="material-symbols-rounded text-danger">event_busy</i>
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
                                        Stok Aman
                                    </p>
                                    <h4 class="mb-0 text-dark fw-bold">
                                        {{ $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') > $o->stok_minimum)->count() }}
                                    </h4>
                                    <p class="mb-0 text-xxs text-muted mt-1">Kondisi stok relatif stabil</p>
                                </div>
                                <div class="summary-icon bg-soft-primary">
                                    <i class="material-symbols-rounded text-primary">check_circle</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0 fw-bold">Data Stok Obat</h6>
                                <span class="text-xs text-secondary">
                                    {{ $obats->total() }} record ditemukan
                                </span>
                            </div>
                        </div>
                        {{-- Filter & Search UI - Inline Layout --}}
                        <div class="d-flex align-items-center gap-2">
                            <form action="{{ route('stok.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-nowrap" id="filterForm">
                                {{-- Status Filter with Icon --}}
                                <div class="input-group" style="width: auto;">
                                    <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                                        <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">filter_list</i>
                                    </span>
                                    <select name="status" class="form-control form-select-sm" onchange="this.form.submit()" style="min-width: 140px; border-radius: 0 8px 8px 0;">
                                        <option value="">Semua Status</option>
                                        <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Stok Aman</option>
                                        <option value="rendah" {{ request('status') == 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Exp < 30 Hari</option>
                                    </select>
                                </div>
                                {{-- Search Input with Icon --}}
                                <div class="input-group" style="width: 220px;">
                                    <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                                        <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                                    </span>
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           class="form-control ps-0" 
                                           style="border-radius: 0 8px 8px 0; border-left: 0;"
                                           placeholder="Cari nama / kode...">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                </div>
                                {{-- Search Button --}}
                                <button type="submit" class="btn bg-gradient-dark mb-0 px-3" style="border-radius: 8px;">
                                    <i class="material-symbols-rounded" style="font-size: 18px;">search</i>
                                </button>
                                {{-- Clear Filter --}}
                                @if(request('search') || request('status'))
                                    <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary mb-0 px-3" style="border-radius: 8px;" title="Hapus Filter">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">close</i>
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">
                                        #
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">
                                        Kode
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">
                                        Nama Obat
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">
                                        Kategori
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">
                                        Satuan
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">
                                        Stok Tersedia
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">
                                        Stok Min
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">
                                        Status
                                    </th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($obats as $index => $obat)
                                    @php
                                        $totalStok = $obat->stokBatches->sum('sisa_stok');
                                        $isLow = $totalStok <= $obat->stok_minimum;
                                        $isExpiredSoon = $obat->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty();
                                    @endphp
                                    <tr class="
                                        {{ $isExpiredSoon ? 'row-exp-soon' : '' }}
                                        {{ !$isExpiredSoon && $isLow ? 'row-low-stock' : '' }}
                                    ">
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0 text-secondary">
                                                {{ $obats->firstItem() + $index }}
                                            </p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info-soft text-info fw-semibold">
                                                {{ $obat->kode_obat ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm text-dark">{{ $obat->nama_obat }}</h6>
                                                @if($obat->lokasi_rak)
                                                    <p class="text-xs text-muted mb-0 d-flex align-items-center gap-1">
                                                        <i class="material-symbols-rounded text-xs align-middle text-secondary">location_on</i>
                                                        <span>Rak: {{ $obat->lokasi_rak }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 fw-semibold">
                                                {{ $obat->kategori->nama_kategori ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $obat->satuan->nama_satuan ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                @if($isLow)
                                                    <span class="status-dot bg-warning"></span>
                                                @else
                                                    <span class="status-dot bg-success"></span>
                                                @endif
                                                <span class="text-sm fw-bold {{ $isLow ? 'text-warning' : 'text-dark' }}">
                                                    {{ $totalStok }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-soft-secondary text-secondary fw-semibold">
                                                {{ $obat->stok_minimum }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($isExpiredSoon)
                                                <span class="badge badge-sm bg-soft-danger text-danger d-inline-flex align-items-center gap-1">
                                                    <i class="material-symbols-rounded text-xs align-middle">event_busy</i>
                                                    <span>Exp &lt; 30 Hari</span>
                                                </span>
                                            @elseif($isLow)
                                                <span class="badge badge-sm bg-soft-warning text-warning d-inline-flex align-items-center gap-1">
                                                    <i class="material-symbols-rounded text-xs align-middle">warning</i>
                                                    <span>Stok Rendah</span>
                                                </span>
                                            @else
                                                <span class="badge badge-sm bg-soft-success text-success d-inline-flex align-items-center gap-1">
                                                    <i class="material-symbols-rounded text-xs align-middle">check_circle</i>
                                                    <span>Aman</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <x-action-buttons 
                                                :editUrl="route('admin.obat.edit', $obat->id)"
                                                :deleteUrl="route('admin.obat.destroy', $obat->id)"
                                                deleteMessage="Yakin ingin menghapus obat {{ $obat->nama_obat }}?"
                                            />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">inventory_2</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data stok obat</h6>
                                                <p class="text-xxs text-muted mb-0">
                                                    Tambahkan data obat melalui menu pembelian atau master data.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            {{-- Left: Per Page Selector --}}
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-xs text-secondary">Tampilkan</span>
                                <select class="form-select form-select-sm border rounded-2 px-2 py-1" 
                                        style="width: auto; min-width: 65px;" 
                                        onchange="window.location.href='{{ route('stok.index') }}?per_page='+this.value+'&search={{ request('search') }}&status={{ request('status') }}'">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-xs text-secondary">data per halaman</span>
                            </div>
                            {{-- Center: Info --}}
                            <p class="text-xs text-secondary mb-0">
                                <span class="fw-bold">{{ $obats->firstItem() ?? 0 }}</span> - 
                                <span class="fw-bold">{{ $obats->lastItem() ?? 0 }}</span> dari 
                                <span class="fw-bold">{{ $obats->total() }}</span> data
                            </p>
                            {{-- Right: Pagination --}}
                            <div>
                                {{ $obats->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Legend Status --}}
            <div class="d-flex flex-wrap align-items-center gap-3 mt-2 text-xxs text-muted">
                <div class="d-flex align-items-center gap-1">
                    <span class="status-dot bg-success"></span><span>Stok &gt; minimum (aman)</span>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <span class="status-dot bg-warning"></span><span>Stok ≤ minimum (stok rendah)</span>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <span class="row-indicator bg-danger"></span><span>Baris merah muda: item dengan kadaluarsa &lt; 30 hari</span>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

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

    .row-low-stock {
        background: rgba(255, 193, 7, 0.03);
    }
    .row-exp-soon {
        background: rgba(220, 53, 69, 0.03);
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        display: inline-block;
    }

    .row-indicator {
        width: 10px;
        height: 4px;
        border-radius: 999px;
        display: inline-block;
    }

    .badge.bg-gradient-info-soft {
        background: linear-gradient(135deg, rgba(23, 162, 184, .08), rgba(23, 162, 184, .16));
        color: #138496;
    }

    .table td, .table th { vertical-align: middle; }
</style>
@endsection