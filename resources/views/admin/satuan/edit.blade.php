@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Satuan Obat</h4>

    <form action="{{ route('admin.satuan.update', $satuan->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nama_satuan" class="form-label">Nama Satuan</label>
            <input type="text" name="nama_satuan" value="{{ $satuan->nama_satuan }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="faktor_konversi" class="form-label">Faktor Konversi</label>
            <input type="number" name="faktor_konversi" value="{{ $satuan->faktor_konversi }}" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.satuan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
