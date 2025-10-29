@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Satuan Obat</h4>

    <form action="{{ route('satuan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_satuan" class="form-label">Nama Satuan</label>
            <input type="text" name="nama_satuan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="faktor_konversi" class="form-label">Faktor Konversi</label>
            <input type="number" name="faktor_konversi" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('satuan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
