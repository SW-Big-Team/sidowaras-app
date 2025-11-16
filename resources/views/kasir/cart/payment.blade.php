@extends('layouts.kasir.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-gradient-success text-white text-center">
                    <h5>Input Pembayaran</h5>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <h6>Cart: CART-{{ str_pad($cart->id, 3, '0', STR_PAD_LEFT) }}</h6>
                    <p>Total Harga: <strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></p>

                    <form action="{{ route('kasir.cart.processPayment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                        <input type="hidden" name="total_harga" value="{{ $totalHarga }}">

                        <div class="mb-3">
                            <label>Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-control" required>
                                <option value="tunai">Tunai</option>
                                <option value="non tunai">Non Tunai</option>
                            </select>
                        </div>

                        <!-- Field Total Bayar (hanya muncul jika Tunai) -->
                        <div class="mb-3" id="bayar-field" style="display:none;">
                            <label>Total Bayar</label>
                            <input type="number" name="total_bayar" class="form-control" min="{{ $totalHarga }}" placeholder="0" required>
                            <small class="text-muted">Biarkan kosong jika tidak perlu hitung kembalian</small>
                        </div>

                        <!-- Display Kembalian -->
                        <div class="mb-3" id="kembalian-field" style="display:none;">
                            <label>Kembalian</label>
                            <input type="text" class="form-control" readonly id="kembalian-display">
                        </div>

                        <button type="submit" class="btn btn-success w-100">Proses Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const metodeSelect = document.querySelector('select[name="metode_pembayaran"]');
    const bayarField = document.getElementById('bayar-field');
    const kembalianField = document.getElementById('kembalian-field');
    const kembalianDisplay = document.getElementById('kembalian-display');
    const totalHarga = {{ $totalHarga }};

    if (!metodeSelect || !bayarField) return;

    function toggleBayarField() {
        const inputBayar = bayarField.querySelector('input[name="total_bayar"]');
        
        if (metodeSelect.value === 'tunai') {
            bayarField.style.display = 'block';
            kembalianField.style.display = 'block';

            inputBayar.setAttribute('required', 'required');
            inputBayar.setAttribute('min', totalHarga);
            inputBayar.value = '';

            // Hitung kembalian secara real-time
            inputBayar.addEventListener('input', function () {
                const bayar = parseFloat(this.value) || 0;
                const kembalian = bayar - totalHarga;
                kembalianDisplay.value = kembalian >= 0 
                    ? 'Rp ' + new Intl.NumberFormat('id-ID').format(kembalian) 
                    : 'Kurang!';
            });
        } else {
            bayarField.style.display = 'none';
            kembalianField.style.display = 'none';
            
            // Hapus atribut required agar form bisa disubmit untuk non tunai
            inputBayar.removeAttribute('required');
            inputBayar.value = '';
        }
    }

    // Jalankan saat halaman dimuat
    toggleBayarField();

    // Jalankan saat pilihan berubah
    metodeSelect.addEventListener('change', toggleBayarField);
});
</script>
@endpush
@endsection