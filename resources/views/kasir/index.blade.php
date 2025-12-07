@extends('layouts.kasir.app')

@section('title', 'Dashboard Kasir - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard Kasir</li>
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
            <i class="material-symbols-rounded">point_of_sale</i>
            Panel Kasir
          </span>
          <h2 class="welcome-title">{{ Auth::user()->nama_lengkap ?? Auth::user()->nama ?? 'Kasir' }}</h2>
          <p class="welcome-subtitle">Kelola approval cart dan monitor transaksi penjualan harian.</p>
        </div>
        <div class="welcome-stats">
          <div class="stat-pill">
            <i class="material-symbols-rounded">receipt_long</i>
            <span>{{ $todayTransactionsCount }} transaksi hari ini</span>
          </div>
          <div class="stat-pill warning">
            <i class="material-symbols-rounded">schedule</i>
            <span>{{ now()->format('l, d M Y') }}</span>
          </div>
        </div>
      </div>
      <div class="welcome-illustration">
        <div class="floating-icon icon-1"><i class="material-symbols-rounded">payments</i></div>
        <div class="floating-icon icon-2"><i class="material-symbols-rounded">shopping_cart</i></div>
        <div class="floating-icon icon-3"><i class="material-symbols-rounded">receipt_long</i></div>
      </div>
    </div>
  </div>
</div>

{{-- Key Metrics Cards --}}
<div class="row g-3 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="metric-card warning">
      <div class="metric-icon">
        <i class="material-symbols-rounded">pending_actions</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Cart Menunggu</span>
        <h3 class="metric-value">{{ $pendingCartsCount }}</h3>
        <div class="metric-change {{ $pendingCartsCount > 0 ? 'negative' : 'positive' }}">
          <i class="material-symbols-rounded">{{ $pendingCartsCount > 0 ? 'priority_high' : 'check_circle' }}</i>
          <span>{{ $pendingCartsCount > 0 ? 'Butuh approval' : 'Semua bersih' }}</span>
        </div>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="metric-card success">
      <div class="metric-icon">
        <i class="material-symbols-rounded">receipt_long</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Transaksi Hari Ini</span>
        <h3 class="metric-value">{{ $todayTransactionsCount }}</h3>
        <div class="metric-change positive">
          <i class="material-symbols-rounded">trending_up</i>
          <span>+{{ $todayTransactionsCount }} transaksi baru</span>
        </div>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="metric-card info">
      <div class="metric-icon">
        <i class="material-symbols-rounded">payments</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Penjualan Hari Ini</span>
        <h3 class="metric-value">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
        <div class="metric-change neutral">
          <i class="material-symbols-rounded">store</i>
          <span>Total pendapatan</span>
        </div>
      </div>
      <div class="metric-glow"></div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="metric-card danger">
      <div class="metric-icon">
        <i class="material-symbols-rounded">inventory_2</i>
      </div>
      <div class="metric-content">
        <span class="metric-label">Stok Minimum</span>
        <h3 class="metric-value">{{ $lowStockCount }} Item</h3>
        <div class="metric-change {{ $lowStockCount > 0 ? 'negative' : 'positive' }}">
          <i class="material-symbols-rounded">{{ $lowStockCount > 0 ? 'warning' : 'check_circle' }}</i>
          <span>{{ $lowStockCount > 0 ? 'Perlu restock' : 'Stok aman' }}</span>
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
        <div class="qs-icon warning"><i class="material-symbols-rounded">shopping_cart</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $pendingCartsCount }}</span>
          <span class="qs-label">Cart Pending</span>
        </div>
      </div>
      <div class="qs-divider"></div>
      <div class="quick-stat">
        <div class="qs-icon success"><i class="material-symbols-rounded">receipt_long</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $todayTransactionsCount }}</span>
          <span class="qs-label">Transaksi</span>
        </div>
      </div>
      <div class="qs-divider"></div>
      <div class="quick-stat">
        <div class="qs-icon info"><i class="material-symbols-rounded">payments</i></div>
        <div class="qs-content">
          <span class="qs-value">Rp {{ number_format($todaySales / 1000, 0) }}K</span>
          <span class="qs-label">Penjualan</span>
        </div>
      </div>
      <div class="qs-divider"></div>
      <div class="quick-stat">
        <div class="qs-icon danger"><i class="material-symbols-rounded">warning</i></div>
        <div class="qs-content">
          <span class="qs-value">{{ $lowStockCount }}</span>
          <span class="qs-label">Stok Minimum</span>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Main Content Grid --}}
<div class="row g-3">
  {{-- Left Column: Pending Carts --}}
  <div class="col-lg-8">
    <div class="card pro-card mb-4">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon warning">
            <i class="material-symbols-rounded">shopping_cart</i>
          </div>
          <div>
            <h6 class="header-title">Cart Menunggu Approval</h6>
            <p class="header-subtitle">{{ $pendingCarts->count() }} cart perlu persetujuan</p>
          </div>
        </div>
        <a href="{{ route('kasir.cart.approval') }}" class="btn-pro">
          Lihat Semua
          <i class="material-symbols-rounded">arrow_forward</i>
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>Karyawan</th>
                <th>Cart ID</th>
                <th>Items</th>
                <th>Total</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pendingCarts->take(5) as $cart)
                @php
                    $totalItems = $cart->items->sum('jumlah');
                    $totalPrice = $cart->items->sum(function($item) {
                        return $item->jumlah * $item->harga_satuan;
                    });
                @endphp
              <tr>
                <td>
                  <div class="user-cell">
                    <div class="user-avatar">{{ strtoupper(substr($cart->user->nama ?? 'U', 0, 1)) }}</div>
                    <span>{{ $cart->user->nama ?? 'Unknown' }}</span>
                  </div>
                </td>
                <td>
                  <span class="transaction-id">CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td>
                  <span class="status-badge info">
                    <i class="material-symbols-rounded">inventory_2</i>
                    {{ $totalItems }} items
                  </span>
                </td>
                <td>
                  <span class="amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </td>
                <td class="text-center">
                  <a href="{{ route('kasir.cart.showPayment', $cart->id) }}" class="action-btn success">
                    <i class="material-symbols-rounded">check</i>
                    Process
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="empty-state">
                    <div class="empty-icon"><i class="material-symbols-rounded">check_circle</i></div>
                    <h6>Semua Cart Sudah Diproses</h6>
                    <p>Tidak ada cart yang menunggu approval</p>
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

  {{-- Right Column --}}
  <div class="col-lg-4">
    {{-- Quick Actions --}}
    <div class="card pro-card mb-4">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon">
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
          <a href="{{ route('kasir.cart.approval') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">approval</i>
            <span>Approval</span>
            @if($pendingCartsCount > 0)
              <span class="qa-badge">{{ $pendingCartsCount }}</span>
            @endif
          </a>
          <a href="{{ route('kasir.transaksi.riwayat') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">history</i>
            <span>Riwayat</span>
          </a>
          <a href="{{ route('stok.index') }}" class="quick-action-btn">
            <i class="material-symbols-rounded">inventory_2</i>
            <span>Stok</span>
          </a>
          <a href="#" class="quick-action-btn">
            <i class="material-symbols-rounded">analytics</i>
            <span>Laporan</span>
          </a>
        </div>
      </div>
    </div>

    {{-- Stock Alerts --}}
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon danger">
            <i class="material-symbols-rounded">notifications_active</i>
          </div>
          <div>
            <h6 class="header-title">Peringatan Stok</h6>
            <p class="header-subtitle">Item perlu perhatian</p>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="alert-list">
          @forelse($lowStockItems->take(4) as $item)
          <div class="alert-item {{ $item->total_stok == 0 ? 'danger' : 'warning' }}">
            <div class="alert-icon"><i class="material-symbols-rounded">{{ $item->total_stok == 0 ? 'error' : 'warning' }}</i></div>
            <div class="alert-content">
              <span class="alert-title">{{ $item->nama_obat }}</span>
              <span class="alert-count">Stok: {{ $item->total_stok }} (Min: {{ $item->stok_minimum }})</span>
            </div>
          </div>
          @empty
          <div class="empty-state py-4">
            <div class="empty-icon success"><i class="material-symbols-rounded">check_circle</i></div>
            <h6>Stok Aman</h6>
            <p>Semua item di atas batas minimum</p>
          </div>
          @endforelse
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
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --info: #3b82f6;
  --primary: #8b5cf6;
  --secondary: #64748b;
}

/* ===== Welcome Banner ===== */
.welcome-banner {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
.metric-card.danger .metric-icon { background: rgba(239,68,68,0.12); }
.metric-card.danger .metric-icon i { color: var(--danger); }

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
.metric-card.danger .metric-glow { background: var(--danger); }

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
  background: linear-gradient(135deg, #10b981, #059669);
  display: flex;
  align-items: center;
  justify-content: center;
}
.header-icon i { color: #000000 !important; font-size: 20px; }
.header-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.header-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.header-icon.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
.header-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }

.header-title { font-size: 1rem; font-weight: 600; color: #000000 !important; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: #000000 !important; margin: 2px 0 0; }

.btn-pro {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  font-size: 0.8rem;
  font-weight: 500;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.2s;
}
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,185,129,0.4); color: white; }
.btn-pro i { font-size: 16px; }

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
  color: var(--warning);
  background: rgba(245,158,11,0.1);
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 0.8rem;
}

.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: 600;
}

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
.status-badge.info { background: rgba(59,130,246,0.12); color: var(--info); }
.status-badge.warning { background: rgba(245,158,11,0.12); color: var(--warning); }
.status-badge i { font-size: 14px; }

.action-btn {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s;
}
.action-btn.success { background: rgba(16,185,129,0.12); color: var(--success); }
.action-btn.success:hover { background: var(--success); color: white; }
.action-btn i { font-size: 16px; }

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
.empty-icon.success { background: rgba(16,185,129,0.12); }
.empty-icon.success i { color: var(--success); }
.empty-state h6 { color: #475569; margin-bottom: 4px; }
.empty-state p { font-size: 0.8rem; color: var(--secondary); margin: 0; }

/* ===== Quick Actions ===== */
.quick-actions {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

.quick-action-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 16px 12px;
  background: #f8fafc;
  border-radius: 12px;
  text-decoration: none;
  transition: all 0.2s;
  position: relative;
}
.quick-action-btn:hover { background: linear-gradient(135deg, #10b981, #059669); color: white; transform: translateY(-2px); }
.quick-action-btn:hover i, .quick-action-btn:hover span { color: white; }
.quick-action-btn i { font-size: 24px; color: var(--success); margin-bottom: 6px; }
.quick-action-btn span { font-size: 0.75rem; font-weight: 500; color: #475569; }

.qa-badge {
  position: absolute;
  top: 8px;
  right: 8px;
  background: var(--danger);
  color: white;
  font-size: 0.65rem;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 10px;
}

/* ===== Alert List ===== */
.alert-list { padding: 0; }

.alert-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  border-bottom: 1px solid #f1f5f9;
  text-decoration: none;
  transition: all 0.2s;
}
.alert-item:hover { background: #f8fafc; }

.alert-icon {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.alert-item.danger .alert-icon { background: rgba(239,68,68,0.12); }
.alert-item.danger .alert-icon i { color: var(--danger); }
.alert-item.warning .alert-icon { background: rgba(245,158,11,0.12); }
.alert-item.warning .alert-icon i { color: var(--warning); }

.alert-content { flex: 1; }
.alert-title { display: block; font-size: 0.85rem; font-weight: 500; color: #1e293b; }
.alert-count { font-size: 0.75rem; color: var(--secondary); }

/* ===== Responsive ===== */
@media (max-width: 768px) {
  .welcome-illustration { display: none; }
  .welcome-banner { padding: 1.5rem; }
  .welcome-title { font-size: 1.5rem; }
  .quick-stats-bar { justify-content: flex-start; }
  .qs-divider { display: none; }
}
</style>
@endpush
@endsection
