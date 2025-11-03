@extends('layouts.karyawan.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h4 class="text-dark font-weight-bold mb-1">Keranjang Penjualan</h4>
            <p class="text-sm text-muted mb-4">Bantu pelanggan pilih obat, masukkan ke keranjang, lalu kirim ke kasir untuk approval</p>
        </div>
    </div>

    <div class="row">
        <!-- Form Tambah Obat -->
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Tambah Obat ke Keranjang</h6>
                </div>
                <div class="card-body">
                <form action="{{ route('karyawan.cart.add') }}" method="POST">
                        @csrf
                    <div class="mb-3">
                        <label class="form-label text-sm">Pilih Obat</label>
                        <div class="input-group">
                            <select name="obat_id" class="form-control" required>
                                <option value="">-- Cari atau pilih obat --</option>
                                @foreach($obats as $obat)
                                    <option value="{{ $obat->id }}" data-stok="{{ $obat->stok_tersedia ?? 0 }}">
                                        {{ $obat->nama_obat }} ({{ $obat->kode_obat }})
                                        @if($obat->stok_tersedia && $obat->stok_tersedia > 0)
                                            — Stok: {{ $obat->stok_tersedia }}
                                        @else
                                            — <span class="text-danger">Stok habis</span>
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <a href="{{ route('scanner') }}" class="btn btn-outline-primary" title="Scan Barcode">
                                <i class="material-symbols-rounded">qr_code_scanner</i>
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">Tambah ke Keranjang</button>
                </div>
            </div>
        </div>

        <!-- Keranjang Saat Ini -->
        <div class="col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="text-dark font-weight-bold mb-0">Keranjang Anda</h6>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-2 p-2" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-2 p-2" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($cart && $cart->items->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Obat</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
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
                                                <p class="text-sm font-weight-bold mb-0">{{ $item->obat->nama_obat }}</p>
                                                <p class="text-xs text-muted mb-0">{{ $item->obat->kode_obat }}</p>
                                            </td>
                                            <td><span class="text-sm">{{ $item->jumlah }}</span></td>
                                            <td><span class="text-sm">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span></td>
                                            <td><span class="text-sm font-weight-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></td>
                                            <td>
                                                <form action="{{ route('karyawan.cart.remove', $item->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" title="Hapus">
                                                        <i class="material-symbols-rounded">delete</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td colspan="2"><strong class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if(!$cart->metode_pembayaran)
                            <form action="{{ route('karyawan.cart.checkout') }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label text-sm">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" class="form-control" required>
                                        <option value="">-- Pilih metode pembayaran --</option>
                                        <option value="tunai">Tunai</option>
                                        <option value="non tunai">Non Tunai</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    Simpan & Kirim ke Kasir untuk Approval
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info mt-4 mb-0">
                                <i class="material-symbols-rounded me-1">info</i>
                                <strong>Keranjang siap!</strong> Menunggu approval dari kasir.<br>
                                Metode: <strong>{{ ucfirst($cart->metode_pembayaran) }}</strong>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="material-symbols-rounded text-muted" style="font-size: 3rem;">shopping_cart</i>
                            <p class="text-muted mt-2">Keranjang Anda kosong</p>
                            <p class="text-sm text-muted">Pilih obat di sebelah kiri untuk memulai</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection