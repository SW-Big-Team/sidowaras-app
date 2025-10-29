@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Kandungan Obat</h4>

    <form action="{{ route('kandungan.update', $kandungan->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nama_kandungan" class="form-label">Nama Kandungan</label>
            <input type="text" name="nama_kandungan" value="{{ $kandungan->nama_kandungan }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="dosis_kandungan" class="form-label">Dosis Kandungan</label>
            <input type="text" name="dosis_kandungan" value="{{ $kandungan->dosis_kandungan }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kandungan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
