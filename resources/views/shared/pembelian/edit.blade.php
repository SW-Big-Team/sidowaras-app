@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Edit Pembelian')

@section('content')
<div class="container-fluid mt-4 px-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Pembelian</h4>
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

    {{-- MODIFIKASI: Ganti route dan tambah method PUT --}}
    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST" id="formPembelian">
        @csrf
        @method('PUT')

        <div class="card shadow-sm mb-3">
            <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0"><i class="fas fa-file-invoice"></i> Informasi Pembelian</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">No Faktur</label>
                        {{-- MODIFIKASI: Isi value --}}
                        <input type="text" name="no_faktur" class="form-control form-control-sm" value="{{ old('no_faktur', $pembelian->no_faktur) }}" placeholder="Auto">
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">Tanggal <span class="text-danger">*</span></label>
                        {{-- MODIFIKASI: Isi value --}}
                        <input type="datetime-local" name="tgl_pembelian" class="form-control form-control-sm" value="{{ old('tgl_pembelian', $pembelian->tgl_pembelian->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">Pembayaran <span class="text-danger">*</span></label>
                        {{-- MODIFIKASI: Isi value dan tambah 'termin' --}}
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select form-select-sm" required>
                            <option value="tunai" @selected(old('metode_pembayaran', $pembelian->metode_pembayaran) === 'tunai')>Tunai</option>
                            <option value="non tunai" @selected(old('metode_pembayaran', $pembelian->metode_pembayaran) === 'non tunai')>Non Tunai</option>
                            <option value="termin" @selected(old('metode_pembayaran', $pembelian->metode_pembayaran) === 'termin')>Termin</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small mb-1">Total Harga</label>
                        <input type="text" id="total_harga_display" class="form-control form-control-sm bg-light fw-bold text-success" value="Rp 0" readonly>
                        {{-- MODIFIKASI: Isi value --}}
                        <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', $pembelian->total_harga) }}">
                    </div>
                </div>
                <div class="row g-2 mt-1">
                    <div class="col-md-6 col-12">
                        <label class="form-label small mb-1">Nama Pengirim <span class="text-danger">*</span></label>
                        {{-- MODIFIKASI: Isi value --}}
                        <input type="text" name="nama_pengirim" class="form-control form-control-sm" value="{{ old('nama_pengirim', $pembelian->nama_pengirim) }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small mb-1">No Telepon Pengirim</label>
                        {{-- MODIFIKASI: Isi value --}}
                        <input type="text" name="no_telepon_pengirim" class="form-control form-control-sm" value="{{ old('no_telepon_pengirim', $pembelian->no_telepon_pengirim) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2">
                <h6 class="mb-0"><i class="fas fa-pills"></i> Detail Obat</h6>
                <button type="button" class="btn btn-sm btn-light" id="btnTambahObat">
                    <i class="fas fa-plus"></i> Tambah Obat
                </button>
            </div>
            <div class="card-body p-3">
                <div class="row g-3" id="containerObat">
                    {{-- Data obat akan di-load oleh script di bawah --}}
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm mb-3" id="cardTermin" style="display: none;">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center py-2">
                <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Detail Termin Pembayaran</h6>
                <button type="button" class="btn btn-sm btn-dark" id="btnTambahTermin">
                    <i class="fas fa-plus"></i> Tambah Termin
                </button>
            </div>
            <div class="card-body p-3">
                <div id="containerTermin" class="mb-3">
                    {{-- Data termin akan di-load oleh script di bawah --}}
                </div>
                <div class="p-3 bg-light rounded border">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label small mb-1">Total Pembelian</label>
                            <input type="text" id="termin_total_harga" class="form-control form-control-sm bg-white" readonly value="Rp 0">
                        </div>
                        <div class="col-4">
                            <label class="form-label small mb-1">Total Termin Dialokasikan</label>
                            <input type="text" id="termin_total_dialokasikan" class="form-control form-control-sm bg-white text-primary fw-bold" readonly value="Rp 0">
                        </div>
                        <div class="col-4">
                            <label class="form-label small mb-1">Sisa Alokasi</label>
                            <input type="text" id="termin_sisa_alokasi" class="form-control form-control-sm bg-white text-danger fw-bold" readonly value="Rp 0">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<style>
    /* ... (Style yang sama dengan create.blade.php) ... */
    .termin-row { border-bottom: 1px dashed #ccc; padding-bottom: 1rem; margin-bottom: 1rem; }
    .termin-row:last-child { border-bottom: 0; padding-bottom: 0; margin-bottom: 0; }
</style>

<script>
// NOTE: Script ini 95% SAMA DENGAN create.blade.php
// Perbedaan utamanya ada di bagian 'INISIALISASI' (paling bawah)
document.addEventListener('DOMContentLoaded', function() {
    // === DEKLARASI ELEMEN ===
    const containerObat = document.getElementById('containerObat');
    const btnTambahObat = document.getElementById('btnTambahObat');
    const totalHargaInput = document.getElementById('total_harga');
    const totalHargaDisplay = document.getElementById('total_harga_display');
    const formPembelian = document.getElementById('formPembelian');
    let obatCounter = 0;
    let terminCounter = 0;

    const obatList = @json($obatList);
    
    // BARU: Elemen Termin
    const metodePembayaranSelect = document.getElementById('metode_pembayaran');
    const cardTermin = document.getElementById('cardTermin');
    const containerTermin = document.getElementById('containerTermin');
    const btnTambahTermin = document.getElementById('btnTambahTermin');
    const terminTotalHarga = document.getElementById('termin_total_harga');
    const terminTotalDialokasikan = document.getElementById('termin_total_dialokasikan');
    const terminSisaAlokasi = document.getElementById('termin_sisa_alokasi');

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
        
        // Format nilai awal saat load
        let initialValue = hiddenInput.value;
         if (initialValue && parseFloat(initialValue) > 0) {
            let numericValue = parseFloat(initialValue);
            displayInput.value = 'Rp ' + numericValue.toLocaleString('id-ID');
        }
    }

    function formatRupiah(angka) {
        return 'Rp ' + (Number(angka) || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    // --- FUNGSI OBAT ---
    // (Fungsi createObatCard, removeObatCard, updateObatNumbers, hitungTotal SAMA PERSIS dengan create.blade.php)
    function createObatCard(data = {}) {
        const index = obatCounter++;
        const col = document.createElement('div');
        col.className = 'col-12 col-md-6 col-lg-4 obat-card';
        col.setAttribute('data-index', index);
        
        let optionsHtml = '<option value="">-- Pilih Obat --</option>';
        obatList.forEach(obat => {
            // MODIFIKASI: Cek data.obat_id
            const selected = (data.obat_id && data.obat_id == obat.id) ? 'selected' : '';
            optionsHtml += `<option value="${obat.id}" ${selected}>${obat.nama_obat}${obat.barcode ? ' (' + obat.barcode + ')' : ''}</option>`;
        });

        col.innerHTML = `
            <div class="card">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: #764ba2;">
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
                            <input type="text" class="form-control form-control-sm harga-beli-display" required placeholder="Rp 0">
                            {{-- MODIFIKASI: Isi value dari data --}}
                            <input type="hidden" name="obat[${index}][harga_beli]" class="harga-beli" value="${data.harga_beli || 0}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Harga Jual <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm harga-jual-display" required placeholder="Rp 0">
                            {{-- MODIFIKASI: Isi value dari data --}}
                            <input type="hidden" name="obat[${index}][harga_jual]" class="harga-jual" value="${data.harga_jual || 0}">
                        </div>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <label class="form-label small mb-1">Jumlah <span class="text-danger">*</span></label>
                            {{-- MODIFIKASI: Isi value dari data (gunakan jumlah_masuk) --}}
                            <input type="number" name="obat[${index}][jumlah_masuk]" class="form-control form-control-sm jumlah-masuk" required min="1" value="${data.jumlah_masuk || 1}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Kadaluarsa <span class="text-danger">*</span></label>
                            {{-- MODIFIKASI: Isi value dari data --}}
                            <input type="date" name="obat[${index}][tgl_kadaluarsa]" class="form-control form-control-sm" value="${data.tgl_kadaluarsa ? data.tgl_kadaluarsa.split('T')[0] : ''}" required>
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
            alert('Minimal harus ada 1 obat dalam pembelian!');
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
        
        // PENTING: Saat edit, jangan update total_harga dari subtotal
        // karena controller lama Anda menghitungnya secara manual.
        // Biarkan total_harga diisi dari $pembelian->total_harga.
        // totalHargaInput.value = total.toFixed(2);
        // totalHargaDisplay.value = formatRupiah(total);
        
        // Cek jika controller Anda sudah diupdate untuk multi-item,
        // Hapus komentar di 2 baris atas dan hapus 2 baris di bawah ini.
        let currentTotal = parseFloat(totalHargaInput.value) || 0;
        totalHargaDisplay.value = formatRupiah(currentTotal);


        hitungTotalTermin(); // Update summary termin
    };

    // --- BARU: FUNGSI TERMIN ---
    // (Fungsi createTerminCard, removeTerminCard, updateTerminNumbers, hitungTotalTermin, toggleTerminCard, validasiForm SAMA PERSIS dengan create.blade.php)
    function createTerminCard(data = {}) {
        const index = terminCounter++;
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-center termin-row';
        row.setAttribute('data-index', index);
        
        row.innerHTML = `
            <div class="col-1">
                <span class="badge bg-dark badge-number">#${index + 1}</span>
            </div>
            <div class="col-5">
                <label class="form-label small mb-1">Jumlah Bayar <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm termin-jumlah-display" required placeholder="Rp 0">
                <input type="hidden" name="termin_list[${index}][jumlah_bayar]" class="termin-jumlah-bayar" value="${data.jumlah_bayar || 0}">
            </div>
            <div class="col-5">
                <label class="form-label small mb-1">Tgl. Jatuh Tempo <span class="text-danger">*</span></label>
                <input type="date" name="termin_list[${index}][tgl_jatuh_tempo]" class="form-control form-control-sm" value="${data.tgl_jatuh_tempo ? data.tgl_jatuh_tempo.split('T')[0] : ''}" required>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-termin" style="padding: 0.15rem 0.4rem;">
                    &times;
                </button>
            </div>
        `;
        
        containerTermin.appendChild(row);
        
        const jumlahDisplay = row.querySelector('.termin-jumlah-display');
        const jumlahHidden = row.querySelector('.termin-jumlah-bayar');
        formatInputRupiah(jumlahDisplay, jumlahHidden, hitungTotalTermin);
        
        row.querySelector('.btn-remove-termin').addEventListener('click', function() {
            removeTerminCard(this);
        });
    }

    function removeTerminCard(btn) {
        btn.closest('.termin-row').remove();
        updateTerminNumbers();
        hitungTotalTermin();
    }

    function updateTerminNumbers() {
        containerTermin.querySelectorAll('.termin-row').forEach((row, idx) => {
            row.querySelector('.badge-number').textContent = `#${idx + 1}`;
        });
    }

    function hitungTotalTermin() {
        let totalAlokasi = 0;
        containerTermin.querySelectorAll('.termin-row').forEach(row => {
            totalAlokasi += parseFloat(row.querySelector('.termin-jumlah-bayar').value) || 0;
        });

        const totalPembelian = parseFloat(totalHargaInput.value) || 0;
        const sisaAlokasi = totalPembelian - totalAlokasi;

        terminTotalHarga.value = formatRupiah(totalPembelian);
        terminTotalDialokasikan.value = formatRupiah(totalAlokasi);
        terminSisaAlokasi.value = formatRupiah(sisaAlokasi);

        if (Math.abs(sisaAlokasi) < 0.01) {
            terminSisaAlokasi.classList.remove('text-danger');
            terminSisaAlokasi.classList.add('text-success');
        } else {
            terminSisaAlokasi.classList.add('text-danger');
            terminSisaAlokasi.classList.remove('text-success');
        }
        
        return totalAlokasi;
    }

    function toggleTerminCard() {
        if (metodePembayaranSelect.value === 'termin') {
            cardTermin.style.display = 'block';
        } else {
            cardTermin.style.display = 'none';
        }
    }

    function validasiForm(e) {
        // Peringatan: Logika update Anda saat ini masih single item.
        // Jika Anda update controller-nya, aktifkan validasi ini.
        /*
        if (metodePembayaranSelect.value === 'termin') {
            const totalPembelian = parseFloat(totalHargaInput.value) || 0;
            const totalAlokasi = hitungTotalTermin();
            
            if (Math.abs(totalPembelian - totalAlokasi) > 0.01) {
                e.preventDefault(); 
                alert('Validasi Gagal!\nTotal alokasi termin tidak sama dengan Total Harga Pembelian.');
                cardTermin.scrollIntoView({ behavior: 'smooth' });
                return false;
            }
             if (containerTermin.querySelectorAll('.termin-row').length === 0) {
                 e.preventDefault();
                alert('Validasi Gagal!\nAnda memilih metode TERMIN, tapi belum menambahkan detail termin.');
                cardTermin.scrollIntoView({ behavior: 'smooth' });
                return false;
            }
        }
        */
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


    // === MODIFIKASI: INISIALISASI (LOAD DATA) ===
    
    // Ambil data pembelian dari Blade
    const pembelian = @json($pembelian);
    
    // 1. Load data obat (stokBatches)
    if (pembelian.stok_batches && pembelian.stok_batches.length > 0) {
        pembelian.stok_batches.forEach(batchData => {
            createObatCard(batchData);
        });
    } else {
         createObatCard(); // Tetap buat 1 card kosong jika tidak ada data
    }
    
    // 2. Load data termin (pembayaranTermin)
     if (pembelian.pembayaran_termin && pembelian.pembayaran_termin.length > 0) {
        pembelian.pembayaran_termin.forEach(terminData => {
            createTerminCard(terminData);
        });
    }

    // 3. Panggil kalkulasi & toggle saat halaman dimuat
    hitungTotal(); // Akan menghitung subtotal & total
    toggleTerminCard(); // Tampilkan/sembunyikan card termin
});
</script>
@endsection