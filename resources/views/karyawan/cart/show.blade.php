@extends('layouts.karyawan.app')

@section('title', 'Detail Cart - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Karyawan</a></li>
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('karyawan.cart.index') }}">Cart</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
</ol>
@endsection

@section('content')
{{-- Back Button --}}
<div class="row mb-3">
  <div class="col-12">
    <a href="{{ route('karyawan.dashboard') }}" class="btn-back">
      <i class="material-symbols-rounded">arrow_back</i>
      Kembali ke Dashboard
    </a>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card pro-card">
      <div class="card-header cart-header">
        <div class="cart-header-icon">
          <i class="material-symbols-rounded">shopping_bag</i>
        </div>
        <div class="cart-header-info">
          <span class="cart-label">Cart ID</span>
          <h5 class="cart-code">{{ strtoupper(substr($cart->uuid, 0, 8)) }}</h5>
        </div>
        <div class="cart-status {{ $cart->is_approved ? 'approved' : 'pending' }}">
          <i class="material-symbols-rounded">{{ $cart->is_approved ? 'check_circle' : 'schedule' }}</i>
          {{ $cart->is_approved ? 'Approved' : 'Pending' }}
        </div>
      </div>
      
      <div class="card-body p-0">
        {{-- Cart Info --}}
        <div class="cart-info-section">
          <div class="info-row">
            <span class="info-label"><i class="material-symbols-rounded">calendar_today</i> Tanggal Dibuat</span>
            <span class="info-value">{{ $cart->created_at->format('d F Y H:i') }} WIB</span>
          </div>
        </div>

        {{-- Items Table --}}
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>Item</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga</th>
                <th class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @php $total = 0; @endphp
              @foreach($cart->items as $item)
              @php
                $subtotal = $item->harga_satuan * $item->jumlah;
                $total += $subtotal;
              @endphp
              <tr>
                <td>
                  <div class="product-cell">
                    <div class="product-icon"><i class="material-symbols-rounded">medication</i></div>
                    <span class="product-name">{{ $item->obat->nama_obat ?? 'Unknown' }}</span>
                  </div>
                </td>
                <td class="text-center">
                  <span class="qty-badge">{{ $item->jumlah }}</span>
                </td>
                <td class="text-end">
                  <span class="price-cell">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                </td>
                <td class="text-end">
                  <span class="subtotal-cell">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Total Section --}}
        <div class="total-section">
          <div class="total-row">
            <span class="total-label">Total Estimasi</span>
            <span class="total-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>
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

/* ===== Buttons ===== */
.btn-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 10px 16px;
  background: #f1f5f9;
  color: #475569;
  font-size: 0.85rem;
  font-weight: 500;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.2s;
}
.btn-back:hover { background: #e2e8f0; color: #1e293b; }
.btn-back i { font-size: 18px; }

/* ===== Pro Cards ===== */
.pro-card {
  background: white;
  border-radius: 16px;
  border: none;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  overflow: hidden;
}

/* ===== Cart Header ===== */
.cart-header {
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 16px;
  position: relative;
}

.cart-header-icon {
  width: 52px;
  height: 52px;
  background: rgba(255,255,255,0.2);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(10px);
}
.cart-header-icon i { color: white; font-size: 26px; }

.cart-header-info { flex: 1; }
.cart-label { font-size: 0.75rem; color: rgba(255,255,255,0.8); }
.cart-code { font-size: 1.25rem; font-weight: 700; color: white; margin: 4px 0 0; font-family: monospace; }

.cart-status {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 600;
}
.cart-status.approved { background: rgba(16,185,129,0.2); color: #6ee7b7; }
.cart-status.pending { background: rgba(245,158,11,0.2); color: #fcd34d; }
.cart-status i { font-size: 18px; }

/* ===== Cart Info Section ===== */
.cart-info-section {
  padding: 16px 20px;
  background: #f8fafc;
  border-bottom: 1px solid #f1f5f9;
}

.info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.info-label {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 0.8rem;
  color: var(--secondary);
}
.info-label i { font-size: 16px; }
.info-value { font-size: 0.9rem; font-weight: 600; color: #1e293b; }

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

.product-cell { display: flex; align-items: center; gap: 12px; }
.product-icon {
  width: 36px;
  height: 36px;
  background: rgba(139,92,246,0.12);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.product-icon i { font-size: 18px; color: var(--primary); }
.product-name { font-size: 0.9rem; font-weight: 600; color: #1e293b; }

.qty-badge {
  display: inline-block;
  padding: 4px 12px;
  background: #f1f5f9;
  border-radius: 6px;
  font-size: 0.85rem;
  font-weight: 600;
  color: #475569;
}

.price-cell { font-size: 0.85rem; color: var(--secondary); }
.subtotal-cell { font-size: 0.9rem; font-weight: 600; color: #1e293b; }

/* ===== Total Section ===== */
.total-section {
  padding: 20px;
  background: linear-gradient(135deg, #f8fafc, #f1f5f9);
}

.total-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.total-label { font-size: 1rem; font-weight: 600; color: #1e293b; }
.total-value { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
</style>
@endpush
@endsection
