@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Kategori Obat</h4>

    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
