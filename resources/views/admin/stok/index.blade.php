@php
    $layoutPath = 'layouts.admin.app';
@endphp

@extends($layoutPath)

@section('title', 'Daftar Stok')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Stok Obat</h5>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stok Tersedia</th>
                                    <th>Stok Minimum</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($obats as $obat)
                                    <tr>
                                        <td>{{ $obat->kode_obat ?? '-' }}</td>
                                        <td>{{ $obat->nama_obat }}</td>
                                        <td>{{ $obat->kategori->nama_kategori ?? '-' }}</td>
                                        <td>{{ $obat->satuan->nama_satuan ?? '-' }}</td>
                                        <td>
                                            @php
                                                $totalStok = $obat->stokBatches->sum('sisa_stok');
                                            @endphp
                                            {{ $totalStok }} {{ $obat->satuan->nama_satuan ?? '' }}
                                            @if($totalStok <= $obat->stok_minimum)
                                                <span class="badge bg-gradient-danger ms-2">Stok Rendah</span>
                                            @endif
                                        </td>
                                        <td>{{ $obat->stok_minimum }}</td>
                                        <td>
                                            <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-sm btn-warning">
                                                <i class="material-symbols-rounded">edit</i>
                                            </a>
                                            <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST" style="display:inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus obat ini?')">
                                                    <i class="material-symbols-rounded">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">Belum ada data obat</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 px-3">
                        {{ $obats->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection