@extends('layouts.karyawan.app')

@section('content')
<style>
  /* 🌿 Improved Custom Styling */
  .page-title {
    font-weight: 700;
    color: #1e293b; /* slate-800 */
  }

  .page-subtitle {
    color: #64748b; /* slate-500 */
    font-size: 0.95rem;
  }

  .card-modern {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }

  .card-modern:hover {
    box-shadow: 0 6px 28px rgba(0, 0, 0, 0.07);
  }

  .form-label {
    font-weight: 600;
    color: #334155;
  }

  .form-control,
  .form-select,
  textarea {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .form-control:focus,
  .form-select:focus,
  textarea:focus {
    border-color: #1AB262;
    box-shadow: 0 0 0 0.15rem rgba(26, 178, 98, 0.2);
  }

  .btn-primary-custom {
    background-color: #1AB262;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.25s ease;
    padding: 10px 24px;
  }

  .btn-primary-custom:hover {
    background-color: #17a456;
    box-shadow: 0 4px 12px rgba(26, 178, 98, 0.3);
  }

  .btn-secondary-custom {
    background-color: #f1f5f9;
    color: #334155;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-weight: 500;
    padding: 10px 24px;
    transition: all 0.25s ease;
  }

  .btn-secondary-custom:hover {
    background-color: #e2e8f0;
  }

  .divider {
    border-top: 1px dashed #e2e8f0;
    margin: 1.5rem 0;
  }
</style>

<div class="row">
  <div class="col-lg-12 mb-4">
    <h3 class="page-title mb-1">Tambah Obat Baru</h3>
    <p class="page-subtitle">Lengkapi informasi di bawah ini untuk menambahkan obat ke dalam inventori apotek.</p>
  </div>

  <div class="col-12">
    <div class="card card-modern">
      <div class="card-body p-4">
      @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
      <form action="{{ route('karyawan.stock.store') }}" method="POST">
          @csrf
            <div class="row g-3">
                <!-- Nama Obat -->
                <div class="col-md-6">
                    <label for="nama_obat" class="form-label">Nama Obat</label>
                    <input type="text" id="nama_obat" name="nama_obat" class="form-control" placeholder="Masukkan nama obat" required>
                </div>

                <!-- Kategori -->
                <div class="col-md-6">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="form-select" required>
                        <option value="">Pilih kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Satuan -->
                <div class="col-md-6">
                    <label for="satuan_obat_id" class="form-label">Satuan</label>
                    <select id="satuan_obat_id" name="satuan_obat_id" class="form-select" required>
                        <option value="">Pilih satuan</option>
                        @foreach($satuan as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_satuan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="kandungan_id" class="form-label">Kandungan</label>
                    <select id="kandungan_id" name="kandungan_id[]" class="form-select" multiple>
                        @foreach($kandungan as $k)
                          <option value="{{ $k->id }}">
                            @php
                              $decoded = json_decode($k->nama_kandungan, true);
                              echo is_array($decoded) ? implode(', ', $decoded) : $k->nama_kandungan;
                            @endphp
                          </option>
                        @endforeach
                    </select>
                </div>

                <div class="divider"></div>

                <!-- Harga Beli & Jual -->
                <div class="col-md-6">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <input type="number" id="harga_beli" name="harga_beli" class="form-control" placeholder="0" min="0" step="0.01" required>
                </div>
                <div class="col-md-6">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <input type="number" id="harga_jual" name="harga_jual" class="form-control" placeholder="0" min="0" step="0.01" required>
                </div>

                <!-- Stok Awal & Kadaluarsa -->
                <div class="col-md-6">
                    <label for="stok_awal" class="form-label">Stok Awal</label>
                    <input type="number" id="stok_awal" name="stok_awal" class="form-control" placeholder="Jumlah stok awal" min="1" required>
                </div>
                <div class="col-md-6">
                    <label for="tgl_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                    <input type="date" id="tgl_kadaluarsa" name="tgl_kadaluarsa" class="form-control" required>
                </div>

                <!-- Supplier -->
                <div class="col-md-6">
                    <label for="nama_pengirim" class="form-label">Supplier</label>
                    <input type="text" id="nama_pengirim" name="nama_pengirim" class="form-control" placeholder="Nama supplier" required>
                </div>

                <!-- Stok Minimum -->
                <div class="col-md-6">
                    <label for="stok_minimum" class="form-label">Stok Minimum</label>
                    <input type="number" id="stok_minimum" name="stok_minimum" class="form-control" value="10" min="0">
                </div>

                <!-- Deskripsi -->
                <div class="col-md-12">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi obat"></textarea>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('karyawan.stock.index') }}" class="btn btn-secondary-custom me-2">Batal</a>
                <button type="submit" class="btn btn-primary-custom">Simpan Obat & Stok</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
