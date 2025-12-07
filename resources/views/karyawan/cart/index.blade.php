@extends('layouts.karyawan.app')

@section('title', 'Keranjang Penjualan - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Karyawan</a></li>
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
          <h4 class="header-title">Keranjang Penjualan</h4>
          <p class="header-subtitle">Kelola penjualan obat dengan mudah dan cepat</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  {{-- Form Tambah Obat --}}
  <div class="col-lg-4 mb-4 mb-lg-0">
    <div class="card pro-card h-100">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon primary">
            <i class="material-symbols-rounded">add_shopping_cart</i>
          </div>
          <div>
            <h6 class="header-title">Tambah Obat</h6>
            <p class="header-subtitle">Pilih atau scan barcode</p>
          </div>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('karyawan.cart.add') }}" method="POST">
          @csrf
          <div class="form-group-pro mb-4">
            <label class="form-label-pro">Pilih Obat</label>
            <div class="select-with-scan">
              <select name="obat_id" id="obatSelect" class="form-select-pro" required>
                <option value="">-- Cari atau pilih obat --</option>
                @foreach($obats as $obat)
                  <option value="{{ $obat->id }}" data-stok="{{ $obat->sisa_stok ?? 0 }}" data-barcode="{{ $obat->barcode ?? '' }}">
                    {{ $obat->nama_obat }} ({{ $obat->kode_obat }})
                    @if($obat->sisa_stok && $obat->sisa_stok > 0)
                      — Stok: {{ $obat->sisa_stok }}
                    @else
                      — Stok Habis
                    @endif
                  </option>
                @endforeach
              </select>
              <button class="btn-scan" type="button" id="btnOpenQr" title="Scan Barcode">
                <i class="material-symbols-rounded">qr_code_scanner</i>
              </button>
            </div>
          </div>
          <div class="form-group-pro mb-4">
            <label class="form-label-pro">Jumlah</label>
            <div class="qty-input-group">
              <button class="qty-btn" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                <i class="material-symbols-rounded">remove</i>
              </button>
              <input type="number" name="jumlah" class="qty-input" min="1" value="1" required>
              <button class="qty-btn" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                <i class="material-symbols-rounded">add</i>
              </button>
            </div>
          </div>
          <button type="submit" class="btn-add-cart">
            <i class="material-symbols-rounded">add</i>
            Tambah ke Keranjang
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- Keranjang Saat Ini --}}
  <div class="col-lg-8">
    <div class="card pro-card h-100">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon success">
            <i class="material-symbols-rounded">shopping_bag</i>
          </div>
          <div>
            <h6 class="header-title">Daftar Pesanan</h6>
            <p class="header-subtitle">Item dalam keranjang</p>
          </div>
        </div>
        @if($cart && $cart->items->isNotEmpty())
          <span class="items-badge">{{ $cart->items->count() }} Item</span>
        @endif
      </div>

      {{-- Success Toast --}}
      @if(session('success'))
      <div class="success-toast" id="successToast">
        <div class="toast-icon">
          <i class="material-symbols-rounded">check_circle</i>
        </div>
        <div class="toast-content">
          <span class="toast-title">Berhasil!</span>
          <span class="toast-message">{{ session('success') }}</span>
        </div>
        <button class="toast-close" onclick="document.getElementById('successToast').remove()">
          <i class="material-symbols-rounded">close</i>
        </button>
      </div>
      @endif

      {{-- Error Alert --}}
      @if($errors->any())
      <div class="px-4 pt-3">
        <div class="alert-pro danger">
          <i class="material-symbols-rounded">error</i>
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      @endif

      <div class="card-body p-0">
        @if($cart && $cart->items->isNotEmpty())
          {{-- Desktop View --}}
          <div class="table-responsive d-none d-md-block">
            <table class="table pro-table mb-0">
              <thead>
                <tr>
                  <th>Obat</th>
                  <th class="text-center">Jumlah</th>
                  <th class="text-end">Harga</th>
                  <th class="text-end">Subtotal</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php $total = 0; @endphp
                @foreach($cart->items as $item)
                  @php
                    $subtotal = $item->jumlah * $item->harga_satuan;
                    $total += $subtotal;
                  @endphp
                  <tr>
                    <td>
                      <div class="product-cell">
                        <div class="product-icon"><i class="material-symbols-rounded">medication</i></div>
                        <div class="product-info">
                          <span class="product-name">{{ $item->obat->nama_obat }}</span>
                          <span class="product-code">{{ $item->obat->kode_obat }}</span>
                        </div>
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
                    <td class="text-center">
                      <form action="{{ route('karyawan.cart.remove', $item->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete" title="Hapus">
                          <i class="material-symbols-rounded">delete</i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Mobile View --}}
          <div class="d-md-none px-3 pb-3 pt-3">
            @php $total = 0; @endphp
            @foreach($cart->items as $item)
              @php
                $subtotal = $item->jumlah * $item->harga_satuan;
                $total += $subtotal;
              @endphp
              <div class="cart-item-card">
                <div class="item-header">
                  <div class="item-info">
                    <span class="item-name">{{ $item->obat->nama_obat }}</span>
                    <span class="item-code">{{ $item->obat->kode_obat }}</span>
                  </div>
                  <form action="{{ route('karyawan.cart.remove', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete-sm">
                      <i class="material-symbols-rounded">delete</i>
                    </button>
                  </form>
                </div>
                <div class="item-footer">
                  <div>
                    <span class="item-price">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} x {{ $item->jumlah }}</span>
                  </div>
                  <span class="item-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Footer Summary --}}
          <div class="cart-summary">
            <div class="summary-content">
              <div class="summary-info">
                <span class="summary-label">Total Pembayaran</span>
                <span class="summary-note">Siap untuk diajukan ke kasir</span>
              </div>
              <h3 class="summary-total">Rp {{ number_format($total, 0, ',', '.') }}</h3>
            </div>
            <form action="{{ route('karyawan.cart.checkout') }}" method="POST" class="w-100 mt-3">
              @csrf
              <button type="submit" class="btn-checkout">
                <span>Kirim ke Kasir</span>
                <i class="material-symbols-rounded">arrow_forward</i>
              </button>
            </form>
          </div>

        @else
          {{-- Empty State --}}
          <div class="empty-state py-5">
            <div class="empty-icon">
              <i class="material-symbols-rounded">shopping_cart_off</i>
            </div>
            <h6>Keranjang Belanja Kosong</h6>
            <p>Belum ada obat yang ditambahkan. Silakan pilih obat dari form di sebelah kiri.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

{{-- Modal: QR Code Scanner --}}
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content modal-pro">
      <div class="modal-header-pro">
        <div class="modal-icon">
          <i class="material-symbols-rounded">qr_code_scanner</i>
        </div>
        <div>
          <h5 class="modal-title-pro">Pindai Barcode</h5>
          <p class="modal-subtitle-pro">Arahkan kamera ke barcode obat</p>
        </div>
        <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="material-symbols-rounded">close</i>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="scan-info">
          <i class="material-symbols-rounded">info</i>
          <span>Pastikan cahaya cukup dan posisikan barcode di dalam kotak.</span>
        </div>
        <div class="scanner-container">
          <div id="qr-reader"></div>
        </div>
      </div>
      <div class="modal-footer-pro">
        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Tutup</button>
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

.header-text .header-title { font-size: 1.5rem; font-weight: 700; margin: 0 0 4px; color: white; }
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
  display: flex;
  align-items: center;
  justify-content: center;
}
.header-icon i { color: #000000 !important; font-size: 20px; }
.header-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.header-icon.success { background: linear-gradient(135deg, #10b981, #059669); }

.header-title { font-size: 1rem; font-weight: 600; color: #000000 !important; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: #000000 !important; margin: 2px 0 0; }

.items-badge {
  background: rgba(16,185,129,0.12);
  color: var(--success);
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

/* ===== Form Styles ===== */
.form-group-pro { margin-bottom: 1.25rem; }
.form-label-pro { 
  display: block;
  font-size: 0.7rem;
  font-weight: 600;
  color: var(--secondary);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 8px;
}

.select-with-scan {
  display: flex;
  gap: 8px;
}

.form-select-pro {
  flex: 1;
  padding: 12px 14px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  font-size: 0.9rem;
  color: #1e293b;
  background: white;
  outline: none;
  transition: all 0.2s;
}
.form-select-pro:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.1); }

.btn-scan {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  background: #1e293b;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-scan i { color: white; font-size: 22px; }
.btn-scan:hover { background: #0f172a; }

.qty-input-group {
  display: flex;
  align-items: center;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  overflow: hidden;
}

.qty-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  background: #f8fafc;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
}
.qty-btn:hover { background: #f1f5f9; }
.qty-btn i { color: var(--secondary); font-size: 20px; }

.qty-input {
  flex: 1;
  text-align: center;
  border: none;
  font-size: 1rem;
  font-weight: 600;
  color: #1e293b;
  outline: none;
}

.btn-add-cart {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  padding: 14px;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  border: none;
  border-radius: 10px;
  color: white;
  font-size: 0.85rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-add-cart:hover { box-shadow: 0 4px 15px rgba(139,92,246,0.4); }
.btn-add-cart i { font-size: 18px; }

/* ===== Success Toast ===== */
.success-toast {
  position: fixed;
  top: 20px;
  right: 20px;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 16px 20px;
  background: linear-gradient(135deg, #10b981, #059669);
  border-radius: 14px;
  box-shadow: 0 10px 40px rgba(16,185,129,0.4);
  z-index: 9999;
  animation: slideIn 0.4s ease-out, fadeOut 0.4s ease-out 4.6s forwards;
}

.toast-icon {
  width: 44px;
  height: 44px;
  background: rgba(255,255,255,0.2);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.toast-icon i { font-size: 24px; color: white; }

.toast-content { display: flex; flex-direction: column; }
.toast-title { font-size: 0.9rem; font-weight: 700; color: white; }
.toast-message { font-size: 0.8rem; color: rgba(255,255,255,0.9); }

.toast-close {
  background: none;
  border: none;
  color: rgba(255,255,255,0.7);
  cursor: pointer;
  padding: 4px;
  margin-left: 8px;
}
.toast-close:hover { color: white; }
.toast-close i { font-size: 20px; }

@keyframes slideIn {
  from { transform: translateX(100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeOut {
  from { opacity: 1; transform: translateX(0); }
  to { opacity: 0; transform: translateX(100%); }
}

/* ===== Alert Pro ===== */
.alert-pro {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 12px 16px;
  border-radius: 10px;
  font-size: 0.85rem;
  margin-bottom: 12px;
}
.alert-pro.success { background: rgba(16,185,129,0.12); color: var(--success); }
.alert-pro.danger { background: rgba(239,68,68,0.12); color: var(--danger); }
.alert-pro i { font-size: 20px; flex-shrink: 0; }
.alert-pro ul { padding-left: 16px; margin: 0; }

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
  background: rgba(139,92,246,0.12);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.product-icon i { font-size: 20px; color: var(--primary); }

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
.subtotal-cell { font-size: 0.9rem; font-weight: 600; color: var(--primary); }

.btn-delete {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  background: rgba(239,68,68,0.1);
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-delete i { font-size: 18px; color: var(--danger); }
.btn-delete:hover { background: var(--danger); }
.btn-delete:hover i { color: white; }

/* ===== Mobile Cart Item ===== */
.cart-item-card {
  background: #f8fafc;
  border-radius: 12px;
  padding: 14px;
  margin-bottom: 12px;
}

.item-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 12px;
}

.item-info { display: flex; flex-direction: column; }
.item-name { font-size: 0.9rem; font-weight: 600; color: #1e293b; }
.item-code { font-size: 0.7rem; color: var(--secondary); }

.btn-delete-sm {
  background: none;
  border: none;
  padding: 0;
  cursor: pointer;
}
.btn-delete-sm i { font-size: 22px; color: var(--danger); }

.item-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.item-price { font-size: 0.8rem; color: var(--secondary); }
.item-subtotal { font-size: 1rem; font-weight: 700; color: var(--primary); }

/* ===== Cart Summary ===== */
.cart-summary {
  background: linear-gradient(135deg, #f8fafc, #f1f5f9);
  padding: 20px;
  margin: 0;
}

.summary-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.summary-label { display: block; font-size: 0.8rem; color: var(--secondary); text-transform: uppercase; font-weight: 600; }
.summary-note { font-size: 0.75rem; color: var(--secondary); }
.summary-total { font-size: 1.5rem; font-weight: 700; color: var(--primary); margin: 0; }

.btn-checkout {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  padding: 16px;
  background: linear-gradient(135deg, #10b981, #059669);
  border: none;
  border-radius: 12px;
  color: white;
  font-size: 0.95rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: 0 4px 15px rgba(16,185,129,0.35);
}
.btn-checkout:hover { box-shadow: 0 8px 25px rgba(16,185,129,0.45); }
.btn-checkout i { font-size: 20px; }

/* ===== Empty State ===== */
.empty-state { text-align: center; padding: 3rem; }
.empty-icon {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
}
.empty-icon i { font-size: 48px; color: #cbd5e1; }
.empty-state h6 { font-size: 1.1rem; color: #1e293b; margin-bottom: 8px; }
.empty-state p { font-size: 0.85rem; color: var(--secondary); margin: 0; max-width: 280px; margin: 0 auto; }

/* ===== Modal Pro ===== */
.modal-pro { border-radius: 16px; border: none; overflow: hidden; }

.modal-header-pro {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 1.5rem;
  background: linear-gradient(135deg, #f8fafc, #f1f5f9);
  border-bottom: 1px solid #e2e8f0;
  position: relative;
}

.modal-icon {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.modal-icon i { color: white; font-size: 24px; }

.modal-title-pro { font-size: 1.1rem; font-weight: 600; color: #1e293b; margin: 0 0 2px; }
.modal-subtitle-pro { font-size: 0.8rem; color: var(--secondary); margin: 0; }

.btn-modal-close {
  position: absolute;
  right: 1rem;
  top: 1rem;
  background: none;
  border: none;
  color: var(--secondary);
  cursor: pointer;
  padding: 4px;
}
.btn-modal-close:hover { color: #1e293b; }

.scan-info {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(59,130,246,0.1);
  color: var(--info);
  padding: 12px 16px;
  border-radius: 10px;
  font-size: 0.8rem;
  margin-bottom: 16px;
}
.scan-info i { font-size: 20px; }

.scanner-container {
  background: #0f172a;
  border-radius: 12px;
  overflow: hidden;
  min-height: 300px;
}
#qr-reader { width: 100%; }

.modal-footer-pro {
  padding: 1rem 1.5rem;
  display: flex;
  justify-content: flex-end;
  border-top: 1px solid #e2e8f0;
  background: #f8fafc;
}

.btn-modal-secondary {
  padding: 10px 18px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.85rem;
  font-weight: 500;
  color: #475569;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-modal-secondary:hover { background: #f1f5f9; color: #1e293b; }

/* ===== QR Scanner Overrides ===== */
#qr-reader__dashboard { padding: 0 !important; border: none !important; }
#qr-reader__scan_region video { width: 100% !important; height: auto !important; object-fit: cover; }
#qr-reader__scan_region { background: transparent !important; }

@media (max-width: 768px) {
  .page-header-banner { flex-direction: column; gap: 16px; text-align: center; }
  .header-content { flex-direction: column; }
}
</style>
@endpush
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Checkout Confirmation
  const checkoutForm = document.querySelector('form[action="{{ route('karyawan.cart.checkout') }}"]');
  if(checkoutForm) {
    checkoutForm.addEventListener('submit', function(e) {
      if(!confirm('Apakah Anda yakin ingin mengirim pesanan ini ke kasir?')) {
        e.preventDefault();
      }
    });
  }

  // QR Scanner Logic
  let html5QrcodeScanner = null;

  function onScanSuccess(decodedText, decodedResult) {
    const select = document.getElementById('obatSelect');
    let found = false;
    
    for (let i = 0; i < select.options.length; i++) {
      const optionBarcode = select.options[i].getAttribute('data-barcode');
      if (optionBarcode && optionBarcode === decodedText) {
        select.selectedIndex = i;
        found = true;
        break;
      }
    }

    if (found) {
      const modalEl = document.getElementById('qrScannerModal');
      const modal = bootstrap.Modal.getInstance(modalEl);
      if(modal) modal.hide();
      
      if(html5QrcodeScanner) {
        html5QrcodeScanner.clear().catch(err => console.error(err));
      }

      alert('Obat ditemukan: ' + select.options[select.selectedIndex].text);
    } else {
      alert('Obat tidak ditemukan untuk barcode: ' + decodedText);
    }
  }

  function onScanFailure(error) {
    // Ignore scan failures
  }

  const btnOpenQr = document.getElementById('btnOpenQr');
  if(btnOpenQr) {
    btnOpenQr.addEventListener('click', function() {
      const modalEl = document.getElementById('qrScannerModal');
      const modal = new bootstrap.Modal(modalEl);
      modal.show();
      
      const onShown = function () {
        if(!html5QrcodeScanner) {
          html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            false
          );
        }
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
      };
      
      modalEl.removeEventListener('shown.bs.modal', onShown);
      modalEl.addEventListener('shown.bs.modal', onShown, { once: true });

      modalEl.addEventListener('hidden.bs.modal', function () {
        if(html5QrcodeScanner) {
          html5QrcodeScanner.clear().catch(error => {
            console.error("Failed to clear html5QrcodeScanner. ", error);
          });
        }
      });
    });
  }
});

// Auto-remove toast after animation completes
setTimeout(function() {
  const toast = document.getElementById('successToast');
  if (toast) toast.remove();
}, 5000);
</script>
@endpush