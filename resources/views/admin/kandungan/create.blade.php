@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Kandungan Obat</h4>

    <form action="{{ route('admin.kandungan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_kandungan" class="form-label">Nama Kandungan</label>
            <input type="text" name="nama_kandungan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="dosis_kandungan" class="form-label">Dosis Kandungan</label>
            <input type="text" name="dosis_kandungan" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.kandungan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
