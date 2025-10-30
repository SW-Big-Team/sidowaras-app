@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Data Obat')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Obat</h2>
        <a href="{{ route('obat.create') }}" class="btn btn-primary">+ Tambah Obat</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" class="mb-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama obat..." class="form-control w-25 d-inline">
        <button type="submit" class="btn btn-secondary">Cari</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kode</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Kandungan</th>
                <th>Stok Minimum</th>
                <th>Racikan</th>
                <th>Lokasi Rak</th>
                <th>Barcode</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($obats as $index => $obat)
            @php
                $kandunganList = $obat->kandungans->pluck('nama_kandungan')->toArray();
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
                    <td class="text-center">
                        <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">Tidak ada data obat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $obats->links() }}
</div>
@endsection
