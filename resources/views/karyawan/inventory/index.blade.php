@extends('layouts.karyawan.app')

@section('content')
<div class="row">
  <div class="ms-3">
    <h3 class="mb-0 h4 font-weight-bolder">Stock Barang</h3>
    <p class="mb-4">
      Kelola inventori obat dan bahan medis.
    </p>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Obat</h6>
          <a href="{{ route('karyawan.stock.tambah') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Obat Baru
          </a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Obat</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stok</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Beli</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kadaluarsa</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              <!-- Dummy data -->
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Paracetamol 500mg</h6>
                      <p class="text-xs text-secondary mb-0">Tablet</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Analgesik</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">150</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Rp 2,000</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">2026-05-15</p>
                </td>
                <td class="align-middle">
                  <button class="btn btn-link text-secondary px-3 mb-0">
                    <i class="fas fa-pencil-alt me-2"></i>Edit
                  </button>
                  <button class="btn btn-link text-danger text-gradient px-3 mb-0">
                    <i class="far fa-trash-alt me-2"></i>Hapus
                  </button>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Amoxicillin 250mg</h6>
                      <p class="text-xs text-secondary mb-0">Kapsul</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Antibiotik</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">75</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Rp 5,000</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">2025-12-20</p>
                </td>
                <td class="align-middle">
                  <button class="btn btn-link text-secondary px-3 mb-0">
                    <i class="fas fa-pencil-alt me-2"></i>Edit
                  </button>
                  <button class="btn btn-link text-danger text-gradient px-3 mb-0">
                    <i class="far fa-trash-alt me-2"></i>Hapus
                  </button>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Ibuprofen 200mg</h6>
                      <p class="text-xs text-secondary mb-0">Tablet</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Anti-inflamasi</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">200</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Rp 1,500</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">2026-08-10</p>
                </td>
                <td class="align-middle">
                  <button class="btn btn-link text-secondary px-3 mb-0">
                    <i class="fas fa-pencil-alt me-2"></i>Edit
                  </button>
                  <button class="btn btn-link text-danger text-gradient px-3 mb-0">
                    <i class="far fa-trash-alt me-2"></i>Hapus
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
