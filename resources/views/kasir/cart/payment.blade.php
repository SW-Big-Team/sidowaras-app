@extends('layouts.kasir.app')

@section('title', 'Proses Pembayaran - Sidowaras App')

@section('breadcrumb')
  <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Kasir</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
        href="{{ route('kasir.cart.approval') }}">Approval</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pembayaran</li>
  </ol>
@endsection

@section('content')
  {{-- Back Button --}}
  <div class="row mb-3">
    <div class="col-12">
      <a href="{{ route('kasir.cart.approval') }}" class="btn-back">
        <i class="material-symbols-rounded">arrow_back</i>
        Kembali ke Daftar
      </a>
    </div>
  </div>

  <form action="{{ route('kasir.cart.processPayment') }}" method="POST" id="paymentForm">
    @csrf
    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
    <div class="row">
      {{-- Cart Items (Left Column) --}}
      <div class="col-lg-7 mb-4">
        <div class="card pro-card h-100">
          <div class="card-header pro-card-header">
            <div class="header-left">
              <div class="header-icon info">
                <i class="material-symbols-rounded">shopping_cart</i>
              </div>
              <div>
                <h6 class="header-title">Detail Cart #{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h6>
                <p class="header-subtitle">{{ $cart->items->count() }} item dalam keranjang</p>
              </div>
            </div>
            <span class="cart-badge">{{ $cart->items->count() }} Items</span>
          </div>
          <div class="card-body p-4">
            {{-- Customer Info --}}
            <div class="customer-info-card">
              <div class="customer-avatar">
                {{ strtoupper(substr($cart->user->nama ?? 'C', 0, 1)) }}
              </div>
              <div class="customer-details">
                <span class="customer-name">{{ $cart->user->nama ?? $cart->user->nama_lengkap ?? 'Customer' }}</span>
                <span class="customer-email">{{ $cart->user->email ?? '-' }}</span>
              </div>
              <div class="customer-role">Karyawan</div>
            </div>

            {{-- Items List --}}
            <div class="items-list">
              @php $grandTotal = 0; @endphp
              @foreach($cart->items as $item)
                @php
                  $subtotal = $item->jumlah * $item->harga_satuan;
                  $grandTotal += $subtotal;
                @endphp
                <div class="item-row">
                  <div class="item-info">
                    <span class="item-name">{{ $item->obat->nama_obat ?? 'Unknown' }}</span>
                    <div class="input-pro item-price-edit mt-1"
                      style="width: 140px; padding: 2px 8px; border-color: #e2e8f0;">
                      <span class="input-prefix"
                        style="padding: 4px 8px; font-size: 0.75rem; background: transparent;">Rp</span>
                      <input type="number" name="prices[{{ $item->id }}]" class="form-input-pro item-price-input"
                        value="{{ round($item->harga_satuan) }}" data-qty="{{ $item->jumlah }}"
                        style="font-size: 0.85rem; padding: 4px;" min="0">
                    </div>
                  </div>
                  <div class="item-qty">
                    <span class="qty-badge">{{ $item->jumlah }}x</span>
                  </div>
                  <div class="item-subtotal">
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                  </div>
                </div>
              @endforeach
            </div>

            {{-- Transaction Note --}}
            <div class="form-group-pro mb-4">
              <label class="form-label-pro">Catatan Transaksi</label>
              <div class="input-pro">
                <textarea name="keterangan" class="form-input-pro" rows="2" placeholder="Tambahkan catatan (opsional)..."
                  style="height: auto;"></textarea>
              </div>
            </div>

            {{-- Total --}}
            <div class="total-row">
              <span class="total-label">Total Tagihan</span>
              <span class="total-value">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Payment Form (Right Column) --}}
      <div class="col-lg-5 mb-4">
        <div class="card pro-card h-100">
          <div class="card-header payment-header">
            <i class="material-symbols-rounded">payments</i>
            <span>Proses Pembayaran</span>
          </div>
          <div class="card-body p-4">
            @if ($errors->any())
              <div class="alert-pro danger mb-3">
                <i class="material-symbols-rounded">error</i>
                <div>
                  @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                  @endforeach
                </div>
              </div>
            @endif

            @if (session('error'))
              <div class="alert-pro danger mb-3">
                <i class="material-symbols-rounded">error</i>
                <span>{{ session('error') }}</span>
              </div>
            @endif



            {{-- Payment Method --}}
            <div class="form-group-pro mb-4">
              <label class="form-label-pro">Metode Pembayaran</label>
              <div class="payment-methods">
                <label class="payment-method-option active" data-method="tunai">
                  <input type="radio" name="metode_pembayaran" value="tunai" checked>
                  <div class="method-icon">💵</div>
                  <span class="method-name">Tunai</span>
                </label>
                <label class="payment-method-option" data-method="non tunai">
                  <input type="radio" name="metode_pembayaran" value="non tunai">
                  <div class="method-icon">💳</div>
                  <span class="method-name">Non Tunai</span>
                </label>
              </div>
            </div>

            {{-- Cash Input (only for Tunai) --}}
            <div id="bayar-field">
              <div class="form-group-pro mb-3">
                <label class="form-label-pro">Uang Diterima</label>
                <div class="input-pro">
                  <span class="input-prefix">Rp</span>
                  <input type="text" name="total_bayar" class="form-input-pro" id="totalBayarInput" placeholder="0">
                </div>
              </div>

              {{-- Quick Amount Buttons --}}
              <div class="quick-amounts mb-4">
                <button type="button" class="quick-amount-btn primary" data-amount="{{ $totalHarga }}">
                  Uang Pas
                </button>
                @php
                  $rounded = ceil($totalHarga / 1000) * 1000;
                  $round5k = ceil($totalHarga / 5000) * 5000;
                  $round10k = ceil($totalHarga / 10000) * 10000;
                  $round50k = ceil($totalHarga / 50000) * 50000;
                  $round100k = ceil($totalHarga / 100000) * 100000;
                  $amounts = array_unique([$rounded, $round5k, $round10k, $round50k, $round100k]);
                  sort($amounts);
                @endphp
                @foreach($amounts as $amt)
                  @if($amt > $totalHarga)
                    <button type="button" class="quick-amount-btn" data-amount="{{ $amt }}">
                      {{ number_format($amt / 1000, 0) }}k
                    </button>
                  @endif
                @endforeach
              </div>

              {{-- Change Display --}}
              <div id="kembalian-field" class="change-display" style="display:none;">
                <span class="change-label">Kembalian</span>
                <span class="change-value" id="kembalian-display">Rp 0</span>
              </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="form-actions">
              <button type="submit" class="btn-submit">
                <i class="material-symbols-rounded">check_circle</i>
                Proses Pembayaran
              </button>
              <a href="{{ route('kasir.cart.approval') }}" class="btn-cancel">
                Batal
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
@endsection
</form>

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

      /* ===== Back Button ===== */
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

      .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
      }

      .btn-back i {
        font-size: 18px;
      }

      /* ===== Pro Cards ===== */
      .pro-card {
        background: white;
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
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

      .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .header-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .header-icon i {
        color: #000000 !important;
        font-size: 20px;
      }

      .header-icon.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
      }

      .header-icon.success {
        background: linear-gradient(135deg, #10b981, #059669);
      }

      .header-title {
        font-size: 1rem;
        font-weight: 600;
        color: #000000 !important;
        margin: 0;
      }

      .header-subtitle {
        font-size: 0.75rem;
        color: #000000 !important;
        margin: 2px 0 0;
      }

      .cart-badge {
        background: rgba(16, 185, 129, 0.12);
        color: var(--success);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
      }

      .payment-header {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
        font-weight: 600;
      }

      .payment-header i {
        font-size: 22px;
      }

      /* ===== Customer Info ===== */
      .customer-info-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 20px;
      }

      .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 600;
      }

      .customer-details {
        flex: 1;
        display: flex;
        flex-direction: column;
      }

      .customer-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
      }

      .customer-email {
        font-size: 0.75rem;
        color: var(--secondary);
      }

      .customer-role {
        background: rgba(59, 130, 246, 0.12);
        color: var(--info);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
      }

      /* ===== Items List ===== */
      .items-list {
        margin-bottom: 20px;
      }

      .item-row {
        display: flex;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
      }

      .item-info {
        flex: 1;
        display: flex;
        flex-direction: column;
      }

      .item-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #1e293b;
      }

      .item-price {
        font-size: 0.75rem;
        color: var(--secondary);
      }

      .item-qty {
        margin: 0 20px;
      }

      .qty-badge {
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
      }

      .item-subtotal {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9rem;
      }

      /* ===== Total Row ===== */
      .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
        border-radius: 12px;
      }

      .total-label {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
      }

      .total-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--success);
      }

      /* ===== Form Pro ===== */
      .form-group-pro {
        margin-bottom: 20px;
      }

      .form-label-pro {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
      }

      .payment-methods {
        display: flex;
        gap: 12px;
      }

      .payment-method-option {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 16px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
      }

      .payment-method-option input {
        display: none;
      }

      .payment-method-option.active {
        border-color: var(--success);
        background: rgba(16, 185, 129, 0.05);
      }

      .payment-method-option:hover {
        border-color: var(--success);
      }

      .method-icon {
        font-size: 2rem;
        margin-bottom: 6px;
      }

      .method-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e293b;
      }

      .input-pro {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.2s;
      }

      .input-pro:focus-within {
        border-color: var(--success);
      }

      .input-prefix {
        padding: 12px 14px;
        background: #e2e8f0;
        color: #475569;
        font-weight: 600;
        font-size: 0.9rem;
      }

      .form-input-pro {
        flex: 1;
        padding: 12px 14px;
        border: none;
        background: transparent;
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        outline: none;
      }

      /* ===== Quick Amounts ===== */
      .quick-amounts {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
      }

      .quick-amount-btn {
        padding: 8px 14px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
      }

      .quick-amount-btn:hover {
        background: #e2e8f0;
      }

      .quick-amount-btn.primary {
        background: rgba(16, 185, 129, 0.12);
        color: var(--success);
        border-color: transparent;
      }

      .quick-amount-btn.primary:hover {
        background: var(--success);
        color: white;
      }

      /* ===== Change Display ===== */
      .change-display {
        padding: 20px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius: 12px;
        text-align: center;
        color: white;
        margin-bottom: 20px;
      }

      .change-display.danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
      }

      .change-label {
        display: block;
        font-size: 0.75rem;
        opacity: 0.9;
        margin-bottom: 4px;
      }

      .change-value {
        font-size: 1.75rem;
        font-weight: 700;
      }

      /* ===== Form Actions ===== */
      .form-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      .btn-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
      }

      .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
      }

      .btn-submit i {
        font-size: 20px;
      }

      .btn-cancel {
        display: block;
        text-align: center;
        padding: 12px 24px;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s;
      }

      .btn-cancel:hover {
        background: #e2e8f0;
        color: #1e293b;
      }

      /* ===== Alert Pro ===== */
      .alert-pro {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px;
        border-radius: 10px;
        font-size: 0.85rem;
      }

      .alert-pro.danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
      }

      .alert-pro i {
        font-size: 20px;
        flex-shrink: 0;
        margin-top: 2px;
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const methodOptions = document.querySelectorAll('.payment-method-option');
        const bayarField = document.getElementById('bayar-field');
        const kembalianField = document.getElementById('kembalian-field');
        const kembalianDisplay = document.getElementById('kembalian-display');
        const totalBayarInput = document.getElementById('totalBayarInput');
        let currentTotal = {{ $totalHarga }};

        // Price recalculation
        const priceInputs = document.querySelectorAll('.item-price-input');
        const totalDisplay = document.querySelector('.total-value');
        const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
        const uangPasBtn = document.querySelector('.quick-amount-btn.primary');

        function recalculateTotal() {
          let newTotal = 0;
          priceInputs.forEach(input => {
            const price = parseFloat(input.value) || 0;
            const qty = parseInt(input.dataset.qty);
            const subtotal = price * qty;
            newTotal += subtotal;

            // Update row subtotal
            const rowSubtotal = input.closest('.item-row').querySelector('.item-subtotal span');
            if (rowSubtotal) {
              rowSubtotal.textContent = formatCurrency(subtotal);
            }
          });

          currentTotal = newTotal;
          if (totalDisplay) totalDisplay.textContent = formatCurrency(newTotal);

          // Update Uang Pas button
          if (uangPasBtn) {
            uangPasBtn.dataset.amount = newTotal;
          }

          calculateKembalian();
        }

        priceInputs.forEach(input => {
          input.addEventListener('input', recalculateTotal);
        });

        // Payment method selection
        methodOptions.forEach(option => {
          option.addEventListener('click', function () {
            methodOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            this.querySelector('input').checked = true;

            const method = this.dataset.method;
            if (method === 'tunai') {
              bayarField.style.display = 'block';
              totalBayarInput.setAttribute('required', 'required');
            } else {
              bayarField.style.display = 'none';
              kembalianField.style.display = 'none';
              totalBayarInput.removeAttribute('required');
              totalBayarInput.value = '';
            }
          });
        });

        function formatCurrency(number) {
          return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        function parseCurrency(str) {
          return parseInt(str.replace(/[^\d]/g, '')) || 0;
        }

        function calculateKembalian() {
          const bayar = parseCurrency(totalBayarInput.value);
          const kembalian = bayar - currentTotal;

          if (bayar > 0) {
            kembalianField.style.display = 'block';
            if (kembalian >= 0) {
              kembalianDisplay.textContent = formatCurrency(kembalian);
              kembalianField.classList.remove('danger');
            } else {
              kembalianDisplay.textContent = 'Kurang ' + formatCurrency(Math.abs(kembalian));
              kembalianField.classList.add('danger');
            }
          } else {
            kembalianField.style.display = 'none';
          }
        }

        totalBayarInput.addEventListener('input', function (e) {
          let value = parseCurrency(this.value);
          this.value = value > 0 ? value.toLocaleString('id-ID') : '';
          calculateKembalian();
        });

        document.getElementById('paymentForm').addEventListener('submit', function (e) {
          const activeMethod = document.querySelector('.payment-method-option.active').dataset.method;
          if (activeMethod === 'tunai') {
            const plainValue = parseCurrency(totalBayarInput.value);
            totalBayarInput.value = plainValue;

            if (plainValue < currentTotal) {
              e.preventDefault();
              alert('Jumlah uang tunai kurang dari total tagihan!');
              totalBayarInput.value = plainValue.toLocaleString('id-ID');
              return false;
            }
          }
        });

        document.querySelectorAll('.quick-amount-btn').forEach(btn => {
          btn.addEventListener('click', function () {
            const amount = parseInt(this.dataset.amount);
            totalBayarInput.value = amount.toLocaleString('id-ID');
            calculateKembalian();
          });
        });
      });
    </script>
  @endpush
@endsection