@extends('layouts.admin.app')

@section('title', 'Dashboard Administrator - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard Administrator</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="ms-3">
    <h3 class="mb-0 h4 font-weight-bolder">Dashboard Administrator</h3>
    <p class="mb-4">Kelola seluruh sistem, monitor transaksi, laporan keuangan & stok, serta manajemen pengguna.</p>
  </div>
  
  {{-- Key Metrics Cards --}}
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Penjualan Hari Ini</p>
            <h4 class="mb-0">Rp 8.450.000</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">payments</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+12.5% </span>dari kemarin</p>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Penjualan Bulan Ini</p>
            <h4 class="mb-0">Rp 287.500.000</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-warning shadow-warning shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">calendar_month</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>dari bulan lalu</p>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Total Pengguna</p>
            <h4 class="mb-0">24 Users</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">group</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-muted">8 Admin | 6 Kasir | 10 Karyawan</span></p>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Nilai Stok</p>
            <h4 class="mb-0">Rp 125.400.000</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">inventory</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-muted">Total nilai inventory</span></p>
      </div>
    </div>
  </div>
</div>

{{-- System Management & Quick Actions --}}
<div class="row mt-4">
  <div class="col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6>Manajemen Sistem</h6>
        <p class="text-sm mb-0">Kelola pengguna dan role</p>
      </div>
      <div class="card-body p-3">
        <div class="timeline timeline-one-side">
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-gradient-success">
              <i class="material-symbols-rounded text-white text-sm">group</i>
            </span>
            <div class="timeline-content">
              <a href="{{ route('admin.users.index') }}" class="text-dark text-sm font-weight-bold">Kelola Pengguna</a>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">24 pengguna terdaftar</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-gradient-info">
              <i class="material-symbols-rounded text-white text-sm">admin_panel_settings</i>
            </span>
            <div class="timeline-content">
              <a href="{{ route('karyawan.dashboard') }}" class="text-dark text-sm font-weight-bold">Dashboard Karyawan</a>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">10 karyawan aktif</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-gradient-warning">
              <i class="material-symbols-rounded text-white text-sm">point_of_sale</i>
            </span>
            <div class="timeline-content">
              <a href="{{ route('kasir.dashboard') }}" class="text-dark text-sm font-weight-bold">Dashboard Kasir</a>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">6 kasir aktif</p>
            </div>
          </div>
          <div class="timeline-block">
            <span class="timeline-step bg-gradient-primary">
              <i class="material-symbols-rounded text-white text-sm">inventory</i>
            </span>
            <div class="timeline-content">
              <a href="#" class="text-dark text-sm font-weight-bold">Kelola Stok Obat</a>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">1,245 jenis obat</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8 mb-4">
    <div class="card h-100">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
          <div>
            <h6>Monitoring Transaksi Hari Ini</h6>
            <p class="text-sm mb-0">Real-time transaction monitoring</p>
          </div>
          <div>
            <a href="#" class="btn btn-sm btn-outline-primary mb-0">Lihat Semua</a>
          </div>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-success border-radius-lg">
              <h3 class="text-white mb-0">45</h3>
              <p class="text-white text-sm mb-0">Transaksi</p>
            </div>
          </div>
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-info border-radius-lg">
              <h3 class="text-white mb-0">8</h3>
              <p class="text-white text-sm mb-0">Cart Pending</p>
            </div>
          </div>
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-warning border-radius-lg">
              <h3 class="text-white mb-0">12</h3>
              <p class="text-white text-sm mb-0">Stok Minimum</p>
            </div>
          </div>
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-danger border-radius-lg">
              <h3 class="text-white mb-0">5</h3>
              <p class="text-white text-sm mb-0">Obat Expired</p>
            </div>
          </div>
        </div>
        
        <div class="table-responsive mt-3">
          <table class="table table-sm align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Transaksi</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kasir</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-sm">TRX-045</td>
                <td class="text-sm">Siti Kasir</td>
                <td class="text-xs text-secondary">14:30</td>
                <td class="text-sm font-weight-bold">Rp 125.000</td>
                <td><span class="badge badge-sm bg-gradient-success">Selesai</span></td>
              </tr>
              <tr>
                <td class="text-sm">TRX-044</td>
                <td class="text-sm">Budi Kasir</td>
                <td class="text-xs text-secondary">14:15</td>
                <td class="text-sm font-weight-bold">Rp 85.000</td>
                <td><span class="badge badge-sm bg-gradient-success">Selesai</span></td>
              </tr>
              <tr>
                <td class="text-sm">TRX-043</td>
                <td class="text-sm">Siti Kasir</td>
                <td class="text-xs text-secondary">13:45</td>
                <td class="text-sm font-weight-bold">Rp 250.000</td>
                <td><span class="badge badge-sm bg-gradient-success">Selesai</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Financial & Stock Reports --}}
<div class="row mt-4">
  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Laporan Keuangan</h6>
        <p class="text-sm mb-0">Financial performance overview</p>
      </div>
      <div class="card-body p-3">
        <div class="row mb-3">
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">Revenue Bulan Ini</p>
              <h5 class="mb-0 text-success">Rp 287.5M</h5>
            </div>
          </div>
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">Profit Margin</p>
              <h5 class="mb-0 text-primary">28.5%</h5>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">HPP</p>
              <h6 class="mb-0">Rp 205.5M</h6>
            </div>
          </div>
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">Net Profit</p>
              <h6 class="mb-0 text-success">Rp 82.0M</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Laporan Stok</h6>
        <p class="text-sm mb-0">Inventory status & alerts</p>
      </div>
      <div class="card-body p-3">
        <div class="list-group list-group-flush">
          <div class="list-group-item px-0 border-0 mb-2 bg-light rounded">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="icon icon-shape bg-danger text-white rounded-circle">
                  <i class="material-symbols-rounded opacity-10">warning</i>
                </div>
              </div>
              <div class="col">
                <h6 class="mb-0 text-sm font-weight-bold">Obat Kadaluarsa</h6>
                <p class="text-xs text-muted mb-0"><strong>5 item</strong> perlu ditindaklanjuti</p>
              </div>
              <div class="col-auto">
                <button class="btn btn-sm btn-outline-danger mb-0">Lihat</button>
              </div>
            </div>
          </div>
          <div class="list-group-item px-0 border-0 mb-2 bg-light rounded">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="icon icon-shape bg-warning text-white rounded-circle">
                  <i class="material-symbols-rounded opacity-10">inventory_2</i>
                </div>
              </div>
              <div class="col">
                <h6 class="mb-0 text-sm font-weight-bold">Stok Minimum</h6>
                <p class="text-xs text-muted mb-0"><strong>12 item</strong> di bawah minimum</p>
              </div>
              <div class="col-auto">
                <button class="btn btn-sm btn-outline-warning mb-0">Lihat</button>
              </div>
            </div>
          </div>
          <div class="list-group-item px-0 border-0 mb-2 bg-light rounded">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="icon icon-shape bg-info text-white rounded-circle">
                  <i class="material-symbols-rounded opacity-10">trending_up</i>
                </div>
              </div>
              <div class="col">
                <h6 class="mb-0 text-sm font-weight-bold">Stok Opname Pending</h6>
                <p class="text-xs text-muted mb-0"><strong>3 laporan</strong> menunggu review</p>
              </div>
              <div class="col-auto">
                <button class="btn btn-sm btn-outline-info mb-0">Review</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- User Activity Log --}}
<div class="row mt-4">
  <div class="col-lg-12 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6>Aktivitas Pengguna Terbaru</h6>
            <p class="text-sm mb-0">Real-time user activity monitoring</p>
          </div>
          <div>
            <select class="form-select form-select-sm" style="width: auto;">
              <option>Semua Role</option>
              <option>Admin</option>
              <option>Kasir</option>
              <option>Karyawan</option>
            </select>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-3">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengguna</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aktivitas</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="avatar avatar-sm bg-gradient-info me-3">
                      <span class="text-white text-xs">SK</span>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Siti Kasir</h6>
                      <p class="text-xs text-secondary mb-0">siti@apotek.com</p>
                    </div>
                  </div>
                </td>
                <td><span class="badge badge-sm bg-gradient-warning">Kasir</span></td>
                <td class="text-sm">Melakukan transaksi TRX-045</td>
                <td class="text-xs text-secondary">2 menit yang lalu</td>
                <td><span class="badge badge-sm bg-gradient-success">Sukses</span></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="avatar avatar-sm bg-gradient-success me-3">
                      <span class="text-white text-xs">AK</span>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Ahmad Karyawan</h6>
                      <p class="text-xs text-secondary mb-0">ahmad@apotek.com</p>
                    </div>
                  </div>
                </td>
                <td><span class="badge badge-sm bg-gradient-info">Karyawan</span></td>
                <td class="text-sm">Submit cart CART-008 untuk approval</td>
                <td class="text-xs text-secondary">15 menit yang lalu</td>
                <td><span class="badge badge-sm bg-gradient-warning">Pending</span></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="avatar avatar-sm bg-gradient-warning me-3">
                      <span class="text-white text-xs">BK</span>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Budi Kasir</h6>
                      <p class="text-xs text-secondary mb-0">budi@apotek.com</p>
                    </div>
                  </div>
                </td>
                <td><span class="badge badge-sm bg-gradient-warning">Kasir</span></td>
                <td class="text-sm">Approve cart CART-007</td>
                <td class="text-xs text-secondary">30 menit yang lalu</td>
                <td><span class="badge badge-sm bg-gradient-success">Sukses</span></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="avatar avatar-sm bg-gradient-success me-3">
                      <span class="text-white text-xs">DK</span>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Dewi Karyawan</h6>
                      <p class="text-xs text-secondary mb-0">dewi@apotek.com</p>
                    </div>
                  </div>
                </td>
                <td><span class="badge badge-sm bg-gradient-info">Karyawan</span></td>
                <td class="text-sm">Update stock opname - Gudang A</td>
                <td class="text-xs text-secondary">1 jam yang lalu</td>
                <td><span class="badge badge-sm bg-gradient-success">Sukses</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
