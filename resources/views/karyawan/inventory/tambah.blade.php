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
        <form>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nama_obat" class="form-label">Nama Obat</label>
              <input type="text" id="nama_obat" class="form-control" placeholder="Masukkan nama obat">
            </div>
            <div class="col-md-6">
              <label for="kategori" class="form-label">Kategori</label>
              <select id="kategori" class="form-select">
                <option value="">Pilih kategori</option>
                <option>Analgesik</option>
                <option>Antibiotik</option>
                <option>Anti-inflamasi</option>
                <option>Vitamin</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="bentuk" class="form-label">Bentuk</label>
              <select id="bentuk" class="form-select">
                <option value="">Pilih bentuk</option>
                <option>Tablet</option>
                <option>Kapsul</option>
                <option>Sirup</option>
                <option>Salep</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="satuan" class="form-label">Satuan</label>
              <select id="satuan" class="form-select">
                <option value="">Pilih satuan</option>
                <option>Pcs</option>
                <option>Botol</option>
                <option>Tube</option>
              </select>
            </div>

            <div class="divider"></div>

            <div class="col-md-6">
              <label for="harga_beli" class="form-label">Harga Beli</label>
              <input type="number" id="harga_beli" class="form-control" placeholder="Rp 0">
            </div>
            <div class="col-md-6">
              <label for="harga_jual" class="form-label">Harga Jual</label>
              <input type="number" id="harga_jual" class="form-control" placeholder="Rp 0">
            </div>

            <div class="col-md-6">
              <label for="stok_awal" class="form-label">Stok Awal</label>
              <input type="number" id="stok_awal" class="form-control" placeholder="Jumlah stok awal">
            </div>
            <div class="col-md-6">
              <label for="kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
              <input type="date" id="kadaluarsa" class="form-control">
            </div>

            <div class="divider"></div>

            <div class="col-md-6">
              <label for="supplier" class="form-label">Supplier</label>
              <select id="supplier" name="supplier" class="form-select">
                <option value="">Pilih supplier</option>
                <option value="PT. Kimia Farma">PT. Kimia Farma</option>
                <option value="PT. Indofarma">PT. Indofarma</option>
                <option value="CV. Apotek Sehat">CV. Apotek Sehat</option>
                <option value="other">Lainnya</option>
              </select>
            </div>

            <div class="col-md-6" id="supplier_other_wrap" style="display: none;">
              <label for="supplier_other" class="form-label">Nama Supplier (Lainnya)</label>
              <input type="text" id="supplier_other" name="supplier_other" class="form-control" placeholder="Masukkan nama supplier">
            </div>

            <script>
              document.addEventListener('DOMContentLoaded', function () {
                var supplierSelect = document.getElementById('supplier');
                var otherWrap = document.getElementById('supplier_other_wrap');

                function toggleOther() {
                  otherWrap.style.display = supplierSelect.value === 'other' ? 'block' : 'none';
                }

                supplierSelect.addEventListener('change', toggleOther);
                toggleOther();
              });
            </script>
            <div class="col-md-12">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea id="deskripsi" class="form-control" rows="3" placeholder="Tuliskan deskripsi singkat mengenai obat ini"></textarea>
            </div>
          </div>

          <div class="text-end mt-4">
            <button type="button" class="btn btn-secondary-custom me-2">Batal</button>
            <button type="submit" class="btn btn-primary-custom">Simpan Obat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
