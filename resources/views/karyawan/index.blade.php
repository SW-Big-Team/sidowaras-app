@extends('layouts.karyawan.app')

@section('title', 'Dashboard Karyawan - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Karyawan</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
</ol>
@endsection

@section('content')
{{-- Welcome Banner --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="welcome-banner">
      <div class="welcome-content">
        <div class="welcome-badge">
          <i class="material-symbols-rounded">verified</i>
          <span>{{ now()->format('l, d F Y') }}</span>
        </div>
        <h2 class="welcome-title">Selamat Datang, {{ Auth::user()->nama ?? 'Karyawan' }}! 👋</h2>
        <p class="welcome-subtitle">Siap untuk memulai shift hari ini? Kelola cart dan pantau stok dengan mudah.</p>
        <div class="welcome-stats">
          <div class="stat-pill">
            <i class="material-symbols-rounded">shopping_cart</i>
            <span>{{ $activeCartCount }} Cart Aktif</span>
          </div>
          <div class="stat-pill">
            <i class="material-symbols-rounded">task_alt</i>
            <span>{{ $stockOpnameProgress }}% Opname</span>
          </div>
        </div>
      </div>
      <div class="welcome-action">
        <a href="{{ route('karyawan.cart.index') }}" class="btn-welcome">
          <i class="material-symbols-rounded">add_shopping_cart</i>
          Input Cart
        </a>
      </div>
      {{-- Floating Icons --}}
      <div class="floating-icon icon-1"><i class="material-symbols-rounded">inventory_2</i></div>
      <div class="floating-icon icon-2"><i class="material-symbols-rounded">qr_code_scanner</i></div>
      <div class="floating-icon icon-3"><i class="material-symbols-rounded">local_pharmacy</i></div>
    </div>
  </div>
</div>

{{-- Metric Cards --}}
<div class="row mb-4">
  @php
    $metrics = [
      ['label' => 'Cart Aktif', 'value' => $activeCartCount, 'sub' => 'Menunggu checkout', 'icon' => 'shopping_cart', 'color' => 'primary'],
      ['label' => 'Stok Opname', 'value' => $stockOpnameProgress . '%', 'sub' => 'Progress hari ini', 'icon' => 'inventory_2', 'color' => 'success'],
      ['label' => 'Item Expired', 'value' => $expiredItemsCount, 'sub' => 'Butuh tindakan', 'icon' => 'event_busy', 'color' => 'danger'],
      ['label' => 'Total Transaksi', 'value' => $totalTransactions, 'sub' => 'Shift ini', 'icon' => 'receipt_long', 'color' => 'info'],
    ];
  @endphp

  @foreach($metrics as $metric)
  <div class="col-xl-3 col-sm-6 mb-4 mb-xl-0">
    <div class="metric-card {{ $metric['color'] }}">
      <div class="metric-content">
        <span class="metric-label">{{ $metric['label'] }}</span>
        <h3 class="metric-value">{{ $metric['value'] }}</h3>
        <span class="metric-sub">{{ $metric['sub'] }}</span>
      </div>
      <div class="metric-icon-wrap">
        <i class="material-symbols-rounded">{{ $metric['icon'] }}</i>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>
  @endforeach
</div>

{{-- Main Content --}}
<div class="row">
  {{-- Left Column: Quick Actions & Progress --}}
  <div class="col-lg-4 mb-4">
    {{-- Quick Actions --}}
    <div class="card pro-card mb-4">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon primary">
            <i class="material-symbols-rounded">bolt</i>
          </div>
          <div>
            <h6 class="header-title">Aksi Cepat</h6>
            <p class="header-subtitle">Menu pintasan</p>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="quick-actions-grid">
          <a href="{{ route('karyawan.cart.index') }}" class="quick-action-card">
            <div class="qa-icon primary"><i class="material-symbols-rounded">point_of_sale</i></div>
            <span class="qa-label">Input Cart</span>
          </a>
          <a href="{{ route('stok.index') }}" class="quick-action-card">
            <div class="qa-icon success"><i class="material-symbols-rounded">qr_code_scanner</i></div>
            <span class="qa-label">Cek Stok</span>
          </a>
          <a href="{{ route('stokopname.index') }}" class="quick-action-card">
            <div class="qa-icon warning"><i class="material-symbols-rounded">inventory_2</i></div>
            <span class="qa-label">Stok Opname</span>
          </a>
          <a href="{{ route('karyawan.transaksi.index') }}" class="quick-action-card">
            <div class="qa-icon info"><i class="material-symbols-rounded">receipt_long</i></div>
            <span class="qa-label">Riwayat</span>
          </a>
        </div>
      </div>
    </div>

    {{-- Stock Opname Progress --}}
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon success">
            <i class="material-symbols-rounded">trending_up</i>
          </div>
          <div>
            <h6 class="header-title">Target Stok Opname</h6>
            <p class="header-subtitle">Progress harian</p>
          </div>
        </div>
        <span class="header-badge primary">Hari Ini</span>
      </div>
      <div class="card-body">
        <div class="progress-display">
          <div class="progress-numbers">
            <span class="progress-current">{{ $stockOpnameChecked }}</span>
            <span class="progress-divider">/</span>
            <span class="progress-total">{{ $stockOpnameTotal }} item</span>
          </div>
          <div class="progress-bar-wrap">
            <div class="progress-bar" style="width: {{ $stockOpnameProgress }}%"></div>
          </div>
          <div class="progress-footer">
            <span><i class="material-symbols-rounded">schedule</i> Progress Harian</span>
            <span class="progress-percent">{{ $stockOpnameProgress }}% Selesai</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Right Column: Recent Activity --}}
  <div class="col-lg-8 mb-4">
    <div class="card pro-card h-100">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon info">
            <i class="material-symbols-rounded">history</i>
          </div>
          <div>
            <h6 class="header-title">Aktivitas Terkini</h6>
            <p class="header-subtitle">Riwayat cart dan transaksi Anda</p>
          </div>
        </div>
        <a href="{{ route('karyawan.transaksi.index') }}" class="view-all-link">
          Lihat Semua
          <i class="material-symbols-rounded">chevron_right</i>
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Total</th>
                <th>Waktu</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentActivities as $activity)
              <tr>
                <td>
                  <div class="activity-cell">
                    <div class="activity-icon {{ $activity['type'] == 'cart' ? 'info' : 'success' }}">
                      <i class="material-symbols-rounded">{{ $activity['type'] == 'cart' ? 'shopping_bag' : 'receipt' }}</i>
                    </div>
                    <div class="activity-info">
                      <span class="activity-id">{{ $activity['type'] == 'cart' ? 'CART-' . substr($activity['uuid'], 0, 8) : $activity['uuid'] }}</span>
                      <span class="activity-items">{{ $activity['items_count'] }} items</span>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="status-badge {{ ($activity['status'] == 'Completed' || $activity['status'] == 'Approved') ? 'success' : 'warning' }}">
                    {{ $activity['status'] }}
                  </span>
                </td>
                <td>
                  <span class="amount-value">Rp {{ number_format($activity['total'], 0, ',', '.') }}</span>
                </td>
                <td>
                  <span class="time-value">{{ $activity['date']->diffForHumans() }}</span>
                </td>
                <td class="text-center">
                  <a href="{{ $activity['type'] == 'cart' ? route('karyawan.cart.show', $activity['id']) : route('karyawan.transaksi.show', $activity['id']) }}" class="action-btn">
                    <i class="material-symbols-rounded">arrow_forward</i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="empty-state">
                    <div class="empty-icon"><i class="material-symbols-rounded">inbox</i></div>
                    <h6>Belum Ada Aktivitas</h6>
                    <p>Aktivitas cart dan transaksi akan muncul di sini</p>
                  </div>
                </td>
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

@section('styles')
@push('styles')
<style>
/* ===== Variables ===== */
:root {
  --primary: #8b5cf6;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --info: #3b82f6;
  --secondary: #64748b;
}

/* ===== Welcome Banner ===== */
.welcome-banner {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);
  border-radius: 20px;
  padding: 2rem 2.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  overflow: hidden;
  color: white;
}

.welcome-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.2);
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.75rem;
  margin-bottom: 12px;
  backdrop-filter: blur(10px);
}
.welcome-badge i { font-size: 14px; }

.welcome-title { font-size: 1.75rem; font-weight: 700; margin: 0 0 8px; }
.welcome-subtitle { font-size: 0.95rem; opacity: 0.9; margin: 0 0 16px; max-width: 500px; }

.welcome-stats { display: flex; gap: 12px; }
.stat-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.15);
  padding: 8px 14px;
  border-radius: 10px;
  font-size: 0.8rem;
  font-weight: 500;
}
.stat-pill i { font-size: 16px; }

.btn-welcome {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 28px;
  background: white;
  color: var(--primary);
  font-size: 0.9rem;
  font-weight: 600;
  border-radius: 12px;
  text-decoration: none;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}
.btn-welcome:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); color: var(--primary); }
.btn-welcome i { font-size: 20px; }

.floating-icon {
  position: absolute;
  opacity: 0.15;
  animation: float 6s ease-in-out infinite;
}
.floating-icon i { font-size: 60px; color: white; }
.icon-1 { top: 20px; right: 15%; animation-delay: 0s; }
.icon-2 { bottom: 15px; right: 25%; animation-delay: 2s; }
.icon-3 { top: 50%; right: 8%; animation-delay: 4s; }

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-15px); }
}

/* ===== Metric Cards ===== */
.metric-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  transition: all 0.3s;
}
.metric-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }

.metric-content { z-index: 1; }
.metric-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
.metric-value { font-size: 1.75rem; font-weight: 700; color: #1e293b; margin: 6px 0; }
.metric-sub { font-size: 0.75rem; color: var(--secondary); }

.metric-icon-wrap {
  width: 56px;
  height: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1;
}
.metric-icon-wrap i { font-size: 28px; color: white; }

.metric-card.primary .metric-icon-wrap { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.metric-card.success .metric-icon-wrap { background: linear-gradient(135deg, #10b981, #059669); }
.metric-card.danger .metric-icon-wrap { background: linear-gradient(135deg, #ef4444, #dc2626); }
.metric-card.info .metric-icon-wrap { background: linear-gradient(135deg, #3b82f6, #2563eb); }

.metric-glow {
  position: absolute;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  right: -30px;
  top: -30px;
  opacity: 0.1;
}
.metric-card.primary .metric-glow { background: var(--primary); }
.metric-card.success .metric-glow { background: var(--success); }
.metric-card.danger .metric-glow { background: var(--danger); }
.metric-card.info .metric-glow { background: var(--info); }

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
  display: flex;
  align-items: center;
  justify-content: center;
}
.header-icon i { color: white; font-size: 20px; }
.header-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.header-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.header-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.header-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }

.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 2px 0 0; }

.header-badge {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.7rem;
  font-weight: 600;
}
.header-badge.primary { background: rgba(139,92,246,0.12); color: var(--primary); }

.view-all-link {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  color: var(--primary);
  font-size: 0.8rem;
  font-weight: 600;
  text-decoration: none;
}
.view-all-link:hover { color: #7c3aed; }
.view-all-link i { font-size: 18px; }

/* ===== Quick Actions Grid ===== */
.quick-actions-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }

.quick-action-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 16px;
  background: #f8fafc;
  border-radius: 12px;
  text-decoration: none;
  transition: all 0.2s;
}
.quick-action-card:hover { background: #f1f5f9; transform: translateY(-2px); }

.qa-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
}
.qa-icon i { font-size: 22px; color: white; }
.qa-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.qa-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.qa-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.qa-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }

.qa-label { font-size: 0.8rem; font-weight: 600; color: #1e293b; }

/* ===== Progress Display ===== */
.progress-display { padding: 10px 0; }

.progress-numbers { display: flex; align-items: baseline; gap: 6px; margin-bottom: 16px; }
.progress-current { font-size: 2rem; font-weight: 700; color: #1e293b; }
.progress-divider { font-size: 1.25rem; color: var(--secondary); }
.progress-total { font-size: 1rem; color: var(--secondary); }

.progress-bar-wrap {
  width: 100%;
  height: 10px;
  background: #f1f5f9;
  border-radius: 5px;
  overflow: hidden;
  margin-bottom: 12px;
}
.progress-bar {
  height: 100%;
  background: linear-gradient(90deg, #8b5cf6, #7c3aed);
  border-radius: 5px;
  transition: width 0.5s;
}

.progress-footer {
  display: flex;
  justify-content: space-between;
  font-size: 0.75rem;
  color: var(--secondary);
}
.progress-footer i { font-size: 14px; vertical-align: middle; margin-right: 4px; }
.progress-percent { font-weight: 600; color: var(--primary); }

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

.activity-cell { display: flex; align-items: center; gap: 12px; }
.activity-icon {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.activity-icon i { font-size: 18px; color: white; }
.activity-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.activity-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }

.activity-info { display: flex; flex-direction: column; }
.activity-id { font-size: 0.85rem; font-weight: 600; color: #1e293b; }
.activity-items { font-size: 0.7rem; color: var(--secondary); }

.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.7rem;
  font-weight: 600;
}
.status-badge.success { background: rgba(16,185,129,0.12); color: var(--success); }
.status-badge.warning { background: rgba(245,158,11,0.12); color: var(--warning); }

.amount-value { font-size: 0.85rem; font-weight: 600; color: #1e293b; }
.time-value { font-size: 0.8rem; color: var(--secondary); }

.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  background: #f1f5f9;
  border-radius: 8px;
  color: var(--secondary);
  transition: all 0.2s;
}
.action-btn:hover { background: var(--primary); color: white; }
.action-btn i { font-size: 18px; }

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
.empty-state h6 { color: #1e293b; margin-bottom: 6px; }
.empty-state p { font-size: 0.85rem; color: var(--secondary); margin: 0; }

@media (max-width: 768px) {
  .welcome-banner { flex-direction: column; text-align: center; gap: 20px; }
  .welcome-stats { justify-content: center; }
  .welcome-action { width: 100%; }
  .btn-welcome { width: 100%; justify-content: center; }
}
</style>
@endpush
@endsection
