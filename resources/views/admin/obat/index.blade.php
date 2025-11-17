@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title', 'Data Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Obat</li>
</ol>
@endsection

@section('content')
<x-content-header title="Daftar Obat" subtitle="Kelola data obat dan informasi farmasi">
    <x-button-add 
        :href="route('admin.obat.create')" 
        icon="medication" 
        text="Tambah Obat"
    />
</x-content-header>

<div class="row">
    <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
                    <span class="alert-text">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
                    <span class="alert-text">{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
                    <span class="alert-text">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="mb-3">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group input-group-outline">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Cari nama obat, kode, atau kategori..." 
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-0">
                                    <i class="material-symbols-rounded me-1">search</i> Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary mb-0">
                                        <i class="material-symbols-rounded">close</i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table class="table table-hover mb-0" style="min-width: 1400px;">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="min-width: 50px;">No</th>
                                    <th style="min-width: 200px;">Nama Obat</th>
                                    <th style="min-width: 120px;">Kode</th>
                                    <th style="min-width: 150px;">Kategori</th>
                                    <th style="min-width: 100px;">Satuan</th>
                                    <th style="min-width: 180px;">Kandungan</th>
                                    <th class="text-center" style="min-width: 100px;">Stok Min</th>
                                    <th class="text-center" style="min-width: 80px;">Racikan</th>
                                    <th style="min-width: 120px;">Lokasi Rak</th>
                                    <th style="min-width: 120px;">Barcode</th>
                                    <th style="min-width: 200px;">Deskripsi</th>
                                    <th class="text-end" style="min-width: 150px; position: sticky; right: 0; background: white; box-shadow: -2px 0 5px rgba(0,0,0,0.05);">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($obats as $index => $obat)
                                @php
                                    // Flatten nested arrays from kandungan nama_kandungan JSON field
                                    $kandunganList = $obat->kandungan->flatMap(function($k) {
                                        return is_array($k->nama_kandungan) ? $k->nama_kandungan : [$k->nama_kandungan];
                                    })->toArray();
                                @endphp
                                    <tr>
                                        <td class="text-center">{{ $obats->firstItem() + $index }}</td>
                                        <td>{{ $obat->nama_obat }}</td>
                                        <td>{{ $obat->kode_obat ?? '-' }}</td>
                                        <td>{{ $obat->kategori?->nama_kategori ?? '-' }}</td>
                                        <td>{{ $obat->satuan?->nama_satuan ?? '-' }}</td>
                                        <td>{{ implode(', ', $kandunganList) ?: '-' }}</td>
                                        <td class="text-center">{{ $obat->stok_minimum }}</td>
                                        <td class="text-center">{{ $obat->is_racikan ? 'Ya' : 'Tidak' }}</td>
                                        <td>{{ $obat->lokasi_rak ?? '-' }}</td>
                                        <td>{{ $obat->barcode ?? '-' }}</td>
                                        <td>{{ $obat->deskripsi ?? '-' }}</td>
                                        <td class="text-end" style="position: sticky; right: 0; background: white; white-space: nowrap;">
                                            <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-sm btn-warning mb-0">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                            </a>
                                            <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus obat ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mb-0">
                                                    <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center p-3">Belum ada data obat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
