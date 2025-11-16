@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Kandungan Obat</h4>

    <form action="{{ route('admin.kandungan.update', $kandungan->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nama_kandungan" class="form-label">Nama Kandungan <small class="text-muted">(pisahkan dengan koma jika lebih dari satu)</small></label>
            <input type="text" name="nama_kandungan" id="nama_kandungan" value="{{ $kandungan->nama_kandungan_text }}" class="form-control" required>
            <small class="text-muted">Biasanya satu nama kandungan saja, tapi bisa lebih jika kombinasi.</small>
        </div>

        <div class="mb-3">
            <label for="dosis_kandungan" class="form-label">Dosis Kandungan</label>
            <input type="text" name="dosis_kandungan" value="{{ $kandungan->dosis_kandungan }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.kandungan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<script>
var input = document.querySelector('#nama_kandungan');
var tagify = new Tagify(input, {
    delimiters: ",",
    placeholder: "Ketik nama kandungan",
    dropdown: {
        enabled: 0
    }
});
</script>
@endsection
