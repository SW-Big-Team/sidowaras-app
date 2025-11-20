@extends('layouts.kasir.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ route('kasir.cart.approval') }}" class="btn btn-sm btn-outline-secondary">
            <i class="material-symbols-rounded align-middle">arrow_back</i>
            Kembali ke Daftar Cart
        </a>
    </div>
</div>

<div class="row">
    <!-- Cart Items (Left Column) -->
    <div class="col-lg-7 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-dark font-weight-bold mb-0">Detail Cart</h6>
                        <p class="text-xs text-muted mb-0 mt-1">CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <span class="badge bg-success px-3 py-2">{{ $cart->items->count() }} Items</span>
                </div>
            </div>
            <div class="card-body">
                <!-- Customer Info -->
                <div class="alert alert-light border mb-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-success text-white rounded-circle me-3">
                            <i class="material-symbols-rounded opacity-10">person</i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-sm">{{ $cart->user->nama ?? $cart->user->nama_lengkap ?? 'Customer' }}</h6>
                            <p class="text-xs text-muted mb-0">{{ $cart->user->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Items List -->
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Obat</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Qty</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Harga</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($cart->items as $item)
                                @php
                                    $subtotal = $item->jumlah * $item->harga_satuan;
                                    $grandTotal += $subtotal;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->obat->nama_obat ?? 'Unknown' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $item->obat->kode_obat ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">{{ $item->jumlah }}</span>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="3" class="text-end">
                                    <h6 class="mb-0 text-sm font-weight-bold">Total</h6>
                                </td>
                                <td class="text-end">
                                    <h5 class="mb-0 font-weight-bold text-success">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h5>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Form (Right Column) -->
    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0 text-white font-weight-bold">
                    <i class="material-symbols-rounded align-middle">payments</i>
                    Proses Pembayaran
                </h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="material-symbols-rounded align-middle me-2">error</i>
                        <strong>Error!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="material-symbols-rounded align-middle me-2">error</i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Summary Card -->
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-sm text-muted">Total Items</span>
                            <span class="text-sm font-weight-bold">{{ $cart->items->sum('jumlah') }} items</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-sm text-muted">Subtotal</span>
                            <span class="text-sm font-weight-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-sm font-weight-bold">Total Tagihan</span>
                            <span class="h5 mb-0 font-weight-bold text-success">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="{{ route('kasir.cart.processPayment') }}" method="POST" id="paymentForm">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                    <input type="hidden" name="total_harga" value="{{ $totalHarga }}">

                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control" required id="metodePembayaran">
                            <option value="tunai">💵 Tunai</option>
                            <option value="non tunai">💳 Non Tunai (Debit/Credit/QRIS)</option>
                        </select>
                    </div>

                    <!-- Field Total Bayar (hanya muncul jika Tunai) -->
                    <div id="bayar-field" style="display:none;">
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Uang Tunai Diterima</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" name="total_bayar" class="form-control" id="totalBayarInput" placeholder="0">
                            </div>
                            <small class="text-muted">Masukkan jumlah uang yang diterima dari pelanggan</small>
                        </div>

                        <!-- Quick Amount Buttons -->
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Uang Pas</label>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-sm btn-outline-success quick-amount" data-amount="{{ $totalHarga }}">
                                    Uang Pas (Rp {{ number_format($totalHarga, 0, ',', '.') }})
                                </button>
                                @php
                                    $rounded = ceil($totalHarga / 1000) * 1000;
                                    $round5k = ceil($totalHarga / 5000) * 5000;
                                    $round10k = ceil($totalHarga / 10000) * 10000;
                                @endphp
                                @if($rounded != $totalHarga)
                                    <button type="button" class="btn btn-sm btn-outline-success quick-amount" data-amount="{{ $rounded }}">
                                        Rp {{ number_format($rounded, 0, ',', '.') }}
                                    </button>
                                @endif
                                @if($round5k != $rounded && $round5k != $totalHarga)
                                    <button type="button" class="btn btn-sm btn-outline-success quick-amount" data-amount="{{ $round5k }}">
                                        Rp {{ number_format($round5k, 0, ',', '.') }}
                                    </button>
                                @endif
                                @if($round10k != $round5k && $round10k != $rounded)
                                    <button type="button" class="btn btn-sm btn-outline-success quick-amount" data-amount="{{ $round10k }}">
                                        Rp {{ number_format($round10k, 0, ',', '.') }}
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Kembalian Display -->
                        <div id="kembalian-field" style="display:none;">
                            <div class="alert alert-info border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-sm font-weight-bold">Kembalian</span>
                                    <span class="h5 mb-0 font-weight-bold" id="kembalian-display">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="material-symbols-rounded align-middle">check_circle</i>
                            Proses Pembayaran
                        </button>
                        <a href="{{ route('kasir.cart.approval') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const metodeSelect = document.getElementById('metodePembayaran');
    const bayarField = document.getElementById('bayar-field');
    const kembalianField = document.getElementById('kembalian-field');
    const kembalianDisplay = document.getElementById('kembalian-display');
    const totalBayarInput = document.getElementById('totalBayarInput');
    const totalHarga = {{ $totalHarga }};

    // Format number as currency
    function formatCurrency(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    // Parse currency string to number
    function parseCurrency(str) {
        return parseInt(str.replace(/[^\d]/g, '')) || 0;
    }

    // Toggle payment fields based on method
    function toggleBayarField() {
        if (metodeSelect.value === 'tunai') {
            bayarField.style.display = 'block';
            totalBayarInput.setAttribute('required', 'required');
            totalBayarInput.focus();
        } else {
            bayarField.style.display = 'none';
            kembalianField.style.display = 'none';
            totalBayarInput.removeAttribute('required');
            totalBayarInput.value = '';
        }
    }

    // Calculate change
    function calculateKembalian() {
        const bayar = parseCurrency(totalBayarInput.value);
        const kembalian = bayar - totalHarga;
        
        if (bayar > 0) {
            kembalianField.style.display = 'block';
            if (kembalian >= 0) {
                kembalianDisplay.textContent = formatCurrency(kembalian);
                kembalianDisplay.classList.remove('text-danger');
                kembalianDisplay.classList.add('text-success');
            } else {
                kembalianDisplay.textContent = 'Kurang ' + formatCurrency(Math.abs(kembalian));
                kembalianDisplay.classList.remove('text-success');
                kembalianDisplay.classList.add('text-danger');
            }
        } else {
            kembalianField.style.display = 'none';
        }
    }

    // Format input as currency while typing
    totalBayarInput.addEventListener('input', function(e) {
        let value = parseCurrency(this.value);
        this.value = value > 0 ? value.toLocaleString('id-ID') : '';
        calculateKembalian();
    });

    // Before submit, convert formatted number back to plain number
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        if (metodeSelect.value === 'tunai') {
            const plainValue = parseCurrency(totalBayarInput.value);
            totalBayarInput.value = plainValue;
            
            if (plainValue < totalHarga) {
                e.preventDefault();
                alert('Jumlah uang tunai kurang dari total tagihan!');
                totalBayarInput.value = plainValue.toLocaleString('id-ID');
                return false;
            }
        }
    });

    // Quick amount buttons
    document.querySelectorAll('.quick-amount').forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = parseInt(this.dataset.amount);
            totalBayarInput.value = amount.toLocaleString('id-ID');
            calculateKembalian();
        });
    });

    // Initialize
    toggleBayarField();
    metodeSelect.addEventListener('change', toggleBayarField);
});
</script>
@endpush
@endsection