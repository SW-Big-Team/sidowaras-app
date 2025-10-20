@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@section('content')
<div class="container mt-4">
    <h3>Tambah Pembelian</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Obat</label>
            <select name="obat_id" class="form-control" required>
                <option value="">-- Pilih Obat --</option>
                @foreach($obatList as $o)
                    <option value="{{ $o->id }}">{{ $o->nama_obat }} @if($o->barcode) ({{ $o->barcode }}) @endif</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Pengirim</label>
            <input type="text" name="nama_pengirim" class="form-control" value="{{ old('nama_pengirim') }}" required>
        </div>

        <div class="mb-3">
            <label>No Telepon Pengirim</label>
            <input type="text" name="no_telepon_pengirim" class="form-control" value="{{ old('no_telepon_pengirim') }}">
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="tunai" @selected(old('metode_pembayaran') === 'tunai')>Tunai</option>
                <option value="non tunai" @selected(old('metode_pembayaran') === 'non tunai')>Non Tunai</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control" value="{{ old('harga_beli') }}" required step="0.01">
        </div>

        <div class="mb-3">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}" required step="0.01">
        </div>

        <div class="mb-3">
            <label>Jumlah Masuk</label>
            <input type="number" name="jumlah_masuk" class="form-control" value="{{ old('jumlah_masuk', 1) }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Kadaluarsa</label>
            <input type="date" name="tgl_kadaluarsa" class="form-control" value="{{ old('tgl_kadaluarsa') }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Pembelian</label>
            <input type="datetime-local" name="tgl_pembelian" class="form-control" value="{{ old('tgl_pembelian') }}" required>
            <small class="text-muted">Isi tanggal dan jam pembelian secara manual</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
