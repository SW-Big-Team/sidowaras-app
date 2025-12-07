@extends('layouts.kasir.app')

@section('title', 'Daftar Cart - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Kasir</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Cart</li>
</ol>
@endsection

@section('content')
{{-- Page Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="page-header-banner">
      <div class="header-content">
        <div class="header-icon-wrap">
          <i class="material-symbols-rounded">shopping_cart</i>
        </div>
        <div class="header-text">
          <h4 class="header-title">Daftar Cart</h4>
          <p class="header-subtitle">Kelola keranjang belanja yang tersedia</p>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Cart List --}}
<div class="row">
  <div class="col-12">
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon">
            <i class="material-symbols-rounded">list_alt</i>
          </div>
          <div>
            <h6 class="header-title">Semua Cart</h6>
            <p class="header-subtitle">Daftar keranjang yang tersedia untuk diproses</p>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>Cart ID</th>
                <th>Karyawan</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($carts ?? [] as $cart)
                @php
                    $totalItems = $cart->items->sum('jumlah');
                    $totalPrice = $cart->items->sum(fn($i) => $i->jumlah * $i->harga_satuan);
                @endphp
              <tr>
                <td>
                  <span class="transaction-id">CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td>
                  <div class="user-cell">
                    <div class="user-avatar">{{ strtoupper(substr($cart->user->nama ?? 'U', 0, 1)) }}</div>
                    <span>{{ $cart->user->nama ?? 'Unknown' }}</span>
                  </div>
                </td>
                <td>
                  <span class="status-badge info">{{ $totalItems }} items</span>
                </td>
                <td>
                  <span class="amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </td>
                <td>
                  <span class="status-badge {{ $cart->status === 'pending' ? 'warning' : 'success' }}">
                    {{ ucfirst($cart->status ?? 'pending') }}
                  </span>
                </td>
                <td class="text-center">
                  <a href="{{ route('kasir.cart.showPayment', $cart->id) }}" class="action-btn success">
                    <i class="material-symbols-rounded">visibility</i>
                    Lihat
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-5">
                  <div class="empty-state">
                    <div class="empty-icon"><i class="material-symbols-rounded">shopping_cart</i></div>
                    <h6>Tidak Ada Cart</h6>
                    <p>Belum ada keranjang yang tersedia</p>
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
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
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
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  display: flex;
  align-items: center;
  justify-content: center;
}
.header-icon i { color: #000000 !important; font-size: 20px; }

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

.transaction-id {
  font-family: monospace;
  font-weight: 600;
  color: var(--primary);
  background: rgba(139,92,246,0.1);
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.8rem;
}

.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
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
.status-badge.warning { background: rgba(245,158,11,0.12); color: var(--warning); }
.status-badge.info { background: rgba(59,130,246,0.12); color: var(--info); }

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
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
}
.empty-icon i { font-size: 32px; color: var(--secondary); }
.empty-state h6 { color: #1e293b; font-size: 1.1rem; margin-bottom: 6px; }
.empty-state p { font-size: 0.85rem; color: var(--secondary); margin: 0; }
</style>
@endpush
@endsection
