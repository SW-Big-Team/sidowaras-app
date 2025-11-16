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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
                            <span class="alert-text">
                                <strong>Terdapat kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('pembelian.store') }}" method="POST" id="formPembelian">
                        @csrf

                        <!-- Informasi Pembelian -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded opacity-10">receipt_long</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Informasi Pembelian</h6>
                                        <p class="text-sm text-secondary mb-0">Data faktur dan pembayaran</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static">
                                    <label>No Faktur</label>
                                    <input type="text" name="no_faktur" class="form-control" value="{{ old('no_faktur') }}" placeholder="Auto generate">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="tgl_pembelian" class="form-control" value="{{ old('tgl_pembelian', now()->format('Y-m-d\TH:i')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                        <option value="tunai" @selected(old('metode_pembayaran', 'tunai') === 'tunai')>Tunai</option>
                                        <option value="non tunai" @selected(old('metode_pembayaran') === 'non tunai')>Non Tunai</option>
                                        <option value="termin" @selected(old('metode_pembayaran') === 'termin')>Termin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Total Harga</label>
                                    <input type="text" id="total_harga_display" class="form-control fw-bold text-success" value="Rp 0" readonly>
                                    <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', 0) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Data Pengirim -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded opacity-10">local_shipping</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Data Pengirim</h6>
                                        <p class="text-sm text-secondary mb-0">Informasi pengirim barang</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Nama Pengirim <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pengirim" class="form-control" value="{{ old('nama_pengirim') }}" placeholder="Masukkan nama pengirim" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static">
                                    <label>No Telepon Pengirim</label>
                                    <input type="text" name="no_telepon_pengirim" class="form-control" value="{{ old('no_telepon_pengirim') }}" placeholder="Nomor telepon (opsional)">
                                </div>
                            </div>
                        </div>

                        <!-- Detail Obat -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                                            <i class="material-symbols-rounded opacity-10">medication</i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Detail Obat</h6>
                                            <p class="text-sm text-secondary mb-0">Daftar obat yang dibeli</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm bg-gradient-success mb-0" id="btnTambahObat">
                                        <i class="material-symbols-rounded text-sm me-1">add</i> Tambah Obat
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-3" id="containerObat">
                                    @if(old('obat'))
                                        @foreach(old('obat') as $i => $obat)
                                            <script>
                                                window.oldObat = window.oldObat || [];
                                                window.oldObat.push(@json($obat));
                                            </script>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detail Termin -->
                        <div class="row mb-4" id="cardTermin" style="display: none;">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md me-3">
                                            <i class="material-symbols-rounded opacity-10">event</i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Detail Termin Pembayaran</h6>
                                            <p class="text-sm text-secondary mb-0">Jadwal pembayaran bertahap</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm bg-gradient-warning mb-0" id="btnTambahTermin">
                                        <i class="material-symbols-rounded text-sm me-1">add</i> Tambah Termin
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="containerTermin" class="mb-3">
                                    @if(old('termin_list'))
                                        @foreach(old('termin_list') as $i => $termin)
                                            <script>
                                                window.oldTermin = window.oldTermin || [];
                                                window.oldTermin.push(@json($termin));
                                            </script>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <hr class="horizontal dark my-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary mb-0">
                                        <i class="material-symbols-rounded text-sm me-1">close</i> Batal
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary mb-0">
                                        <i class="material-symbols-rounded text-sm me-1">save</i> Simpan Pembelian
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .obat-card { 
        transition: all 0.3s ease; 
    }
    .obat-card .card { 
        height: 100%; 
        border: 1px solid #e9ecef;
        border-radius: 0.75rem;
    }
    .obat-card:hover .card { 
        box-shadow: 0 4px 20px 0 rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .obat-card .card-header { 
        background: linear-gradient(195deg, #667eea 0%, #764ba2 100%);
        padding: 0.75rem 1rem;
        border-radius: 0.75rem 0.75rem 0 0;
    }
    .form-label.small { 
        font-size: 0.875rem; 
        font-weight: 600; 
        color: #344767;
        margin-bottom: 0.5rem;
    }
    .badge-number { 
        font-size: 0.875rem; 
        padding: 0.4rem 0.75rem;
        font-weight: 600;
    }
    .termin-row {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
    }
    .termin-row:hover {
        box-shadow: 0 2px 10px 0 rgba(0,0,0,0.05);
    }
    .termin-row:last-child {
        margin-bottom: 0;
    }
    .gap-2 {
        gap: 0.5rem !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === DEKLARASI ELEMEN ===
    const containerObat = document.getElementById('containerObat');
    const btnTambahObat = document.getElementById('btnTambahObat');
    const totalHargaInput = document.getElementById('total_harga');
    const totalHargaDisplay = document.getElementById('total_harga_display');
    const formPembelian = document.getElementById('formPembelian');
    let obatCounter = 0;
    let terminCounter = 0;

    const obatList = @json($obatList ?? []);
    
    const metodePembayaranSelect = document.getElementById('metode_pembayaran');
    const cardTermin = document.getElementById('cardTermin');
    const containerTermin = document.getElementById('containerTermin');
    const btnTambahTermin = document.getElementById('btnTambahTermin');

    // === FUNGSI UTAMA ===

    function formatInputRupiah(displayInput, hiddenInput, callbackOnInput = null) {
        displayInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            let numericValue = parseInt(value) || 0;
            
            hiddenInput.value = numericValue;
            
            if (value === '') {
                e.target.value = '';
            } else {
                e.target.value = 'Rp ' + numericValue.toLocaleString('id-ID');
            }
            if (callbackOnInput) {
                callbackOnInput();
            }
        });
        
        let initialValue = hiddenInput.value;
         if (initialValue && parseInt(initialValue) > 0) {
            let numericValue = parseInt(initialValue);
            displayInput.value = 'Rp ' + numericValue.toLocaleString('id-ID');
        }
    }

    function formatRupiah(angka) {
        return 'Rp ' + (Number(angka) || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    // --- FUNGSI OBAT ---

    function createObatCard(data = {}) {
        const index = obatCounter++;
        const col = document.createElement('div');
        col.className = 'col-12 col-md-6 col-lg-4 obat-card';
        col.setAttribute('data-index', index);
        
        let optionsHtml = '<option value="">-- Pilih Obat --</option>';
        obatList.forEach(obat => {
            const selected = (data.obat_id && data.obat_id == obat.id) ? 'selected' : '';
            optionsHtml += `<option value="${obat.id}" ${selected}>${obat.nama_obat}${obat.barcode ? ' (' + obat.barcode + ')' : ''}</option>`;
        });

        col.innerHTML = `
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <span class="badge bg-white text-dark badge-number">Obat #${index + 1}</span>
                    <button type="button" class="btn btn-sm btn-danger btn-remove" onclick="removeObatCard(this)" style="padding: 0.25rem 0.5rem;">
                        <i class="material-symbols-rounded text-sm">delete</i>
                    </button>
                </div>
                <div class="card-body p-3">
                    <div class="input-group input-group-static mb-3">
                        <label>Pilih Obat <span class="text-danger">*</span></label>
                        <select name="obat[${index}][obat_id]" class="form-control" required>
                            ${optionsHtml}
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="input-group input-group-static">
                                <label>Harga Beli <span class="text-danger">*</span></label>
                                <input type="text" class="form-control harga-beli-display" required placeholder="Rp 0">
                                <input type="hidden" name="obat[${index}][harga_beli]" class="harga-beli" value="${data.harga_beli || 0}">
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="input-group input-group-static">
                                <label>Harga Jual <span class="text-danger">*</span></label>
                                <input type="text" class="form-control harga-jual-display" required placeholder="Rp 0">
                                <input type="hidden" name="obat[${index}][harga_jual]" class="harga-jual" value="${data.harga_jual || 0}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="input-group input-group-static">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="obat[${index}][jumlah_masuk]" class="form-control jumlah-masuk" required min="1" value="${data.jumlah_masuk || 1}">
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="input-group input-group-static">
                                <label>Kadaluarsa <span class="text-danger">*</span></label>
                                <input type="date" name="obat[${index}][tgl_kadaluarsa]" class="form-control" value="${data.tgl_kadaluarsa || ''}" required>
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
        
        const hargaBeliDisplay = col.querySelector('.harga-beli-display');
        const hargaBeliHidden = col.querySelector('.harga-beli');
        formatInputRupiah(hargaBeliDisplay, hargaBeliHidden, hitungTotal);
        
        const hargaJualDisplay = col.querySelector('.harga-jual-display');
        const hargaJualHidden = col.querySelector('.harga-jual');
        formatInputRupiah(hargaJualDisplay, hargaJualHidden);
        
        col.querySelector('.jumlah-masuk').addEventListener('input', hitungTotal);
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
        containerObat.querySelectorAll('.obat-card').forEach((card, idx) => {
            card.querySelector('.badge-number').textContent = `Obat #${idx + 1}`;
        });
    }

    window.hitungTotal = function() {
        let total = 0;
        containerObat.querySelectorAll('.obat-card').forEach(card => {
            const hargaBeli = parseFloat(card.querySelector('.harga-beli').value) || 0;
            const jumlahMasuk = parseInt(card.querySelector('.jumlah-masuk').value) || 0;
            const subtotal = hargaBeli * jumlahMasuk;
            
            card.querySelector('.subtotal').value = formatRupiah(subtotal);
            total += subtotal;
        });
        
        totalHargaInput.value = total.toFixed(2);
        totalHargaDisplay.value = formatRupiah(total);
    };

    // --- FUNGSI TERMIN ---

    function createTerminCard(data = {}) {
        const index = terminCounter++;
        const row = document.createElement('div');
        row.className = 'termin-row';
        row.setAttribute('data-index', index);
        
        row.innerHTML = `
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <span class="badge bg-gradient-dark badge-number">#${index + 1}</span>
                </div>
                <div class="col-md-5">
                    <div class="input-group input-group-static">
                        <label>Jumlah Bayar</label>
                        <input type="text" class="form-control termin-jumlah-display" placeholder="Rp 0 (Boleh kosong)">
                        <input type="hidden" name="termin_list[${index}][jumlah_bayar]" class="termin-jumlah-bayar" value="${data.jumlah_bayar || 0}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group input-group-static">
                        <label>Tgl. Jatuh Tempo <span class="text-danger">*</span></label>
                        <input type="date" name="termin_list[${index}][tgl_jatuh_tempo]" class="form-control" value="${data.tgl_jatuh_tempo || ''}" required>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-termin" style="padding: 0.5rem;">
                        <i class="material-symbols-rounded text-sm">delete</i>
                    </button>
                </div>
            </div>
        `;
        
        containerTermin.appendChild(row);
        
        const jumlahDisplay = row.querySelector('.termin-jumlah-display');
        const jumlahHidden = row.querySelector('.termin-jumlah-bayar');
        formatInputRupiah(jumlahDisplay, jumlahHidden);
        
        row.querySelector('.btn-remove-termin').addEventListener('click', function() {
            removeTerminCard(this);
        });
    }

    function removeTerminCard(btn) {
        btn.closest('.termin-row').remove();
        updateTerminNumbers();
    }

    function updateTerminNumbers() {
        containerTermin.querySelectorAll('.termin-row').forEach((row, idx) => {
            row.querySelector('.badge-number').textContent = `#${idx + 1}`;
        });
    }

    function toggleTerminCard() {
        if (metodePembayaranSelect.value === 'termin') {
            cardTermin.style.display = 'block';
            if (containerTermin.querySelectorAll('.termin-row').length === 0 && !window.oldTermin) {
                 createTerminCard(); 
            }
        } else {
            cardTermin.style.display = 'none';
        }
    }

    function validasiForm(e) {
        if (metodePembayaranSelect.value === 'termin') {
            if (containerTermin.querySelectorAll('.            if (containerTermin.querySelectorAll('.termin-row').length === 0) {
                e.preventDefault();
                alert('Validasi Gagal!\nAnda memilih metode TERMIN, tapi belum menambahkan baris termin.');
                cardTermin.scrollIntoView({ behavior: 'smooth' });
                return false;
            }
        }
        return true;
    }

    // === EVENT LISTENERS ===
    
    btnTambahObat.addEventListener('click', function() {
        createObatCard();
    });

    metodePembayaranSelect.addEventListener('change', toggleTerminCard);
    btnTambahTermin.addEventListener('click', function() {
        createTerminCard();
    });
    formPembelian.addEventListener('submit', validasiForm);

    // === INISIALISASI ===
    
    if (window.oldObat && window.oldObat.length > 0) {
        window.oldObat.forEach(data => {
            createObatCard(data);
        });
    } else {
        createObatCard();
    }
    
    if (window.oldTermin && window.oldTermin.length > 0) {
        window.oldTermin.forEach(data => {
            createTerminCard(data);
        });
    }

    hitungTotal();
    toggleTerminCard();
});
</script>
@endsection
