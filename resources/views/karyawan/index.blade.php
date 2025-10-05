@extends('layouts.karyawan.app')

@section('content')
<div class="row">
  <div class="ms-3">
    <h3 class="mb-0 h4 font-weight-bolder">Dashboard Karyawan</h3>
    <p class="mb-4">
      Monitor stok obat dan transaksi harian.
    </p>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-symbols-rounded opacity-10">warning</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Stock Obat Expired</p>
          <h4 class="mb-0">5</h4>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-3">
        <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">Perlu perhatian</span></p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-symbols-rounded opacity-10">inventory</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Stock Hampir Habis</p>
          <h4 class="mb-0">12</h4>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-3">
        <p class="mb-0"><span class="text-warning text-sm font-weight-bolder">Perlu restock</span></p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-symbols-rounded opacity-10">payments</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Total Transaksi Cash</p>
          <h4 class="mb-0">Rp 2,500,000</h4>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-3">
        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+15%</span> dari kemarin</p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-symbols-rounded opacity-10">credit_card</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Total Transaksi Digital</p>
          <h4 class="mb-0">Rp 1,200,000</h4>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-3">
        <p class="mb-0"><span class="text-info text-sm font-weight-bolder">+8%</span> dari kemarin</p>
      </div>
    </div>
  </div>
</div>
@endsection
