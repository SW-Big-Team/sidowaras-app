@extends('layouts.admin.app')

@section('title', 'Dashboard Administrator - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard Administrator</li>
</ol>
@endsection

@section('content')
<div class="row mb-4">
  <div class="col-12">
    <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-md-8">
            <div class="d-flex align-items-center">
              <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3 d-flex align-items-center justify-content-center">
                <i class="material-symbols-rounded text-dark">dashboard</i>
              </div>
              <div>
                <h4 class="mb-1 text-white fw-bold">Dashboard Administrator</h4>
                <p class="text-sm text-white opacity-8 mb-0">Kelola seluruh sistem, monitor transaksi, laporan keuangan & stok, serta manajemen pengguna.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  
  {{-- Key Metrics Cards --}}
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card border-0 shadow-sm rounded-3 summary-card">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                Penjualan Hari Ini
            </p>
            <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($salesToday, 0, ',', '.') }}</h4>
            <p class="mb-0 text-xxs text-muted mt-1">
                <span class="{{ $salesGrowthToday >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                    {{ $salesGrowthToday >= 0 ? '+' : '' }}{{ number_format($salesGrowthToday, 1) }}% 
                </span>
                dari kemarin
            </p>
          </div>
          <div class="summary-icon bg-soft-success">
            <i class="material-symbols-rounded text-success">payments</i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card border-0 shadow-sm rounded-3 summary-card">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                Penjualan Bulan Ini
            </p>
            <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($salesMonth, 0, ',', '.') }}</h4>
            <p class="mb-0 text-xxs text-muted mt-1">
                <span class="{{ $salesGrowthMonth >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                    {{ $salesGrowthMonth >= 0 ? '+' : '' }}{{ number_format($salesGrowthMonth, 1) }}% 
                </span>
                dari bulan lalu
            </p>
          </div>
          <div class="summary-icon bg-soft-warning">
            <i class="material-symbols-rounded text-warning">calendar_month</i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card border-0 shadow-sm rounded-3 summary-card">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                Total Pengguna
            </p>
            <h4 class="mb-0 text-dark fw-bold">{{ $totalUsers }} Users</h4>
            <p class="mb-0 text-xxs text-muted mt-1">
                {{ $adminCount }} Admin | {{ $kasirCount }} Kasir
            </p>
          </div>
          <div class="summary-icon bg-soft-info">
            <i class="material-symbols-rounded text-info">group</i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-3 summary-card">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                Nilai Stok
            </p>
            <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</h4>
            <p class="mb-0 text-xxs text-muted mt-1">Total nilai inventory</p>
          </div>
          <div class="summary-icon bg-soft-primary">
            <i class="material-symbols-rounded text-primary">inventory</i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- System Management & Quick Actions --}}
<div class="row mt-4">
  <div class="col-lg-4 mb-4">
    <div class="card h-100 border-0 shadow-sm rounded-3">
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
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $totalUsers }} pengguna terdaftar</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-gradient-info">
              <i class="material-symbols-rounded text-white text-sm">admin_panel_settings</i>
            </span>
            <div class="timeline-content">
              <a href="{{ route('karyawan.dashboard') }}" class="text-dark text-sm font-weight-bold">Dashboard Karyawan</a>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $karyawanCount }} karyawan aktif</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-gradient-warning">
              <i class="material-symbols-rounded text-white text-sm">point_of_sale</i>
            </span>
            <div class="timeline-content">
              <a href="{{ route('kasir.dashboard') }}" class="text-dark text-sm font-weight-bold">Dashboard Kasir</a>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $kasirCount }} kasir aktif</p>
            </div>
          </div>
          <div class="timeline-block">
            <span class="timeline-step bg-gradient-primary">
              <i class="material-symbols-rounded text-white text-sm">inventory</i>
            </span>
            <div class="timeline-content">
              <a href="{{ route('admin.obat.index') }}" class="text-dark text-sm font-weight-bold">Kelola Stok Obat</a>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Manajemen data obat</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8 mb-4">
    <div class="card h-100 border-0 shadow-sm rounded-3">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
          <div>
            <h6>Monitoring Transaksi Hari Ini</h6>
            <p class="text-sm mb-0">Real-time transaction monitoring</p>
          </div>
          <div>
            <a href="{{ route('admin.transaksi.riwayat') }}" class="btn btn-sm btn-outline-primary mb-0">Lihat Semua</a>
          </div>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-success border-radius-lg">
              <h3 class="text-white mb-0">{{ $todayTransactionsCount }}</h3>
              <p class="text-white text-sm mb-0">Transaksi</p>
            </div>
          </div>
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-info border-radius-lg">
              <h3 class="text-white mb-0">{{ $pendingCartsCount }}</h3>
              <p class="text-white text-sm mb-0">Cart Pending</p>
            </div>
          </div>
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-warning border-radius-lg">
              <h3 class="text-white mb-0">{{ $minStockCount }}</h3>
              <p class="text-white text-sm mb-0">Stok Minimum</p>
            </div>
          </div>
          <div class="col-md-3 text-center mb-3">
            <div class="p-3 bg-gradient-danger border-radius-lg">
              <h3 class="text-white mb-0">{{ $expiredCount }}</h3>
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
              @forelse($recentTransactions as $trx)
              <tr>
                <td class="text-sm">{{ $trx->no_transaksi }}</td>
                <td class="text-sm">{{ $trx->user->name ?? 'Unknown' }}</td>
                <td class="text-xs text-secondary">{{ $trx->tgl_transaksi->format('H:i') }}</td>
                <td class="text-sm font-weight-bold">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                <td><span class="badge badge-sm bg-gradient-success">Selesai</span></td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center text-sm text-muted py-4">Belum ada transaksi hari ini</td>
              </tr>
              @endforelse
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
    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-header pb-0">
        <h6>Laporan Keuangan</h6>
        <p class="text-sm mb-0">Financial performance overview (Bulan Ini)</p>
      </div>
      <div class="card-body p-3">
        <div class="row mb-3">
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">Revenue Bulan Ini</p>
              <h5 class="mb-0 text-success">Rp {{ number_format($salesMonth, 0, ',', '.') }}</h5>
            </div>
          </div>
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">Profit Margin</p>
              <h5 class="mb-0 text-primary">{{ number_format($profitMargin, 1) }}%</h5>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">HPP</p>
              <h6 class="mb-0">Rp {{ number_format($hppMonth, 0, ',', '.') }}</h6>
            </div>
          </div>
          <div class="col-6 text-center">
            <div class="p-3 bg-light border-radius-md">
              <p class="text-xs mb-0 text-muted">Net Profit</p>
              <h6 class="mb-0 text-success">Rp {{ number_format($netProfit, 0, ',', '.') }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mb-4">
    <div class="card h-100 border-0 shadow-sm rounded-3">
      <div class="card-header pb-0">
        <h6>Laporan Stok</h6>
        <p class="text-sm mb-0">Inventory status & alerts</p>
      </div>
      <div class="card-body p-3">
        <div class="list-group list-group-flush">
          {{-- Obat Kadaluarsa --}}
          <div class="list-group-item px-3 py-3 border-0 mb-2 bg-light rounded">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="icon icon-shape bg-gradient-danger text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                  <i class="material-symbols-rounded">warning</i>
                </div>
                <div>
                  <h6 class="mb-0 text-sm font-weight-bold">Obat Kadaluarsa</h6>
                  <p class="text-xs text-muted mb-0"><strong>{{ $expiredCount }} item</strong> perlu ditindaklanjuti</p>
                </div>
              </div>
              <div>
                <a href="{{ route('admin.obat.index', ['filter' => 'expired']) }}" class="btn btn-sm btn-outline-danger mb-0">Lihat</a>
              </div>
            </div>
          </div>

          {{-- Stok Minimum --}}
          <div class="list-group-item px-3 py-3 border-0 mb-2 bg-light rounded">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="icon icon-shape bg-gradient-warning text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                  <i class="material-symbols-rounded">inventory_2</i>
                </div>
                <div>
                  <h6 class="mb-0 text-sm font-weight-bold">Stok Minimum</h6>
                  <p class="text-xs text-muted mb-0"><strong>{{ $minStockCount }} item</strong> di bawah minimum</p>
                </div>
              </div>
              <div>
                <a href="{{ route('admin.obat.index', ['filter' => 'min_stock']) }}" class="btn btn-sm btn-outline-warning mb-0">Lihat</a>
              </div>
            </div>
          </div>

          {{-- Stok Opname Pending --}}
          <div class="list-group-item px-3 py-3 border-0 mb-0 bg-light rounded">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="icon icon-shape bg-gradient-info text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                  <i class="material-symbols-rounded">trending_up</i>
                </div>
                <div>
                  <h6 class="mb-0 text-sm font-weight-bold">Stok Opname Pending</h6>
                  <p class="text-xs text-muted mb-0"><strong>{{ $pendingOpnameCount }} laporan</strong> menunggu review</p>
                </div>
              </div>
              <div>
                <a href="{{ route('admin.stokopname.pending') }}" class="btn btn-sm btn-outline-info mb-0">Review</a>
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
    <div class="card border-0 shadow-sm rounded-3">
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
              @forelse($activities as $activity)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="avatar avatar-sm bg-gradient-{{ $activity['type'] == 'success' ? 'success' : 'info' }} me-3">
                      <span class="text-white text-xs">{{ substr($activity['user']->name ?? 'U', 0, 2) }}</span>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $activity['user']->name ?? 'Unknown' }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $activity['user']->email ?? '' }}</p>
                    </div>
                  </div>
                </td>
                <td><span class="badge badge-sm bg-gradient-{{ ($activity['user']->role->nama_role ?? '') == 'Kasir' ? 'warning' : 'info' }}">{{ $activity['user']->role->nama_role ?? 'User' }}</span></td>
                <td class="text-sm">{{ $activity['action'] }}</td>
                <td class="text-xs text-secondary">{{ $activity['time']->diffForHumans() }}</td>
                <td><span class="badge badge-sm bg-gradient-{{ $activity['type'] == 'success' ? 'success' : 'warning' }}">{{ $activity['status'] }}</span></td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center text-sm text-muted py-4">Belum ada aktivitas terbaru</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
    .text-xxs { font-size: 0.65rem !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }

    .summary-card {
        transition: all 0.2s ease-in-out;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.07) !important;
    }
    .summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
    .bg-soft-danger  { background: rgba(220, 53, 69, 0.10) !important; }
    .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
    .bg-soft-secondary { background: rgba(108, 117, 125, 0.08) !important; }
    .bg-soft-info { background: rgba(23, 162, 184, 0.12) !important; }
    .bg-soft-dark { background: rgba(52, 71, 103, 0.15) !important; }

    .card {
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .rounded-3 { border-radius: 0.75rem !important; }
</style>
@endpush
