@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Edit Obat')

@section('content')
<div class="container mt-4">
    <h2>Edit Obat</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat', $obat->nama_obat) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Kode Obat</label>
            <input type="text" name="kode_obat" class="form-control" value="{{ old('kode_obat', $obat->kode_obat) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select">
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id', $obat->kategori_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Satuan</label>
            <select name="satuan_obat_id" class="form-select">
                @foreach($satuan as $s)
                    <option value="{{ $s->id }}" {{ old('satuan_obat_id', $obat->satuan_obat_id) == $s->id ? 'selected' : '' }}>
                        {{ $s->nama_satuan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Kandungan Obat <small class="text-muted">(bisa lebih dari satu)</small></label>
            <select name="kandungan_id[]" id="kandunganSelectEdit" class="form-select" multiple>
                @php
                    $selectedKandungan = is_array($obat->kandungan_id) ? $obat->kandungan_id : json_decode($obat->kandungan_id, true);
                @endphp
                @foreach($kandungan as $k)
                    <option value="{{ $k->id }}" {{ in_array($k->id, old('kandungan_id', $selectedKandungan ?? [])) ? 'selected' : '' }}>
                        {{ $k->nama_kandungan_text }} ({{ $k->dosis_kandungan }})
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Ketik untuk mencari kandungan.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok Minimum</label>
            <input type="number" name="stok_minimum" class="form-control" value="{{ old('stok_minimum', $obat->stok_minimum) }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_racikan" class="form-check-input" value="1" {{ old('is_racikan', $obat->is_racikan) ? 'checked' : '' }}>
            <label class="form-check-label">Obat Racikan</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi Rak</label>
            <input type="text" name="lokasi_rak" class="form-control" value="{{ old('lokasi_rak', $obat->lokasi_rak) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Barcode</label>
            <input type="text" name="barcode" class="form-control" value="{{ old('barcode', $obat->barcode) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#kandunganSelectEdit').select2({
        placeholder: 'Pilih kandungan obat (bisa lebih dari satu)',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection
