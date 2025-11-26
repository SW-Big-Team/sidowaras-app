@extends('layouts.karyawan.app')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h4 class="text-dark font-weight-bold mb-0">Keranjang Penjualan</h4>
            <p class="text-sm text-muted mb-0">Kelola penjualan obat dengan mudah dan cepat.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form Tambah Obat -->
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0 pt-4">
                    <h6 class="font-weight-bold text-primary mb-0 d-flex align-items-center">
                        <i class="material-symbols-rounded me-2">add_shopping_cart</i> Tambah Obat
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.cart.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-xs font-weight-bold text-uppercase text-muted">Pilih Obat</label>
                            <div class="input-group">
                                <select name="obat_id" id="obatSelect" class="form-control form-select" required style="border-right: 0;">
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
                                <button class="btn btn-dark mb-0" type="button" id="btnOpenQr" title="Scan Barcode">
                                    <i class="material-symbols-rounded">qr_code_scanner</i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-xs font-weight-bold text-uppercase text-muted">Jumlah</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary mb-0" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                    <i class="material-symbols-rounded text-sm">remove</i>
                                </button>
                                <input type="number" name="jumlah" class="form-control text-center font-weight-bold" min="1" value="1" required>
                                <button class="btn btn-outline-secondary mb-0" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                    <i class="material-symbols-rounded text-sm">add</i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 text-uppercase font-weight-bold text-xs">
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Keranjang Saat Ini -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0 pt-4 d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold text-dark mb-0 d-flex align-items-center">
                        <i class="material-symbols-rounded me-2">shopping_bag</i> Daftar Pesanan
                    </h6>
                    @if($cart && $cart->items->isNotEmpty())
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                            {{ $cart->items->count() }} Item
                        </span>
                    @endif
                </div>

                <div class="px-4 mt-3">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show p-3 text-white" role="alert">
                            <span class="alert-icon"><i class="material-symbols-rounded text-md">check_circle</i></span>
                            <span class="alert-text ms-2 text-sm font-weight-bold">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show p-3 text-white" role="alert">
                            <ul class="mb-0 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

                <div class="card-body px-0 pt-2 pb-2">
                    @if($cart && $cart->items->isNotEmpty())
                        <!-- Desktop View -->
                        <div class="table-responsive d-none d-md-block p-4 pt-0">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 rounded-start">Obat</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 rounded-end">Aksi</th>
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
                                            <td class="ps-3">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $item->obat->nama_obat }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $item->obat->kode_obat }}</p>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-bold">{{ $item->jumlah }}</span>
                                            </td>
                                            <td class="align-middle text-end">
                                                <span class="text-secondary text-sm">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-end">
                                                <span class="text-primary text-sm font-weight-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <form action="{{ route('karyawan.cart.remove', $item->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger text-gradient p-0 mb-0" title="Hapus">
                                                        <i class="material-symbols-rounded text-lg">delete</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile View -->
                        <div class="d-md-none px-3 pb-3">
                            @php $total = 0; @endphp
                            @foreach($cart->items as $item)
                                @php
                                    $subtotal = $item->jumlah * $item->harga_satuan;
                                    $total += $subtotal;
                                @endphp
                                <div class="card mb-3 border shadow-none bg-gray-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="text-dark font-weight-bold mb-0">{{ $item->obat->nama_obat }}</h6>
                                                <span class="badge bg-white text-secondary border">{{ $item->obat->kode_obat }}</span>
                                            </div>
                                            <form action="{{ route('karyawan.cart.remove', $item->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 m-0">
                                                    <i class="material-symbols-rounded">delete</i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end mt-3">
                                            <div>
                                                <p class="text-xs text-muted mb-1">Harga Satuan</p>
                                                <p class="text-sm text-dark mb-0">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} x {{ $item->jumlah }}</p>
                                            </div>
                                            <div class="text-end">
                                                <p class="text-xs text-muted mb-1">Subtotal</p>
                                                <h6 class="text-primary font-weight-bold mb-0">Rp {{ number_format($subtotal, 0, ',', '.') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Footer Summary -->
                        <div class="bg-gray-100 p-4 mx-0 mx-md-4 mb-4 rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <span class="text-muted text-sm font-weight-bold text-uppercase d-block">Total Pembayaran</span>
                                    <span class="text-xs text-muted">Siap untuk diajukan ke kasir</span>
                                </div>
                                <h3 class="font-weight-bold text-primary mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                            </div>
                            <form action="{{ route('karyawan.cart.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 py-3 text-uppercase font-weight-bold letter-spacing-1 shadow-success">
                                    <span class="d-flex align-items-center justify-content-center">
                                        Kirim ke Kasir <i class="material-symbols-rounded ms-2">arrow_forward</i>
                                    </span>
                                </button>
                            </form>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5 my-3">
                            <div class="bg-gray-100 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                                <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 3.5rem;">shopping_cart_off</i>
                            </div>
                            <h5 class="text-dark font-weight-bold mb-2">Keranjang Belanja Kosong</h5>
                            <p class="text-muted text-sm mb-4 mx-auto" style="max-width: 300px;">
                                Belum ada obat yang ditambahkan. Silakan pilih obat dari formulir di sebelah kiri.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: QR Code Scanner -->
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold" id="qrScannerLabel">
                    <i class="material-symbols-rounded align-middle me-2 text-primary">qr_code_scanner</i> Pindai Barcode
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="alert alert-info text-white border-0 shadow-none mb-3 d-flex align-items-center" role="alert">
                    <i class="material-symbols-rounded me-2">info</i>
                    <div class="text-xs">Pastikan cahaya cukup dan posisikan barcode di dalam kotak.</div>
                </div>
                <div class="overflow-hidden rounded-3 border bg-dark position-relative" style="min-height: 300px;">
                    <div id="qr-reader" style="width: 100%;"></div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    #qr-reader__dashboard { padding: 0 !important; border: none !important; }
    #qr-reader__scan_region video { width: 100% !important; height: auto !important; object-fit: cover; border-radius: 0.5rem; }
    #qr-reader__scan_region { background: transparent !important; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .shadow-success { box-shadow: 0 4px 20px 0 rgba(45, 206, 137, 0.35); }
    
    @media (max-width: 767.98px) {
        .container-fluid { padding-bottom: 80px; } /* Space for potential sticky elements if added later */
    }
</style>

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
            console.log(`Scan result: ${decodedText}`, decodedResult);
            
            const select = document.getElementById('obatSelect');
            let found = false;
            
            // Search for option with matching data-barcode
            for (let i = 0; i < select.options.length; i++) {
                const optionBarcode = select.options[i].getAttribute('data-barcode');
                if (optionBarcode && optionBarcode === decodedText) {
                    select.selectedIndex = i;
                    found = true;
                    break;
                }
            }

            if (found) {
                // Close modal
                const modalEl = document.getElementById('qrScannerModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if(modal) modal.hide();
                
                // Stop scanner
                if(html5QrcodeScanner) {
                    html5QrcodeScanner.clear().catch(err => console.error(err));
                }

                // Optional: Focus quantity or show success
                alert('Obat ditemukan: ' + select.options[select.selectedIndex].text);
            } else {
                alert('Obat tidak ditemukan untuk barcode: ' + decodedText);
            }
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // console.warn(`Code scan error = ${error}`);
        }

        const btnOpenQr = document.getElementById('btnOpenQr');
        if(btnOpenQr) {
            btnOpenQr.addEventListener('click', function() {
                const modalEl = document.getElementById('qrScannerModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
                
                // Initialize scanner when modal opens
                // Remove previous listener if any to avoid duplicates (though {once:true} handles it)
                const onShown = function () {
                    if(!html5QrcodeScanner) {
                        html5QrcodeScanner = new Html5QrcodeScanner(
                            "qr-reader",
                            { fps: 10, qrbox: {width: 250, height: 250} },
                            /* verbose= */ false
                        );
                    }
                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                };
                
                modalEl.removeEventListener('shown.bs.modal', onShown); // Safety
                modalEl.addEventListener('shown.bs.modal', onShown, { once: true });

                // Clear scanner when modal closes
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
</script>
@endpush

@endsection