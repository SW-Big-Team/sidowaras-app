@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Daftar Kategori Obat')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Kategori Obat</h4>

    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">+ Tambah Kategori</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kategori }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $kategori->links() }}
</div>
@endsection
