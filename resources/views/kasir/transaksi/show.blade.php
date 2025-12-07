@extends('layouts.kasir.app')

@section('title', 'Detail Transaksi - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Kasir</a></li>
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('kasir.transaksi.riwayat') }}">Riwayat</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
</ol>
@endsection

@section('content')
{{-- Back Button & Actions --}}
<div class="row mb-3">
  <div class="col-12 d-flex justify-content-between align-items-center">
    <a href="{{ route('kasir.transaksi.riwayat') }}" class="btn-back">
      <i class="material-symbols-rounded">arrow_back</i>
      Kembali
    </a>
    <button onclick="window.print()" class="btn-print">
      <i class="material-symbols-rounded">print</i>
      Cetak Struk
    </button>
  </div>
</div>

<div class="row">
  {{-- Transaction Info Card --}}
  <div class="col-lg-4 mb-4">
    <div class="card pro-card h-100">
      <div class="card-header trx-header">
        <div class="trx-header-icon">
          <i class="material-symbols-rounded">receipt_long</i>
        </div>
        <div class="trx-header-info">
          <span class="trx-label">Kode Transaksi</span>
          <h5 class="trx-code">{{ $transaksi->no_transaksi ?? $transaksi->kode_transaksi ?? 'TRX-001' }}</h5>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="info-list">
          <div class="info-item">
            <div class="info-icon"><i class="material-symbols-rounded">calendar_today</i></div>
            <div class="info-content">
              <span class="info-label">Tanggal & Waktu</span>
              <span class="info-value">{{ isset($transaksi->tgl_transaksi) ? $transaksi->tgl_transaksi->format('d M Y, H:i') : (isset($transaksi->created_at) ? $transaksi->created_at->format('d M Y, H:i') : now()->format('d M Y, H:i')) }} WIB</span>
            </div>
          </div>
          <div class="info-item">
            <div class="info-icon"><i class="material-symbols-rounded">person</i></div>
            <div class="info-content">
              <span class="info-label">Kasir</span>
              <span class="info-value">{{ $transaksi->kasir->nama ?? $transaksi->user->nama ?? Auth::user()->nama ?? 'Kasir' }}</span>
            </div>
          </div>
          <div class="info-item">
            <div class="info-icon"><i class="material-symbols-rounded">payments</i></div>
            <div class="info-content">
              <span class="info-label">Metode Bayar</span>
              <span class="method-badge {{ $transaksi->metode_pembayaran === 'tunai' ? 'success' : 'info' }}">
                {{ ucfirst($transaksi->metode_pembayaran ?? 'Tunai') }}
              </span>
            </div>
          </div>
          <div class="info-item">
            <div class="info-icon"><i class="material-symbols-rounded">check_circle</i></div>
            <div class="info-content">
              <span class="info-label">Status</span>
              <span class="status-badge success">Selesai</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Items & Summary Card --}}
  <div class="col-lg-8 mb-4">
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon">
            <i class="material-symbols-rounded">shopping_basket</i>
          </div>
          <div>
            <h6 class="header-title">Daftar Item</h6>
            <p class="header-subtitle">Produk yang dibeli dalam transaksi ini</p>
          </div>
        </div>
        @php
          $detailItems = $detail ?? $transaksi->detail ?? collect();
        @endphp
        <span class="items-count">{{ $detailItems->count() }} Item</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga</th>
                <th class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @php $grandTotal = 0; @endphp
              @forelse($detailItems as $item)
              @php
                  // Use correct database field names
                  $harga = $item->harga_saat_transaksi ?? $item->harga_satuan ?? 0;
                  $subtotal = $item->sub_total ?? ($item->jumlah * $harga);
                  $grandTotal += $subtotal;
                  $obat = $item->batch->obat ?? $item->obat ?? null;
              @endphp
              <tr>
                <td>
                  <div class="product-cell">
                    <div class="product-icon"><i class="material-symbols-rounded">medication</i></div>
                    <div class="product-info">
                      <span class="product-name">{{ $obat->nama_obat ?? 'Nama Obat' }}</span>
                      <span class="product-code">{{ $obat->kode_obat ?? 'KODE' }}</span>
                    </div>
                  </div>
                </td>
                <td class="text-center">
                  <span class="qty-badge">{{ $item->jumlah }}</span>
                </td>
                <td class="text-end">
                  <span class="price-cell">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                </td>
                <td class="text-end">
                  <span class="subtotal-cell">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center py-5">
                  <div class="empty-state">
                    <div class="empty-icon"><i class="material-symbols-rounded">inventory_2</i></div>
                    <h6>Tidak ada item</h6>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Summary Section --}}
        <div class="summary-section">
          @php
              $total = $grandTotal ?: ($transaksi->total_harga ?? 0);
              $diskon = $transaksi->diskon ?? 0;
              $totalFinal = $total - $diskon;
              $bayar = $transaksi->total_bayar ?? $totalFinal;
              $kembalian = $bayar - $totalFinal;
          @endphp
          <div class="summary-row">
            <span class="summary-label">Subtotal</span>
            <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>
          @if($diskon > 0)
          <div class="summary-row">
            <span class="summary-label">Diskon</span>
            <span class="summary-value discount">- Rp {{ number_format($diskon, 0, ',', '.') }}</span>
          </div>
          @endif
          <div class="summary-divider"></div>
          <div class="summary-row total">
            <span class="summary-label">Total</span>
            <span class="summary-value">Rp {{ number_format($totalFinal, 0, ',', '.') }}</span>
          </div>
          <div class="summary-row">
            <span class="summary-label">Dibayar</span>
            <span class="summary-value">Rp {{ number_format($bayar, 0, ',', '.') }}</span>
          </div>
          <div class="summary-row change">
            <span class="summary-label">Kembalian</span>
            <span class="summary-value">Rp {{ number_format(max($kembalian, 0), 0, ',', '.') }}</span>
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

.btn-print {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 10px 18px;
  background: linear-gradient(135deg, #1e293b, #334155);
  color: white;
  font-size: 0.85rem;
  font-weight: 500;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-print:hover { box-shadow: 0 4px 12px rgba(30,41,59,0.3); }
.btn-print i { font-size: 18px; }

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
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  display: flex;
  align-items: center;
  justify-content: center;
}
.header-icon i { color: #000000 !important; font-size: 20px; }

.header-title { font-size: 1rem; font-weight: 600; color: #000000 !important; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: #000000 !important; margin: 2px 0 0; }

.items-count {
  background: rgba(16,185,129,0.12);
  color: var(--success);
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

/* ===== Transaction Header ===== */
.trx-header {
  background: linear-gradient(135deg, #10b981, #059669);
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 16px;
}

.trx-header-icon {
  width: 52px;
  height: 52px;
  background: rgba(255,255,255,0.2);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(10px);
}
.trx-header-icon i { color: white; font-size: 26px; }

.trx-label { font-size: 0.75rem; color: rgba(255,255,255,0.8); }
.trx-code { font-size: 1.25rem; font-weight: 700; color: white; margin: 4px 0 0; }

/* ===== Info List ===== */
.info-list { padding: 0; }

.info-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 20px;
  border-bottom: 1px solid #f1f5f9;
}
.info-item:last-child { border-bottom: none; }

.info-icon {
  width: 36px;
  height: 36px;
  background: #f1f5f9;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.info-icon i { font-size: 18px; color: var(--secondary); }

.info-content { flex: 1; display: flex; flex-direction: column; }
.info-label { font-size: 0.7rem; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.5px; }
.info-value { font-size: 0.9rem; font-weight: 600; color: #1e293b; margin-top: 2px; }

.method-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
  margin-top: 2px;
}
.method-badge.success { background: rgba(16,185,129,0.12); color: var(--success); }
.method-badge.info { background: rgba(59,130,246,0.12); color: var(--info); }

.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
  margin-top: 2px;
}
.status-badge.success { background: rgba(16,185,129,0.12); color: var(--success); }

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
  width: 40px;
  height: 40px;
  background: rgba(59,130,246,0.12);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.product-icon i { font-size: 20px; color: var(--info); }

.product-info { display: flex; flex-direction: column; }
.product-name { font-size: 0.9rem; font-weight: 600; color: #1e293b; }
.product-code { font-size: 0.7rem; color: var(--secondary); }

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
.empty-state h6 { color: var(--secondary); margin: 0; }

/* ===== Summary Section ===== */
.summary-section {
  background: linear-gradient(135deg, #f8fafc, #f1f5f9);
  padding: 20px;
  margin: 0;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
}

.summary-label { font-size: 0.85rem; color: var(--secondary); }
.summary-value { font-size: 0.9rem; font-weight: 600; color: #1e293b; }
.summary-value.discount { color: var(--danger); }

.summary-divider { height: 1px; background: #e2e8f0; margin: 8px 0; }

.summary-row.total .summary-label { font-size: 1rem; font-weight: 600; color: #1e293b; }
.summary-row.total .summary-value { font-size: 1.25rem; font-weight: 700; color: var(--success); }

.summary-row.change .summary-value { color: var(--success); }

/* ===== Print Styles ===== */
@media print {
  .btn-back, .btn-print, nav, .sidebar, .navbar { display: none !important; }
  .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
}
</style>
@endpush
@endsection