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
    <x-content-header title="Daftar Stok Obat" subtitle="Monitoring persediaan dan status stok obat">
        <div class="d-flex gap-2">
            <a href="{{ route('pembelian.index') }}" class="btn btn-outline-primary mb-0">
                <i class="material-symbols-rounded text-sm me-1">shopping_cart</i> Pembelian
            </a>
            <a href="{{ route('admin.obat.create') }}" class="btn bg-gradient-primary mb-0">
                <i class="material-symbols-rounded text-sm me-1">add_circle</i> Tambah Obat
            </a>
        </div>
    </x-content-header>

    <div class="row">
        <div class="col-12">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">inventory_2</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Item</p>
                                <h4 class="mb-0">{{ $obats->total() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">warning</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Stok Rendah</p>
                                <h4 class="mb-0">{{ $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') <= $o->stok_minimum)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">event_busy</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Exp < 30 Hari</p>
                                <h4 class="mb-0">{{ $obats->filter(fn($o) => $o->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty())->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-symbols-rounded opacity-10">check_circle</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Stok Aman</p>
                                <h4 class="mb-0">{{ $obats->filter(fn($o) => $o->stokBatches->sum('sisa_stok') > $o->stok_minimum)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <x-data-table :headers="['#', 'Kode', 'Nama Obat', 'Kategori', 'Satuan', 'Stok Tersedia', 'Stok Min', 'Status', 'Aksi']">
                @forelse($obats as $index => $obat)
                    @php
                        $totalStok = $obat->stokBatches->sum('sisa_stok');
                        $isLow = $totalStok <= $obat->stok_minimum;
                        $isExpiredSoon = $obat->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty();
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{ $obats->firstItem() + $index }}</p>
                        </td>
                        <td>
                            <span class="badge badge-sm bg-gradient-info">{{ $obat->kode_obat ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $obat->nama_obat }}</h6>
                                    @if($obat->lokasi_rak)
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="material-symbols-rounded text-xs">location_on</i>
                                            {{ $obat->lokasi_rak }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $obat->kategori->nama_kategori ?? '-' }}</p>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $obat->satuan->nama_satuan ?? '-' }}</p>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($isLow)
                                    <i class="material-symbols-rounded text-warning me-1">warning</i>
                                @endif
                                <span class="text-sm font-weight-bold {{ $isLow ? 'text-warning' : '' }}">
                                    {{ $totalStok }} {{ $obat->satuan->nama_satuan ?? '' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-sm bg-gradient-secondary">{{ $obat->stok_minimum }}</span>
                        </td>
                        <td>
                            @if($isExpiredSoon)
                                <span class="badge badge-sm bg-gradient-danger">
                                    <i class="material-symbols-rounded text-xs">event_busy</i> Exp Soon
                                </span>
                            @elseif($isLow)
                                <span class="badge badge-sm bg-gradient-warning">
                                    <i class="material-symbols-rounded text-xs">warning</i> Stok Rendah
                                </span>
                            @else
                                <span class="badge badge-sm bg-gradient-success">
                                    <i class="material-symbols-rounded text-xs">check_circle</i> Aman
                                </span>
                            @endif
                        </td>
                        <td>
                            <x-action-buttons 
                                :editUrl="route('admin.obat.edit', $obat->id)"
                                :deleteUrl="route('admin.obat.destroy', $obat->id)"
                                deleteMessage="Yakin ingin menghapus obat {{ $obat->nama_obat }}?"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">inventory_2</i>
                            <p class="text-secondary mb-0">Belum ada data stok obat</p>
                        </td>
                    </tr>
                @endforelse
            </x-data-table>

            <div class="mt-3">
                {{ $obats->links() }}
            </div>
        </div>
    </div>
</div>
@endsection