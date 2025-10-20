@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Edit Pembelian</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="obat_id" class="form-label">Obat</label>
            <select name="obat_id" id="obat_id" class="form-select" required>
                <option value="">-- Pilih Obat --</option>
                @foreach ($obatList as $obat)
                    <option value="{{ $obat->id }}" 
                        @if ($pembelian->stokBatches->first() && $pembelian->stokBatches->first()->obat_id == $obat->id) selected @endif>
                        {{ $obat->nama_obat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
            <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" 
                value="{{ old('nama_pengirim', $pembelian->nama_pengirim) }}" required>
        </div>

        <div class="mb-3">
            <label for="no_telepon_pengirim" class="form-label">No Telepon Pengirim</label>
            <input type="text" class="form-control" id="no_telepon_pengirim" name="no_telepon_pengirim" 
                value="{{ old('no_telepon_pengirim', $pembelian->no_telepon_pengirim) }}">
        </div>

        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                <option value="tunai" {{ $pembelian->metode_pembayaran == 'tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="non tunai" {{ $pembelian->metode_pembayaran == 'non tunai' ? 'selected' : '' }}>Non Tunai</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tgl_pembelian" class="form-label">Tanggal Pembelian</label>
            <input type="datetime-local" class="form-control" id="tgl_pembelian" name="tgl_pembelian" 
                value="{{ old('tgl_pembelian', \Carbon\Carbon::parse($pembelian->tgl_pembelian)->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input type="number" step="0.01" class="form-control" id="harga_beli" name="harga_beli"
                value="{{ old('harga_beli', $pembelian->stokBatches->first()->harga_beli ?? 0) }}" required>
        </div>

        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" step="0.01" class="form-control" id="harga_jual" name="harga_jual"
                value="{{ old('harga_jual', $pembelian->stokBatches->first()->harga_jual ?? 0) }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah_masuk" class="form-label">Jumlah Masuk</label>
            <input type="number" class="form-control" id="jumlah_masuk" name="jumlah_masuk"
                value="{{ old('jumlah_masuk', $pembelian->stokBatches->first()->jumlah_masuk ?? 0) }}" required>
        </div>

        <div class="mb-3">
            <label for="tgl_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
            <input type="date" class="form-control" id="tgl_kadaluarsa" name="tgl_kadaluarsa"
                value="{{ old('tgl_kadaluarsa', \Carbon\Carbon::parse($pembelian->stokBatches->first()->tgl_kadaluarsa ?? now())->format('Y-m-d')) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
