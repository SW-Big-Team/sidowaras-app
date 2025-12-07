@extends('layouts.kasir.app')

@section('title', 'Approval Cart - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Kasir</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Approval Cart</li>
</ol>
@endsection

@section('content')
{{-- Page Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="page-header-banner">
      <div class="header-content">
        <div class="header-icon-wrap">
          <i class="material-symbols-rounded">approval</i>
        </div>
        <div class="header-text">
          <h4 class="header-title">Approval Cart Karyawan</h4>
          <p class="header-subtitle">Kelola pengajuan cart dari karyawan untuk diproses pembayarannya</p>
        </div>
      </div>
      <div class="header-stats">
        <div class="stat-box {{ $carts->count() > 0 ? 'warning' : 'success' }}">
          <span class="stat-number">{{ $carts->count() }}</span>
          <span class="stat-label">Menunggu</span>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Alerts --}}
@if(session('success'))
<div class="row mb-3">
  <div class="col-12">
    <div class="alert-pro success">
      <i class="material-symbols-rounded">check_circle</i>
      <span>{{ session('success') }}</span>
      <button type="button" class="alert-close" onclick="this.parentElement.remove()">
        <i class="material-symbols-rounded">close</i>
      </button>
    </div>
  </div>
</div>
@endif

@if(session('error'))
<div class="row mb-3">
  <div class="col-12">
    <div class="alert-pro danger">
      <i class="material-symbols-rounded">error</i>
      <span>{{ session('error') }}</span>
      <button type="button" class="alert-close" onclick="this.parentElement.remove()">
        <i class="material-symbols-rounded">close</i>
      </button>
    </div>
  </div>
</div>
@endif

{{-- Main Table --}}
<div class="row">
  <div class="col-12">
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon warning">
            <i class="material-symbols-rounded">shopping_cart</i>
          </div>
          <div>
            <h6 class="header-title">Daftar Cart Menunggu</h6>
            <p class="header-subtitle">{{ $carts->count() }} cart perlu persetujuan Anda</p>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>Cart Info</th>
                <th>Karyawan</th>
                <th>Detail</th>
                <th>Total Harga</th>
                <th>Waktu</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($carts as $cart)
                @php
                    $totalItems = $cart->items->sum('jumlah');
                    $totalPrice = $cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan);
                @endphp
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="cart-icon-wrap">
                      <i class="material-symbols-rounded">shopping_cart</i>
                    </div>
                    <span class="transaction-id">CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</span>
                  </div>
                </td>
                <td>
                  <div class="user-cell">
                    <div class="user-avatar">{{ strtoupper(substr($cart->user->nama ?? 'U', 0, 1)) }}</div>
                    <div class="user-info">
                      <span class="user-name">{{ $cart->user->nama ?? $cart->user->nama_lengkap ?? 'Unknown' }}</span>
                      <span class="user-email">{{ $cart->user->email ?? '-' }}</span>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="status-badge info">
                    <i class="material-symbols-rounded">inventory_2</i>
                    {{ $totalItems }} item{{ $totalItems > 1 ? 's' : '' }}
                  </span>
                </td>
                <td>
                  <span class="amount-highlight">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </td>
                <td>
                  <div class="time-info">
                    <span class="time-date">{{ $cart->created_at->format('d M Y') }}</span>
                    <span class="time-hour">{{ $cart->created_at->format('H:i') }} WIB</span>
                  </div>
                </td>
                <td>
                  <div class="action-buttons">
                    <a href="{{ route('kasir.cart.showPayment', $cart) }}" class="action-btn approve" title="Approve & Proses Pembayaran">
                      <i class="material-symbols-rounded">check</i>
                    </a>
                    <form action="{{ route('kasir.cart.reject', $cart) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="action-btn reject" title="Tolak Cart" onclick="return confirm('Yakin ingin menolak cart ini?')">
                        <i class="material-symbols-rounded">close</i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-5">
                  <div class="empty-state">
                    <div class="empty-icon success"><i class="material-symbols-rounded">check_circle</i></div>
                    <h6>Semua Cart Sudah Diproses</h6>
                    <p>Tidak ada cart yang menunggu approval saat ini</p>
                    <a href="{{ route('kasir.dashboard') }}" class="btn-back-dashboard">
                      <i class="material-symbols-rounded">arrow_back</i>
                      Kembali ke Dashboard
                    </a>
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
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --info: #3b82f6;
  --primary: #8b5cf6;
  --secondary: #64748b;
}

/* ===== Page Header Banner ===== */
.page-header-banner {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  border-radius: 16px;
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

.header-content { display: flex; align-items: center; gap: 16px; }

.header-icon-wrap {
  width: 56px;
  height: 56px;
  background: rgba(255,255,255,0.2);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(10px);
}
.header-icon-wrap i { font-size: 28px; color: white; }

.header-text .header-title { font-size: 1.5rem; font-weight: 700; margin: 0 0 4px; }
.header-text .header-subtitle { font-size: 0.9rem; opacity: 0.9; margin: 0; }

.header-stats .stat-box {
  background: rgba(255,255,255,0.2);
  padding: 12px 24px;
  border-radius: 12px;
  text-align: center;
  backdrop-filter: blur(10px);
}
.stat-box .stat-number { display: block; font-size: 2rem; font-weight: 700; line-height: 1; }
.stat-box .stat-label { font-size: 0.75rem; opacity: 0.9; }

/* ===== Alert Pro ===== */
.alert-pro {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 20px;
  border-radius: 12px;
  font-size: 0.9rem;
  font-weight: 500;
}
.alert-pro.success { background: rgba(16,185,129,0.12); color: var(--success); }
.alert-pro.danger { background: rgba(239,68,68,0.12); color: var(--danger); }
.alert-pro i { font-size: 22px; }
.alert-pro .alert-close { margin-left: auto; background: none; border: none; cursor: pointer; color: inherit; opacity: 0.7; }
.alert-pro .alert-close:hover { opacity: 1; }

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
.header-icon i { color: #000000 !important; font-size: 20px; }
.header-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.header-icon.success { background: linear-gradient(135deg, #10b981, #059669); }

.header-title { font-size: 1rem; font-weight: 600; color: #000000 !important; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: #000000 !important; margin: 2px 0 0; }

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

.cart-icon-wrap {
  width: 36px;
  height: 36px;
  background: rgba(245,158,11,0.12);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.cart-icon-wrap i { font-size: 18px; color: var(--warning); }

.transaction-id {
  font-family: monospace;
  font-weight: 600;
  color: var(--warning);
  background: rgba(245,158,11,0.1);
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.8rem;
}

.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: 600;
}
.user-info { display: flex; flex-direction: column; }
.user-name { font-size: 0.85rem; font-weight: 600; color: #1e293b; }
.user-email { font-size: 0.7rem; color: var(--secondary); }

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 5px 10px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
}
.status-badge.info { background: rgba(59,130,246,0.12); color: var(--info); }
.status-badge i { font-size: 14px; }

.amount-highlight { font-size: 0.95rem; font-weight: 700; color: var(--success); }

.time-info { display: flex; flex-direction: column; }
.time-date { font-size: 0.8rem; font-weight: 500; color: #1e293b; }
.time-hour { font-size: 0.7rem; color: var(--secondary); }

/* ===== Action Buttons ===== */
.action-buttons { 
  display: flex; 
  gap: 10px; 
  justify-content: flex-end; 
  align-items: center;
}

.action-btn {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
}

.action-btn.approve {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}
.action-btn.approve:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(16, 185, 129, 0.45);
}

.action-btn.reject {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}
.action-btn.reject:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(239, 68, 68, 0.45);
}

.action-btn i { font-size: 20px; }

.empty-state { text-align: center; padding: 2rem; }
.empty-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
}
.empty-icon i { font-size: 32px; }
.empty-icon.success { background: rgba(16,185,129,0.12); }
.empty-icon.success i { color: var(--success); }
.empty-state h6 { color: #1e293b; font-size: 1.1rem; margin-bottom: 6px; }
.empty-state p { font-size: 0.85rem; color: var(--secondary); margin: 0 0 20px; }

.btn-back-dashboard {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 10px 20px;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  font-size: 0.85rem;
  font-weight: 500;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.2s;
}
.btn-back-dashboard:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,185,129,0.4); color: white; }

@media (max-width: 768px) {
  .page-header-banner { flex-direction: column; gap: 16px; text-align: center; }
  .header-content { flex-direction: column; }
  .action-buttons { flex-direction: column; }
}
</style>
@endpush
@endsection