@extends('layouts.kasir.app')

@section('title', 'Point of Sale - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('kasir.dashboard') }}">Kasir</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">POS</li>
</ol>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <!-- Products Section -->
        <div class="col-lg-8">
            <!-- Search Bar -->
            <div class="card shadow-sm mb-3">
                <div class="card-body p-3">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text border-0 bg-transparent">
                            <i class="material-symbols-rounded text-primary">search</i>
                        </span>
                        <input type="text" class="form-control border-0 ps-0" 
                               placeholder="Cari obat atau scan barcode..." 
                               id="searchInput" autofocus>
                        <button class="btn btn-primary mb-0" id="scanBtn">
                            <i class="material-symbols-rounded">qr_code_scanner</i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="row g-2" id="productList">
                        <!-- Products will be rendered here by JS -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Section -->
        <div class="col-lg-4">
            <div class="card shadow-lg position-sticky" style="top: 100px;">
                <!-- Cart Header -->
                <div class="card-header bg-gradient-primary p-3 pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white mb-0">Keranjang</h6>
                            <small class="text-white opacity-8" id="cartCount">0 item</small>
                        </div>
                        <button class="btn btn-sm btn-white mb-0" id="btnClearCart">
                            <i class="material-symbols-rounded text-sm">delete</i>
                        </button>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="card-body p-3" style="max-height: 350px; overflow-y: auto;">
                    <div id="cartItems">
                        <!-- Cart items will be rendered here -->
                        <div class="text-center py-5 text-muted" id="emptyCart">
                            <i class="material-symbols-rounded" style="font-size: 3rem; opacity: 0.3;">shopping_cart</i>
                            <p class="mb-0">Keranjang Kosong</p>
                        </div>
                    </div>
                </div>

                <!-- Summary & Payment -->
                <div class="card-footer border-top p-3">
                    <!-- Summary -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-sm">Subtotal:</span>
                            <span class="text-sm font-weight-bold" id="subtotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 align-items-center">
                            <span class="text-sm">Diskon:</span>
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <span class="input-group-text text-xs">Rp</span>
                                <input type="number" class="form-control text-end" id="discount" value="0" min="0">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="font-weight-bold">Total:</span>
                            <span class="font-weight-bold text-success text-lg" id="total">Rp 0</span>
                        </div>
                    </div>

                    <!-- Payment Input -->
                    <div class="mb-3">
                        <label class="form-label text-sm mb-1">Pembayaran</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control text-end" id="payment" placeholder="0">
                        </div>
                        
                        <!-- Quick Amounts -->
                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-sm btn-outline-secondary flex-fill quick-pay" data-amount="50000">50K</button>
                            <button class="btn btn-sm btn-outline-secondary flex-fill quick-pay" data-amount="100000">100K</button>
                            <button class="btn btn-sm btn-outline-secondary flex-fill quick-pay" data-amount="200000">200K</button>
                        </div>
                    </div>

                    <!-- Change -->
                    <div class="alert alert-success mb-3 py-2" id="changeAlert" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-sm">Kembalian:</span>
                            <span class="font-weight-bold" id="change">Rp 0</span>
                        </div>
                    </div>

                    <!-- Process Button -->
                    <button class="btn btn-success btn-lg w-100 mb-0" id="btnProcess" disabled>
                        <i class="material-symbols-rounded me-1">check_circle</i>
                        Proses Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Product Card */
    .product-item {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .product-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-color: #1AB262;
    }
    
    .product-item:active {
        transform: translateY(0);
    }

    /* Cart Item */
    .cart-item {
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
        animation: slideIn 0.3s ease;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Quantity Controls */
    .qty-btn {
        width: 24px;
        height: 24px;
        padding: 0;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .qty-input {
        width: 45px;
        text-align: center;
        padding: 2px 4px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    /* Scrollbar */
    .card-body::-webkit-scrollbar {
        width: 4px;
    }

    .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .card-body::-webkit-scrollbar-thumb {
        background: #1AB262;
        border-radius: 4px;
    }

    /* Stock Badge */
    .stock-badge {
        font-size: 0.7rem;
        padding: 2px 6px;
    }

    /* Quick Pay Buttons */
    .quick-pay:hover {
        background: #1AB262;
        color: white;
        border-color: #1AB262;
    }

    /* Price Text */
    .price-text {
        font-size: 1.1rem;
        color: #1AB262;
    }
</style>
@endpush

@push('scripts')
<script>
// Sample Products Data
const products = [
    {id: 1, name: 'Paracetamol 500mg', price: 15000, stock: 150, category: 'Tablet'},
    {id: 2, name: 'Amoxicillin 500mg', price: 25000, stock: 200, category: 'Kapsul'},
    {id: 3, name: 'Vitamin C 1000mg', price: 45000, stock: 35, category: 'Vitamin'},
    {id: 4, name: 'OBH Combi Sirup', price: 18500, stock: 120, category: 'Sirup'},
    {id: 5, name: 'Betadine Salep', price: 22000, stock: 80, category: 'Salep'},
    {id: 6, name: 'Promag Tablet', price: 12500, stock: 95, category: 'Tablet'},
    {id: 7, name: 'Antangin JRG', price: 8500, stock: 60, category: 'Herbal'},
    {id: 8, name: 'Bodrex Extra', price: 11000, stock: 110, category: 'Tablet'},
];

let cart = [];

// Render Products
function renderProducts() {
    const container = document.getElementById('productList');
    container.innerHTML = products.map(p => `
        <div class="col-md-4 col-sm-6">
            <div class="product-item p-3 bg-white" onclick="addToCart(${p.id})">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-0 text-sm font-weight-bold">${p.name}</h6>
                    <span class="badge bg-${p.stock > 50 ? 'success' : 'warning'} stock-badge">${p.stock}</span>
                </div>
                <p class="text-xs text-muted mb-2">${p.category}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="price-text font-weight-bold">Rp ${p.price.toLocaleString('id-ID')}</span>
                    <i class="material-symbols-rounded text-success">add_circle</i>
                </div>
            </div>
        </div>
    `).join('');
}

// Add to Cart
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;

    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.qty++;
    } else {
        cart.push({...product, qty: 1});
    }
    
    renderCart();
    updateSummary();
    showToast(`${product.name} ditambahkan`);
}

// Remove from Cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    renderCart();
    updateSummary();
}

// Update Quantity
function updateQty(productId, newQty) {
    const item = cart.find(item => item.id === productId);
    if (!item) return;

    newQty = parseInt(newQty);
    if (newQty <= 0) {
        removeFromCart(productId);
        return;
    }

    if (newQty > item.stock) {
        showToast(`Stok tidak cukup! Tersedia: ${item.stock}`, 'warning');
        return;
    }

    item.qty = newQty;
    renderCart();
    updateSummary();
}

// Render Cart
function renderCart() {
    const container = document.getElementById('cartItems');
    const emptyCart = document.getElementById('emptyCart');
    const btnProcess = document.getElementById('btnProcess');
    
    if (cart.length === 0) {
        emptyCart.style.display = 'block';
        btnProcess.disabled = true;
        document.getElementById('cartCount').textContent = '0 item';
        return;
    }

    emptyCart.style.display = 'none';
    btnProcess.disabled = false;
    
    const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
    document.getElementById('cartCount').textContent = `${totalItems} item${totalItems > 1 ? 's' : ''}`;

    container.innerHTML = cart.map(item => `
        <div class="cart-item">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="text-sm mb-0 font-weight-bold">${item.name}</h6>
                <button class="btn btn-link text-danger p-0 mb-0" onclick="removeFromCart(${item.id})">
                    <i class="material-symbols-rounded text-md">close</i>
                </button>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-1 align-items-center">
                    <button class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQty(${item.id}, ${item.qty - 1})">
                        <i class="material-symbols-rounded text-xs">remove</i>
                    </button>
                    <input type="number" class="form-control form-control-sm qty-input" 
                           value="${item.qty}" 
                           onchange="updateQty(${item.id}, this.value)"
                           min="1" max="${item.stock}">
                    <button class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQty(${item.id}, ${item.qty + 1})">
                        <i class="material-symbols-rounded text-xs">add</i>
                    </button>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">@ Rp ${item.price.toLocaleString('id-ID')}</small>
                    <span class="text-sm font-weight-bold text-primary">Rp ${(item.price * item.qty).toLocaleString('id-ID')}</span>
                </div>
            </div>
        </div>
    `).join('');
}

// Update Summary
function updateSummary() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const discount = parseInt(document.getElementById('discount').value) || 0;
    const total = Math.max(0, subtotal - discount);

    document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
    document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;

    calculateChange();
}

// Calculate Change
function calculateChange() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const discount = parseInt(document.getElementById('discount').value) || 0;
    const total = subtotal - discount;
    const payment = parseInt(document.getElementById('payment').value.replace(/\./g, '')) || 0;
    const change = payment - total;

    const changeAlert = document.getElementById('changeAlert');
    const changeEl = document.getElementById('change');

    if (payment >= total && cart.length > 0) {
        changeAlert.style.display = 'block';
        changeEl.textContent = `Rp ${change.toLocaleString('id-ID')}`;
    } else {
        changeAlert.style.display = 'none';
    }
}

// Show Toast
function showToast(message, type = 'success') {
    // Simple alert for now - you can replace with better toast
    console.log(`${type.toUpperCase()}: ${message}`);
}

// Event Listeners
document.getElementById('discount').addEventListener('input', updateSummary);
document.getElementById('payment').addEventListener('input', function() {
    // Format as currency
    let value = this.value.replace(/\./g, '');
    if (value) {
        this.value = parseInt(value).toLocaleString('id-ID');
    }
    calculateChange();
});

// Quick Pay Buttons
document.querySelectorAll('.quick-pay').forEach(btn => {
    btn.addEventListener('click', function() {
        const amount = this.dataset.amount;
        document.getElementById('payment').value = parseInt(amount).toLocaleString('id-ID');
        calculateChange();
    });
});

// Clear Cart
document.getElementById('btnClearCart').addEventListener('click', function() {
    if (cart.length === 0) return;
    if (confirm('Hapus semua item dari keranjang?')) {
        cart = [];
        renderCart();
        updateSummary();
    }
});

// Process Transaction
document.getElementById('btnProcess').addEventListener('click', function() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }

    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const discount = parseInt(document.getElementById('discount').value) || 0;
    const total = subtotal - discount;
    const payment = parseInt(document.getElementById('payment').value.replace(/\./g, '')) || 0;

    if (payment < total) {
        alert('Pembayaran kurang!');
        return;
    }

    const change = payment - total;
    
    if (confirm(`KONFIRMASI TRANSAKSI\n\nTotal: Rp ${total.toLocaleString('id-ID')}\nBayar: Rp ${payment.toLocaleString('id-ID')}\nKembalian: Rp ${change.toLocaleString('id-ID')}\n\nProses transaksi?`)) {
        // Process transaction here
        alert('✅ Transaksi Berhasil!\n\nKembalian: Rp ' + change.toLocaleString('id-ID'));
        
        // Reset
        cart = [];
        document.getElementById('discount').value = 0;
        document.getElementById('payment').value = '';
        renderCart();
        updateSummary();
    }
});

// Search Products
document.getElementById('searchInput').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const productCards = document.querySelectorAll('.product-item');
    
    productCards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.closest('.col-md-4').style.display = text.includes(search) ? '' : 'none';
    });
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    renderProducts();
    renderCart();
    updateSummary();
});
</script>
@endpush
