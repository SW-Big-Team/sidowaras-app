@php
    // Deteksi role untuk pilih layout
    $role = auth()->user()->role->nama_role;
    $layout = match($role) {
        'Admin' => 'layouts.admin.app',
        'Kasir' => 'layouts.kasir.app',
        'Karyawan' => 'layouts.karyawan.app',
        default => 'layouts.app',
    };
@endphp

@extends($layout)

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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($obats as $obat)
                                    @php
                                        $totalStok = $obat->stokBatches->sum('sisa_stok');
                                        $isLow = $totalStok <= $obat->stok_minimum;
                                        $isExpiredSoon = $obat->stokBatches->where('tgl_kadaluarsa', '<=', now()->addDays(30))->isNotEmpty();
                                    @endphp
                                    <tr>
                                        <td>{{ $obat->kode_obat ?? '-' }}</td>
                                        <td>{{ $obat->nama_obat }}</td>
                                        <td>{{ $obat->kategori->nama_kategori ?? '-' }}</td>
                                        <td>{{ $obat->satuan->nama_satuan ?? '-' }}</td>
                                        <td>
                                            {{ $totalStok }} {{ $obat->satuan->nama_satuan ?? '' }}
                                        </td>
                                        <td>{{ $obat->stok_minimum }}</td>
                                        <td>
                                            @if($isExpiredSoon)
                                                <span class="badge bg-gradient-danger">Exp Soon</span>
                                            @elseif($isLow)
                                                <span class="badge bg-gradient-warning">Stok Rendah</span>
                                            @else
                                                <span class="badge bg-gradient-success">Aman</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">Belum ada stok obat</td>
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