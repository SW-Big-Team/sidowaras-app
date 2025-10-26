@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@section('content')
<div class="container-fluid mt-4 px-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Tambah Pembelian</h4>
        <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Error!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembelian.store') }}" method="POST" id="formPembelian">
        @csrf

        <!-- SECTION 1: INFORMASI PEMBELIAN -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0"><i class="fas fa-file-invoice"></i> Informasi Pembelian</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">No Faktur</label>
                        <input type="text" name="no_faktur" class="form-control form-control-sm" value="{{ old('no_faktur') }}" placeholder="Auto">
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">Tanggal <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="tgl_pembelian" class="form-control form-control-sm" value="{{ old('tgl_pembelian', now()->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode_pembayaran" class="form-select form-select-sm" required>
                            <option value="tunai" @selected(old('metode_pembayaran', 'tunai') === 'tunai')>Tunai</option>
                            <option value="non tunai" @selected(old('metode_pembayaran') === 'non tunai')>Non Tunai</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">Total Harga</label>
                        <input type="text" id="total_harga_display" class="form-control form-control-sm bg-light fw-bold text-success" value="Rp 0" readonly>
                        <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', 0) }}">
                    </div>
                </div>
                <div class="row g-2 mt-1">
                    <div class="col-md-6 col-12">
                        <label class="form-label small mb-1">Nama Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pengirim" class="form-control form-control-sm" value="{{ old('nama_pengirim') }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small mb-1">No Telepon Pengirim</label>
                        <input type="text" name="no_telepon_pengirim" class="form-control form-control-sm" value="{{ old('no_telepon_pengirim') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: DETAIL OBAT -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2">
                <h6 class="mb-0"><i class="fas fa-pills"></i> Detail Obat</h6>
                <button type="button" class="btn btn-sm btn-light" id="btnTambahObat">
                    <i class="fas fa-plus"></i> Tambah Obat
                </button>
            </div>
            <div class="card-body p-3">
                <div class="row g-3" id="containerObat">
                    <!-- Obat cards will be added here by JavaScript -->
                </div>
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Pembelian
            </button>
        </div>
    </form>
</div>

<style>
    .obat-card {
        transition: all 0.3s ease;
    }
    .obat-card .card {
        height: 100%;
        border: 2px solid #e9ecef;
    }
    .obat-card:hover .card {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }
    .obat-card .card-header {
        background: #764ba2;
        padding: 0.5rem 0.75rem;
    }
    .form-label.small {
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
    }
    .form-control-sm, .form-select-sm {
        font-size: 0.85rem;
    }
    .badge-number {
        font-size: 0.9rem;
        padding: 0.35rem 0.65rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const containerObat = document.getElementById('containerObat');
    const btnTambahObat = document.getElementById('btnTambahObat');
    const totalHargaInput = document.getElementById('total_harga');
    let obatCounter = 0;

    const obatList = @json($obatList);

    // Format input as Rupiah while typing
    function formatInputRupiah(displayInput, hiddenInput) {
        let value = displayInput.value.replace(/[^0-9]/g, ''); // Remove non-numeric
        let numericValue = parseInt(value) || 0;
        
        // Update hidden input with numeric value
        hiddenInput.value = numericValue;
        
        // Format display with Rupiah
        if (value === '') {
            displayInput.value = '';
        } else {
            displayInput.value = 'Rp ' + numericValue.toLocaleString('id-ID');
        }
    }

    function createObatCard() {
        const index = obatCounter++;
        const col = document.createElement('div');
        col.className = 'col-12 col-md-6 col-lg-4 obat-card';
        col.setAttribute('data-index', index);
        
        let optionsHtml = '<option value="">-- Pilih Obat --</option>';
        obatList.forEach(obat => {
            optionsHtml += `<option value="${obat.id}">${obat.nama_obat}${obat.barcode ? ' (' + obat.barcode + ')' : ''}</option>`;
        });

        col.innerHTML = `
            <div class="card">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <span class="badge bg-white text-dark badge-number">Obat #${index + 1}</span>
                    <button type="button" class="btn btn-sm btn-danger btn-remove" onclick="removeObatCard(this)" style="padding: 0.15rem 0.4rem;">
                        Hapus
                    </button>
                </div>
                <div class="card-body p-2">
                    <div class="mb-2">
                        <label class="form-label small mb-1">Pilih Obat <span class="text-danger">*</span></label>
                        <select name="obat[${index}][obat_id]" class="form-select form-select-sm" required>
                            ${optionsHtml}
                        </select>
                    </div>
                    
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small mb-1">Harga Beli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm harga-beli-display" required placeholder="Rp 0" data-index="${index}">
                            <input type="hidden" name="obat[${index}][harga_beli]" class="harga-beli" value="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Harga Jual <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm harga-jual-display" required placeholder="Rp 0" data-index="${index}">
                            <input type="hidden" name="obat[${index}][harga_jual]" class="harga-jual" value="0">
                        </div>
                    </div>
                    
                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <label class="form-label small mb-1">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="obat[${index}][jumlah_masuk]" class="form-control form-control-sm jumlah-masuk" required min="1" value="1" onchange="hitungTotal()">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Kadaluarsa <span class="text-danger">*</span></label>
                            <input type="date" name="obat[${index}][tgl_kadaluarsa]" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <label class="form-label small mb-1">Subtotal</label>
                        <input type="text" class="form-control form-control-sm subtotal bg-light fw-bold text-success" readonly value="Rp 0">
                    </div>
                </div>
            </div>
        `;
        
        containerObat.appendChild(col);
        
        // Add event listeners for Rupiah formatting
        const hargaBeliDisplay = col.querySelector('.harga-beli-display');
        const hargaBeliHidden = col.querySelector('.harga-beli');
        const hargaJualDisplay = col.querySelector('.harga-jual-display');
        const hargaJualHidden = col.querySelector('.harga-jual');
        
        hargaBeliDisplay.addEventListener('input', function(e) {
            formatInputRupiah(e.target, hargaBeliHidden);
            hitungTotal();
        });
        
        hargaJualDisplay.addEventListener('input', function(e) {
            formatInputRupiah(e.target, hargaJualHidden);
        });
    }

    window.removeObatCard = function(btn) {
        const obatCard = btn.closest('.obat-card');
        if (containerObat.querySelectorAll('.obat-card').length > 1) {
            obatCard.remove();
            hitungTotal();
            updateObatNumbers();
        } else {
            alert('Minimal harus ada 1 obat dalam pembelian!');
        }
    };

    function updateObatNumbers() {
        const cards = containerObat.querySelectorAll('.obat-card');
        cards.forEach((card, idx) => {
            card.querySelector('.badge-number').textContent = `Obat #${idx + 1}`;
        });
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    window.hitungTotal = function() {
        let total = 0;
        const cards = containerObat.querySelectorAll('.obat-card');
        
        cards.forEach(card => {
            // Read from hidden inputs (numeric values)
            const hargaBeli = parseFloat(card.querySelector('.harga-beli').value) || 0;
            const jumlahMasuk = parseInt(card.querySelector('.jumlah-masuk').value) || 0;
            const subtotal = hargaBeli * jumlahMasuk;
            
            // Display formatted subtotal
            card.querySelector('.subtotal').value = formatRupiah(subtotal);
            total += subtotal;
        });
        
        // Update hidden input with numeric value (for server)
        totalHargaInput.value = total.toFixed(2);
        
        // Update display input with Rupiah format (for user)
        document.getElementById('total_harga_display').value = formatRupiah(total);
    };

    btnTambahObat.addEventListener('click', function() {
        createObatCard();
    });

    // Add first card on page load
    createObatCard();
});
</script>
@endsection
