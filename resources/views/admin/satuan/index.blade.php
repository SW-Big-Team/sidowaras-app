@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Daftar Satuan Obat')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Satuan Obat</h4>

    <a href="{{ route('admin.satuan.create') }}" class="btn btn-primary mb-3">+ Tambah Satuan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Satuan</th>
                <th>Faktor Konversi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($satuan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_satuan }}</td>
                <td>{{ $item->faktor_konversi }}</td>
                <td>
                    <a href="{{ route('admin.satuan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.satuan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus satuan ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $satuan->links() }}
</div>
@endsection
