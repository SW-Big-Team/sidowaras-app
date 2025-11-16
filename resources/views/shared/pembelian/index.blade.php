@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title','Daftar Pembelian')

@section('content')
<<<<<<< HEAD
<div class="container-fluid mt-4 px-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fas fa-list-alt"></i> Daftar Pembelian</h4>
        <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Pembelian
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover small">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>No Faktur</th>
                            <th>Pengirim</th>
                            <th>Total Harga</th>
                            <th>Metode Bayar</th> {{-- BARU --}}
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelian as $p)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($pembelian->firstItem() - 1) }}</td>
                                <td>{{ $p->no_faktur }}</td>
                                <td>{{ $p->nama_pengirim }}</td>
                                <td class="text-end">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                
                                {{-- BARU: Kolom Metode Pembayaran --}}
                                <td class="text-center">
                                    @if($p->metode_pembayaran == 'tunai')
                                        <span class="badge bg-success">{{ ucfirst($p->metode_pembayaran) }}</span>
                                    @elseif($p->metode_pembayaran == 'non tunai')
                                        <span class="badge bg-primary">{{ ucfirst($p->metode_pembayaran) }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ ucfirst($p->metode_pembayaran) }}</span>
                                    @endif
                                </td>
                                
                                <td>{{ $p->user->nama_lengkap ?? $p->user->name ?? '-' }}</td>
                                <td class="text-center">{{ $p->tgl_pembelian->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('pembelian.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        <a href="{{ route('pembelian.show', $p->id) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('pembelian.edit', $p->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- MODIFIKASI: Update colspan --}}
                            <tr><td colspan="8" class="text-center">Tidak ada data pembelian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pembelian->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
=======
<div class="container mt-4">
    <h3>Daftar Pembelian</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-3">Tambah Pembelian</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>No Faktur</th>
                <th>Pengirim</th>
                <th>Total Harga</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelian as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->no_faktur }}</td>
                    <td>{{ $p->nama_pengirim }}</td>
                    <td>{{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $p->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $p->tgl_pembelian->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('pembelian.show', $p->uuid) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pembelian.edit', $p->uuid) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pembelian.destroy', $p->uuid) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Tidak ada data pembelian.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $pembelian->links() }}
</div>
@endsection
>>>>>>> 191a90d0afe25e0da503fa8b64639dda5508dc40
