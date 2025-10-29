@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Tambah Obat')

@section('content')
<div class="container mt-4">
    <h2>Tambah Obat</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('obat.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Kode Obat</label>
            <input type="text" name="kode_obat" class="form-control" value="{{ old('kode_obat') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Satuan</label>
            <select name="satuan_obat_id" class="form-select">
                <option value="">-- Pilih Satuan --</option>
                @foreach($satuan as $s)
                    <option value="{{ $s->id }}" {{ old('satuan_obat_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_satuan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Kandungan (bisa pilih lebih dari satu)</label>
            <select name="kandungan_id[]" class="form-select" multiple>
                @foreach($kandungan as $k)
                    <option value="{{ $k->id }}" {{ (is_array(old('kandungan_id')) && in_array($k->id, old('kandungan_id'))) ? 'selected' : '' }}>
                        {{ $k->nama_kandungan }} ({{ $k->dosis_kandungan }})
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Gunakan Ctrl/Cmd + klik untuk memilih lebih dari satu kandungan.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok Minimum</label>
            <input type="number" name="stok_minimum" class="form-control" value="{{ old('stok_minimum', 10) }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_racikan" class="form-check-input" value="1" {{ old('is_racikan') ? 'checked' : '' }}>
            <label class="form-check-label">Obat Racikan</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi Rak</label>
            <input type="text" name="lokasi_rak" class="form-control" value="{{ old('lokasi_rak') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Barcode</label>
            <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
