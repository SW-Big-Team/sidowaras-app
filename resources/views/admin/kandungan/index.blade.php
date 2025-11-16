@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title','Daftar Kandungan Obat')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Kandungan Obat</h4>

    <a href="{{ route('admin.kandungan.create') }}" class="btn btn-primary mb-3">+ Tambah Kandungan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kandungan</th>
                <th>Dosis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kandungan_text }}</td>
                <td>{{ $item->dosis_kandungan }}</td>
                <td>
                    <a href="{{ route('admin.kandungan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.kandungan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kandungan ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links() }}
</div>
@endsection
