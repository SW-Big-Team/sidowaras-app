@extends('layouts.admin.app')
@section('title', 'Data Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Obat</li>
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
                                    <i class="material-symbols-rounded text-dark">medication</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Daftar Obat</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Kelola data obat dan informasi farmasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <a href="{{ route('admin.obat.create') }}" 
                               class="btn bg-white text-dark mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">add_circle</i> Tambah Obat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Total Obat
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">{{ $obats->total() }}</h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Item obat terdaftar</p>
                        </div>
                        <div class="summary-icon bg-soft-primary">
                            <i class="material-symbols-rounded text-primary">medication</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Obat Baru
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ \App\Models\Obat::where('created_at', '>=', now()->subDays(7))->count() }}
                            </h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Ditambahkan 7 hari terakhir</p>
                        </div>
                        <div class="summary-icon bg-soft-success">
                            <i class="material-symbols-rounded text-success">new_releases</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Stok Minimum
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ \App\Models\Obat::whereColumn('stok_minimum', '>', 'stok_minimum')->count() }}
                            </h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Perlu perhatian stok</p>
                        </div>
                        <div class="summary-icon bg-soft-warning">
                            <i class="material-symbols-rounded text-warning">warning</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
            <span class="alert-text fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
            <span class="alert-text fw-bold">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0 fw-bold">Data Obat</h6>
                                <span class="badge bg-soft-primary text-primary text-xs fw-bold rounded-pill">
                                    {{ $obats->total() }} data
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <form method="GET" action="{{ route('admin.obat.index') }}" class="d-flex align-items-center">
                                <div class="input-group input-group-outline">
                                    <input type="text" 
                                           class="form-control" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Cari obat...">
                                </div>
                                <button type="submit" class="btn bg-gradient-primary mb-0 ms-2">
                                    <i class="material-symbols-rounded">search</i>
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary mb-0 ms-2">
                                        <i class="material-symbols-rounded">close</i>
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
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Nama Obat</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Kategori</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Satuan</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Kandungan</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-9">Stok Min</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-9">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($obats as $obat)
                                    @php
                                        $kandunganList = $obat->kandungan->flatMap(function($k) {
                                            return is_array($k->nama_kandungan) ? $k->nama_kandungan : [$k->nama_kandungan];
                                        })->toArray();
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm fw-bold text-dark">{{ $obat->nama_obat }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $obat->kode_obat ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-soft-info text-info">
                                                {{ $obat->kategori?->nama_kategori ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $obat->satuan?->nama_satuan ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 text-wrap" style="max-width: 200px;">
                                                {{ implode(', ', $kandunganList) ?: '-' }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-soft-warning text-warning">
                                                {{ $obat->stok_minimum }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('admin.obat.edit', $obat->id) }}" 
                                                   class="btn btn-link text-warning px-3 mb-0"
                                                   title="Edit">
                                                    <i class="material-symbols-rounded text-sm">edit</i>
                                                </a>
                                                <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus obat {{ $obat->nama_obat }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-link text-danger px-3 mb-0"
                                                            title="Hapus">
                                                        <i class="material-symbols-rounded text-sm">delete</i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">medication</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data obat</h6>
                                                <p class="text-xs text-secondary">Silakan tambahkan obat baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
                        <div class="text-xs text-secondary">
                            Menampilkan {{ $obats->firstItem() ?? 0 }} sampai {{ $obats->lastItem() ?? 0 }} dari {{ $obats->total() }} data
                        </div>
                        <div>
                            {{ $obats->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-xxs { font-size: 0.65rem !important; }
        .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
        
        .bg-gradient-info-soft {
            background: linear-gradient(135deg, rgba(23, 162, 184, .08), rgba(23, 162, 184, .16));
            color: #138496;
        }

        .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
        .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
        .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
        .bg-soft-info { background: rgba(23, 162, 184, 0.12) !important; }
        .bg-soft-secondary { background: rgba(108, 117, 125, 0.12) !important; }

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
        
        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .input-group-outline {
            display: flex;
            width: 100%;
        }
        
        .cursor-pointer {
            cursor: pointer;
        }
        
        /* Summary Card Styles */
        .summary-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }
        .summary-icon {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</div>
@endsection
