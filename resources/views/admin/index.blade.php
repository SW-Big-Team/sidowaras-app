@extends('layouts.admin.app')

@section('title', 'Dashboard Administrator - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard Administrator</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="welcome-banner">
      <div class="welcome-content">
        <div class="welcome-text">
          <span class="greeting-badge">
            <i class="material-symbols-rounded">waving_hand</i>
            Selamat Datang Kembali
          </span>
          <h2 class="welcome-title">{{ Auth::user()->name ?? 'Administrator' }}</h2>
          <p class="welcome-subtitle">Pantau seluruh aktivitas bisnis dan kelola sistem apotek Anda dengan mudah.</p>
        </div>
        <div class="welcome-stats">
          <div class="stat-pill">
            <i class="material-symbols-rounded">trending_up</i>
            <span>{{ $todayTransactionsCount }} transaksi hari ini</span>
          </div>
          <div class="stat-pill warning">
            <i class="material-symbols-rounded">schedule</i>
            <span>{{ now()->format('l, d M Y') }}</span>
          </div>
        </div>
      </div>
      <div class="welcome-illustration">
        <div class="floating-icon icon-1"><i class="material-symbols-rounded">analytics</i></div>
        <div class="floating-icon icon-2"><i class="material-symbols-rounded">inventory_2</i></div>
        <div class="floating-icon icon-3"><i class="material-symbols-rounded">payments</i></div>
      </div>
    </div>
  </div>
</div>

{{-- Key Metrics Cards --}}
<div class="row g-3 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="metric-card success">
      <div class="metric-icon">
        <i class="material-symbols-rounded">payments</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Penjualan Hari Ini</span>
        <h3 class="metric-value">Rp {{ number_format($salesToday, 0, ',', '.') }}</h3>
        <div class="metric-change {{ $salesGrowthToday >= 0 ? 'positive' : 'negative' }}">
          <i class="material-symbols-rounded">{{ $salesGrowthToday >= 0 ? 'trending_up' : 'trending_down' }}</i>
          <span>{{ $salesGrowthToday >= 0 ? '+' : '' }}{{ number_format($salesGrowthToday, 1) }}% dari kemarin</span>
        </div>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="metric-card warning">
      <div class="metric-icon">
        <i class="material-symbols-rounded">calendar_month</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Penjualan Bulan Ini</span>
        <h3 class="metric-value">Rp {{ number_format($salesMonth, 0, ',', '.') }}</h3>
        <div class="metric-change {{ $salesGrowthMonth >= 0 ? 'positive' : 'negative' }}">
          <i class="material-symbols-rounded">{{ $salesGrowthMonth >= 0 ? 'trending_up' : 'trending_down' }}</i>
          <span>{{ $salesGrowthMonth >= 0 ? '+' : '' }}{{ number_format($salesGrowthMonth, 1) }}% dari bulan lalu</span>
        </div>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="metric-card info">
      <div class="metric-icon">
        <i class="material-symbols-rounded">group</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Total Pengguna</span>
        <h3 class="metric-value">{{ $totalUsers }} Users</h3>
        <div class="metric-badges">
          <span class="mini-badge">{{ $adminCount }} Admin</span>
          <span class="mini-badge">{{ $kasirCount }} Kasir</span>
          <span class="mini-badge">{{ $karyawanCount }} Staff</span>
        </div>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="metric-card primary">
      <div class="metric-icon">
        <i class="material-symbols-rounded">inventory</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Nilai Stok</span>
        <h3 class="metric-value">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</h3>
        <div class="metric-change neutral">
          <i class="material-symbols-rounded">store</i>
          <span>Total nilai inventory</span>
        </div>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>
</div>

{{-- Quick Stats Bar --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="quick-stats-bar">
      <div class="quick-stat">
        <div class="qs-icon success"><i class="material-symbols-rounded">receipt_long</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $todayTransactionsCount }}</span>
          <span class="qs-label">Transaksi</span>
        </div>
      </div>
      <div class="qs-divider"></div>
      <div class="quick-stat">
        <div class="qs-icon info"><i class="material-symbols-rounded">shopping_cart</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $pendingCartsCount }}</span>
          <span class="qs-label">Cart Pending</span>
        </div>
      </div>
      <div class="qs-divider"></div>
      <div class="quick-stat">
        <div class="qs-icon warning"><i class="material-symbols-rounded">inventory_2</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $minStockCount }}</span>
          <span class="qs-label">Stok Minimum</span>
        </div>
      </div>
      <div class="qs-divider"></div>
      <div class="quick-stat">
        <div class="qs-icon danger"><i class="material-symbols-rounded">warning</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $expiredCount }}</span>
          <span class="qs-label">Expired</span>
        </div>
      </div>
      <div class="qs-divider"></div>
      <div class="quick-stat">
        <div class="qs-icon primary"><i class="material-symbols-rounded">pending_actions</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $pendingOpnameCount }}</span>
          <span class="qs-label">Opname Pending</span>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Main Content Grid --}}
<div class="row g-3">
  {{-- Left Column --}}
  <div class="col-lg-8">
    {{-- Recent Transactions --}}
    <div class="card pro-card mb-4">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon">
            <i class="material-symbols-rounded">receipt_long</i>
          </div>
          <div>
            <h6 class="header-title">Transaksi Terbaru</h6>
            <p class="header-subtitle">Monitoring real-time transaksi hari ini</p>
          </div>
        </div>
        <a href="{{ route('admin.transaksi.riwayat') }}" class="btn-pro">
          Lihat Semua
          <i class="material-symbols-rounded">arrow_forward</i>
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Waktu</th>
                <th>Total</th>
                <th class="text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentTransactions as $trx)
              <tr>
                <td>
                  <span class="transaction-id">{{ $trx->no_transaksi }}</span>
                </td>
                <td>
                  <div class="user-cell">
                    <div class="user-avatar">{{ strtoupper(substr($trx->user->name ?? 'U', 0, 1)) }}</div>
                    <span>{{ $trx->user->name ?? 'Unknown' }}</span>
                  </div>
                </td>
                <td>
                  <span class="time-badge">
                    <i class="material-symbols-rounded">schedule</i>
                    {{ $trx->tgl_transaksi->format('H:i') }}
                  </span>
                </td>
                <td>
                  <span class="amount">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</span>
                </td>
                <td class="text-center">
                  <span class="status-badge success">
                    <i class="material-symbols-rounded">check_circle</i>
                    Selesai
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="empty-state">
                    <div class="empty-icon"><i class="material-symbols-rounded">receipt_long</i></div>
                    <h6>Belum ada transaksi hari ini</h6>
                    <p>Transaksi akan muncul di sini secara real-time</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- User Activity Log --}}
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon info">
            <i class="material-symbols-rounded">history</i>
          </div>
          <div>
            <h6 class="header-title">Aktivitas Pengguna</h6>
            <p class="header-subtitle">Monitoring aktivitas sistem real-time</p>
          </div>
        </div>
        <form action="{{ route('admin.dashboard') }}" method="GET" id="roleFilterForm">
          <select name="role" class="filter-select" onchange="document.getElementById('roleFilterForm').submit()">
            <option value="">Semua Role</option>
            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
            <option value="Kasir" {{ request('role') == 'Kasir' ? 'selected' : '' }}>Kasir</option>
            <option value="Karyawan" {{ request('role') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
          </select>
        </form>
      </div>
      <div class="card-body p-0">
        <div class="activity-list">
          @forelse($activities as $activity)
          <div class="activity-item">
            <div class="activity-avatar {{ $activity['type'] == 'success' ? 'success' : 'info' }}">
              {{ strtoupper(substr($activity['user']->name ?? 'U', 0, 2)) }}
            </div>
            <div class="activity-content">
              <div class="activity-main">
                <span class="activity-user">{{ $activity['user']->name ?? 'Unknown' }}</span>
                <span class="activity-action">{{ $activity['action'] }}</span>
              </div>
              <div class="activity-meta">
                @php
                  $role = $activity['user']->role->nama_role ?? 'User';
                  $roleClass = match($role) {
                    'Admin' => 'primary',
                    'Kasir' => 'warning',
                    'Karyawan' => 'info',
                    default => 'secondary'
                  };
                @endphp
                <span class="role-badge {{ $roleClass }}">{{ $role }}</span>
                <span class="activity-time">
                  <i class="material-symbols-rounded">schedule</i>
                  {{ $activity['time']->diffForHumans() }}
                </span>
              </div>
            </div>
            <div class="activity-status {{ $activity['type'] }}">
              <i class="material-symbols-rounded">{{ $activity['type'] == 'success' ? 'check_circle' : 'info' }}</i>
            </div>
          </div>
          @empty
          <div class="empty-state py-5">
            <div class="empty-icon"><i class="material-symbols-rounded">history</i></div>
            <h6>Belum ada aktivitas terbaru</h6>
            <p>Aktivitas pengguna akan muncul di sini</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  {{-- Right Column --}}
  <div class="col-lg-4">
    {{-- Financial Summary --}}
    <div class="card pro-card mb-4">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon success">
            <i class="material-symbols-rounded">account_balance</i>
          </div>
          <div>
            <h6 class="header-title">Laporan Keuangan</h6>
            <p class="header-subtitle">Bulan {{ now()->format('F Y') }}</p>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="finance-grid">
          <div class="finance-item highlight">
            <div class="finance-label">Revenue</div>
            <div class="finance-value success">Rp {{ number_format($salesMonth, 0, ',', '.') }}</div>
          </div>
          <div class="finance-item">
            <div class="finance-label">HPP</div>
            <div class="finance-value">Rp {{ number_format($hppMonth, 0, ',', '.') }}</div>
          </div>
          <div class="finance-item">
            <div class="finance-label">Net Profit</div>
            <div class="finance-value success">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
          </div>
          <div class="finance-item">
            <div class="finance-label">Profit Margin</div>
            <div class="finance-value primary">{{ number_format($profitMargin, 1) }}%</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Stock Alerts --}}
    <div class="card pro-card mb-4">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon warning">
            <i class="material-symbols-rounded">notifications_active</i>
          </div>
          <div>
            <h6 class="header-title">Peringatan Stok</h6>
            <p class="header-subtitle">Perlu tindakan segera</p>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="alert-list">
          <a href="{{ route('admin.stok.index', ['status' => 'expired']) }}" class="alert-item danger">
            <div class="alert-icon"><i class="material-symbols-rounded">error</i></div>
            <div class="alert-content">
              <span class="alert-title">Obat Kadaluarsa</span>
              <span class="alert-count">{{ $expiredCount }} item</span>
            </div>
            <i class="material-symbols-rounded alert-arrow">chevron_right</i>
          </a>
          
          <a href="{{ route('admin.stok.index', ['status' => 'rendah']) }}" class="alert-item warning">
            <div class="alert-icon"><i class="material-symbols-rounded">inventory_2</i></div>
            <div class="alert-content">
              <span class="alert-title">Stok Minimum</span>
              <span class="alert-count">{{ $minStockCount }} item</span>
            </div>
            <i class="material-symbols-rounded alert-arrow">chevron_right</i>
          </a>
          
          <a href="{{ route('admin.stokopname.pending') }}" class="alert-item info">
            <div class="alert-icon"><i class="material-symbols-rounded">pending_actions</i></div>
            <div class="alert-content">
              <span class="alert-title">Opname Pending</span>
              <span class="alert-count">{{ $pendingOpnameCount }} laporan</span>
            </div>
            <i class="material-symbols-rounded alert-arrow">chevron_right</i>
          </a>
        </div>
      </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon primary">
            <i class="material-symbols-rounded">flash_on</i>
          </div>
          <div>
            <h6 class="header-title">Aksi Cepat</h6>
            <p class="header-subtitle">Navigasi cepat ke fitur utama</p>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="quick-actions">
          <a href="{{ route('admin.users.index') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">group</i>
            <span>Pengguna</span>
          </a>
          <a href="{{ route('admin.obat.index') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">medication</i>
            <span>Data Obat</span>
          </a>
          <a href="{{ route('admin.stok.index') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">inventory_2</i>
            <span>Stok</span>
          </a>
          <a href="{{ route('admin.laporan.index') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">analytics</i>
            <span>Laporan</span>
          </a>
          <a href="{{ route('kasir.dashboard') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">point_of_sale</i>
            <span>Kasir</span>
          </a>
          <a href="{{ route('karyawan.dashboard') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">badge</i>
            <span>Karyawan</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
/* ===== Variables ===== */
:root {
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --info: #3b82f6;
  --primary: #8b5cf6;
  --secondary: #64748b;
}

/* ===== Welcome Banner ===== */
.welcome-banner {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 16px;
  padding: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.welcome-content { position: relative; z-index: 2; }

.greeting-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.2);
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  color: white;
  font-weight: 500;
  margin-bottom: 12px;
}

.welcome-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: white;
  margin: 0 0 8px;
}

.welcome-subtitle {
  color: rgba(255,255,255,0.85);
  font-size: 0.9rem;
  margin: 0 0 16px;
  max-width: 500px;
}

.welcome-stats { display: flex; gap: 10px; flex-wrap: wrap; }

.stat-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.2);
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 0.8rem;
  color: white;
  font-weight: 500;
  backdrop-filter: blur(10px);
}

.welcome-illustration {
  position: absolute;
  right: 2rem;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  gap: 1rem;
}

.floating-icon {
  width: 50px;
  height: 50px;
  background: rgba(255,255,255,0.15);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: float 3s ease-in-out infinite;
  backdrop-filter: blur(10px);
}

.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
.floating-icon.icon-3 { animation-delay: 1s; }

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

/* ===== Metric Cards ===== */
.metric-card {
  background: white;
  border-radius: 16px;
  padding: 1.25rem;
  display: flex;
  gap: 1rem;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  transition: all 0.3s ease;
}

.metric-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.metric-icon {
  width: 52px;
  height: 52px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.metric-icon i { font-size: 26px; }

.metric-card.success .metric-icon { background: rgba(16,185,129,0.12); }
.metric-card.success .metric-icon i { color: var(--success); }
.metric-card.warning .metric-icon { background: rgba(245,158,11,0.12); }
.metric-card.warning .metric-icon i { color: var(--warning); }
.metric-card.info .metric-icon { background: rgba(59,130,246,0.12); }
.metric-card.info .metric-icon i { color: var(--info); }
.metric-card.primary .metric-icon { background: rgba(139,92,246,0.12); }
.metric-card.primary .metric-icon i { color: var(--primary); }

.metric-content { flex: 1; min-width: 0; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
.metric-value { font-size: 1.35rem; font-weight: 700; color: #1e293b; margin: 4px 0; }

.metric-change {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 0.75rem;
  font-weight: 500;
}
.metric-change i { font-size: 16px; }
.metric-change.positive { color: var(--success); }
.metric-change.negative { color: var(--danger); }
.metric-change.neutral { color: var(--secondary); }

.metric-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 6px; }
.mini-badge {
  font-size: 0.65rem;
  padding: 3px 8px;
  background: #f1f5f9;
  border-radius: 6px;
  color: var(--secondary);
  font-weight: 500;
}

.metric-glow {
  position: absolute;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  right: -30px;
  bottom: -30px;
  opacity: 0.1;
}

.metric-card.success .metric-glow { background: var(--success); }
.metric-card.warning .metric-glow { background: var(--warning); }
.metric-card.info .metric-glow { background: var(--info); }
.metric-card.primary .metric-glow { background: var(--primary); }

/* ===== Quick Stats Bar ===== */
.quick-stats-bar {
  background: white;
  border-radius: 12px;
  padding: 1rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-around;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
  flex-wrap: wrap;
  gap: 1rem;
}

.quick-stat { display: flex; align-items: center; gap: 12px; }
.qs-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.qs-icon i { font-size: 20px; }
.qs-icon.success { background: rgba(16,185,129,0.12); }
.qs-icon.success i { color: var(--success); }
.qs-icon.info { background: rgba(59,130,246,0.12); }
.qs-icon.info i { color: var(--info); }
.qs-icon.warning { background: rgba(245,158,11,0.12); }
.qs-icon.warning i { color: var(--warning); }
.qs-icon.danger { background: rgba(239,68,68,0.12); }
.qs-icon.danger i { color: var(--danger); }
.qs-icon.primary { background: rgba(139,92,246,0.12); }
.qs-icon.primary i { color: var(--primary); }

.qs-content { display: flex; flex-direction: column; }
.qs-value { font-size: 1.25rem; font-weight: 700; color: #1e293b; line-height: 1; }
.qs-label { font-size: 0.7rem; color: var(--secondary); margin-top: 2px; }
.qs-divider { width: 1px; height: 30px; background: #e2e8f0; }

/* ===== Pro Cards ===== */
.pro-card {
  background: white;
  border-radius: 16px;
  border: none;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  overflow: hidden;
}

.pro-card-header {
  padding: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #f1f5f9;
  background: white;
}

.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
}
.header-icon i { color: white; font-size: 20px; }
.header-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.header-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.header-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.header-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }

.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 2px 0 0; }

.btn-pro {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  font-size: 0.8rem;
  font-weight: 500;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.2s;
}
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102,126,234,0.4); color: white; }
.btn-pro i { font-size: 16px; }

.filter-select {
  padding: 8px 32px 8px 12px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.8rem;
  color: #475569;
  background: white url("data:image/svg+xml,...") no-repeat right 10px center;
  cursor: pointer;
}

/* ===== Pro Table ===== */
.pro-table { margin: 0; }
.pro-table thead { background: #f8fafc; }
.pro-table th {
  font-size: 0.7rem;
  font-weight: 600;
  color: var(--secondary);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 12px 16px;
  border: none;
}
.pro-table td {
  padding: 14px 16px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
}
.pro-table tbody tr:hover { background: #f8fafc; }

.transaction-id {
  font-family: monospace;
  font-weight: 600;
  color: var(--info);
  background: rgba(59,130,246,0.1);
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 0.8rem;
}

.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: 600;
}

.time-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 0.8rem;
  color: var(--secondary);
}
.time-badge i { font-size: 14px; }

.amount { font-weight: 600; color: #1e293b; }

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 5px 10px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
}
.status-badge.success { background: rgba(16,185,129,0.12); color: var(--success); }
.status-badge i { font-size: 14px; }

.empty-state { text-align: center; padding: 2rem; }
.empty-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 12px;
}
.empty-icon i { font-size: 28px; color: var(--secondary); }
.empty-state h6 { color: #475569; margin-bottom: 4px; }
.empty-state p { font-size: 0.8rem; color: var(--secondary); margin: 0; }

/* ===== Activity List ===== */
.activity-list { max-height: 400px; overflow-y: auto; }
.activity-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 20px;
  border-bottom: 1px solid #f1f5f9;
  transition: background 0.2s;
}
.activity-item:hover { background: #f8fafc; }

.activity-avatar {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: 600;
  color: white;
  flex-shrink: 0;
}
.activity-avatar.success { background: linear-gradient(135deg, #10b981, #059669); }
.activity-avatar.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }

.activity-content { flex: 1; min-width: 0; }
.activity-main { margin-bottom: 4px; }
.activity-user { font-weight: 600; color: #1e293b; font-size: 0.875rem; }
.activity-action { color: var(--secondary); font-size: 0.8rem; margin-left: 6px; }

.activity-meta { display: flex; align-items: center; gap: 10px; }
.role-badge {
  font-size: 0.65rem;
  padding: 3px 8px;
  border-radius: 6px;
  font-weight: 500;
}
.role-badge.primary { background: rgba(139,92,246,0.12); color: var(--primary); }
.role-badge.warning { background: rgba(245,158,11,0.12); color: var(--warning); }
.role-badge.info { background: rgba(59,130,246,0.12); color: var(--info); }
.role-badge.secondary { background: #f1f5f9; color: var(--secondary); }

.activity-time {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 0.7rem;
  color: var(--secondary);
}
.activity-time i { font-size: 12px; }

.activity-status {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.activity-status.success { background: rgba(16,185,129,0.12); }
.activity-status.success i { color: var(--success); font-size: 16px; }
.activity-status.info { background: rgba(59,130,246,0.12); }
.activity-status.info i { color: var(--info); font-size: 16px; }

/* ===== Finance Grid ===== */
.finance-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.finance-item {
  background: #f8fafc;
  border-radius: 10px;
  padding: 14px;
  text-align: center;
}
.finance-item.highlight { grid-column: 1 / -1; background: linear-gradient(135deg, #ecfdf5, #d1fae5); }
.finance-label { font-size: 0.7rem; color: var(--secondary); margin-bottom: 6px; text-transform: uppercase; font-weight: 500; }
.finance-value { font-size: 1rem; font-weight: 700; color: #1e293b; }
.finance-value.success { color: var(--success); }
.finance-value.primary { color: var(--primary); }
.finance-item.highlight .finance-value { font-size: 1.25rem; }

/* ===== Alert List ===== */
.alert-list { padding: 0; }
.alert-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 20px;
  border-bottom: 1px solid #f1f5f9;
  text-decoration: none;
  transition: all 0.2s;
}
.alert-item:hover { background: #f8fafc; }
.alert-item:hover .alert-arrow { transform: translateX(4px); }

.alert-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.alert-item.danger .alert-icon { background: rgba(239,68,68,0.12); }
.alert-item.danger .alert-icon i { color: var(--danger); }
.alert-item.warning .alert-icon { background: rgba(245,158,11,0.12); }
.alert-item.warning .alert-icon i { color: var(--warning); }
.alert-item.info .alert-icon { background: rgba(59,130,246,0.12); }
.alert-item.info .alert-icon i { color: var(--info); }

.alert-content { flex: 1; }
.alert-title { display: block; font-weight: 600; color: #1e293b; font-size: 0.875rem; }
.alert-count { font-size: 0.75rem; color: var(--secondary); }

.alert-arrow { color: var(--secondary); transition: transform 0.2s; }

/* ===== Quick Actions ===== */
.quick-actions { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.quick-action-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  padding: 14px 10px;
  background: #f8fafc;
  border-radius: 12px;
  text-decoration: none;
  transition: all 0.2s;
}
.quick-action-btn:hover {
  background: linear-gradient(135deg, #667eea, #764ba2);
  transform: translateY(-2px);
}
.quick-action-btn i { font-size: 24px; color: var(--primary); transition: color 0.2s; }
.quick-action-btn span { font-size: 0.7rem; font-weight: 500; color: #475569; transition: color 0.2s; }
.quick-action-btn:hover i, .quick-action-btn:hover span { color: white; }

/* ===== Responsive ===== */
@media (max-width: 768px) {
  .welcome-banner { flex-direction: column; text-align: center; }
  .welcome-stats { justify-content: center; }
  .welcome-illustration { display: none; }
  .qs-divider { display: none; }
  .quick-stats-bar { justify-content: flex-start; }
}
</style>
@endpush
