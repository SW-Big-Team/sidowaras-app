@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Tambah Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('pembelian.index') }}">Pembelian</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Pembelian</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Tambah Pembelian Baru" subtitle="Form untuk menambahkan data pembelian obat dari supplier">
        <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary mb-0">
            <i class="material-symbols-rounded text-sm me-1">arrow_back</i> Kembali
        </a>
    </x-content-header>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
            <span class="alert-text">
                <strong>Error!</strong> Terdapat kesalahan dalam pengisian form:
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('pembelian.store') }}" method="POST" id="formPembelian">
        @csrf

        <!-- SECTION 1: INFORMASI PEMBELIAN -->
        <div class="card mb-4">
            <div class="card-header p-3 pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                        <i class="material-symbols-rounded opacity-10 text-lg">receipt_long</i>
                    </div>
                    <div>
                        <h6 class="mb-0">Informasi Pembelian</h6>
                        <p class="text-sm text-secondary mb-0">Data dasar transaksi pembelian</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-static mb-3">
                            <label>No Faktur</label>
                            <input type="text" name="no_faktur" class="form-control" value="{{ old('no_faktur') }}" placeholder="Auto generate">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-static mb-3">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="tgl_pembelian" class="form-control" value="{{ old('tgl_pembelian', now()->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-static mb-3">
                            <label>Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="metode_pembayaran" class="form-control" required>
                                <option value="tunai" @selected(old('metode_pembayaran', 'tunai') === 'tunai')>Tunai</option>
                                <option value="non tunai" @selected(old('metode_pembayaran') === 'non tunai')>Non Tunai</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-static mb-3">
                            <label>Total Harga</label>
                            <input type="text" id="total_harga_display" class="form-control fw-bold text-success" value="Rp 0" readonly>
                            <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', 0) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-3">
                            <label>Nama Pengirim <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pengirim" class="form-control" value="{{ old('nama_pengirim') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-3">
                            <label>No Telepon Pengirim</label>
                            <input type="text" name="no_telepon_pengirim" class="form-control" value="{{ old('no_telepon_pengirim') }}" placeholder="Opsional">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: DETAIL OBAT -->
        <div class="card mb-4">
            <div class="card-header p-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                            <i class="material-symbols-rounded opacity-10 text-lg">medication</i>
                        </div>
                        <div>
                            <h6 class="mb-0">Detail Obat</h6>
                            <p class="text-sm text-secondary mb-0">Daftar obat yang dibeli</p>
                        </div>
                    </div>
                    <button type="button" class="btn bg-gradient-primary mb-0" id="btnTambahObat">
                        <i class="material-symbols-rounded text-sm me-1">add</i> Tambah Obat
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row g-3" id="containerObat">
                    <!-- Obat cards will be added here by JavaScript -->
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary mb-0">
                <i class="material-symbols-rounded text-sm me-1">close</i> Batal
            </a>
            <button type="submit" class="btn bg-gradient-primary mb-0">
                <i class="material-symbols-rounded text-sm me-1">save</i> Simpan Pembelian
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
        border: 1px solid #d2d6da;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .obat-card:hover .card {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
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
                <div class="card-header p-3 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-sm icon-shape bg-gradient-warning shadow text-center border-radius-md me-2">
                                <i class="material-symbols-rounded opacity-10 text-sm">pill</i>
                            </div>
                            <h6 class="mb-0">Obat #${index + 1}</h6>
                        </div>
                        <button type="button" class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 btn-sm" onclick="removeObatCard(this)" title="Hapus">
                            <i class="material-symbols-rounded text-sm">close</i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="input-group input-group-static mb-3">
                        <label>Pilih Obat <span class="text-danger">*</span></label>
                        <select name="obat[${index}][obat_id]" class="form-control" required>
                            ${optionsHtml}
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group input-group-static mb-3">
                                <label>Harga Beli <span class="text-danger">*</span></label>
                                <input type="text" class="form-control harga-beli-display" required placeholder="Rp 0" data-index="${index}">
                                <input type="hidden" name="obat[${index}][harga_beli]" class="harga-beli" value="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-static mb-3">
                                <label>Harga Jual <span class="text-danger">*</span></label>
                                <input type="text" class="form-control harga-jual-display" required placeholder="Rp 0" data-index="${index}">
                                <input type="hidden" name="obat[${index}][harga_jual]" class="harga-jual" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group input-group-static mb-3">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="obat[${index}][jumlah_masuk]" class="form-control jumlah-masuk" required min="1" value="1" onchange="hitungTotal()">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-static mb-3">
                                <label>Kadaluarsa <span class="text-danger">*</span></label>
                                <input type="date" name="obat[${index}][tgl_kadaluarsa]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-group input-group-static mb-0">
                        <label>Subtotal</label>
                        <input type="text" class="form-control subtotal fw-bold text-success" readonly value="Rp 0">
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
            // Use Material Design alert
            const alert = document.createElement('div');
            alert.className = 'alert alert-warning alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4';
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <span class="alert-icon"><i class="material-symbols-rounded">warning</i></span>
                <span class="alert-text">Minimal harus ada 1 obat dalam pembelian!</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 3000);
        }
    };

    function updateObatNumbers() {
        const cards = containerObat.querySelectorAll('.obat-card');
        cards.forEach((card, idx) => {
            card.querySelector('h6').textContent = `Obat #${idx + 1}`;
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
