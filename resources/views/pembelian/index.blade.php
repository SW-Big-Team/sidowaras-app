@extends('layouts.app')

@section('title','Daftar Pembelian')

@section('content')
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
