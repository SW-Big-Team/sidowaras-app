@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

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
                        {{-- MODIFIKASI: Tambah event listener dan opsi 'termin' --}}
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select form-select-sm" required>
                            <option value="tunai" @selected(old('metode_pembayaran', 'tunai') === 'tunai')>Tunai</option>
                            <option value="non tunai" @selected(old('metode_pembayaran') === 'non tunai')>Non Tunai</option>
                            <option value="termin" @selected(old('metode_pembayaran') === 'termin')>Termin</option>
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

        <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2">
                <h6 class="mb-0"><i class="fas fa-pills"></i> Detail Obat</h6>
                <button type="button" class="btn btn-sm btn-light" id="btnTambahObat">
                    <i class="fas fa-plus"></i> Tambah Obat
                </button>
            </div>
            <div class="card-body p-3">
                <div class="row g-3" id="containerObat">
                    @if(old('obat'))
                        {{-- BARU: Handle old input for obat --}}
                        @foreach(old('obat') as $i => $obat)
                            <script>
                                // We'll store this to add after DOM load
                                window.oldObat = window.oldObat || [];
                                window.oldObat.push(@json($obat));
                            </script>
                        @endforeach
                    @endif
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
                    @if(old('termin_list'))
                        {{-- BARU: Handle old input for termin --}}
                        @foreach(old('termin_list') as $i => $termin)
                            <script>
                                // We'll store this to add after DOM load
                                window.oldTermin = window.oldTermin || [];
                                window.oldTermin.push(@json($termin));
                            </script>
                        @endforeach
                    @endif
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
                <i class="fas fa-save"></i> Simpan Pembelian
            </button>
        </div>
    </form>
</div>

<style>
    /* ... (Style Anda yang sudah ada) ... */
    .termin-row {
        transition: all 0.3s ease;
        border-bottom: 1px dashed #ccc;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    .termin-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
        margin-bottom: 0;
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
                            <input type="hidden" name="obat[${index}][harga_beli]" class="harga-beli" value="${data.harga_beli || 0}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Harga Jual <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm harga-jual-display" required placeholder="Rp 0">
                            <input type="hidden" name="obat[${index}][harga_jual]" class="harga-jual" value="${data.harga_jual || 0}">
                        </div>
                    </div>
                    
                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <label class="form-label small mb-1">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="obat[${index}][jumlah_masuk]" class="form-control form-control-sm jumlah-masuk" required min="1" value="${data.jumlah_masuk || 1}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1">Kadaluarsa <span class="text-danger">*</span></label>
                            <input type="date" name="obat[${index}][tgl_kadaluarsa]" class="form-control form-control-sm" value="${data.tgl_kadaluarsa || ''}" required>
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
        
        totalHargaInput.value = total.toFixed(2);
        totalHargaDisplay.value = formatRupiah(total);

        hitungTotalTermin();
    };

    // --- BARU: FUNGSI TERMIN ---

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
                <input type="date" name="termin_list[${index}][tgl_jatuh_tempo]" class="form-control form-control-sm" value="${data.tgl_jatuh_tempo || ''}" required>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-termin" style="padding: 0.15rem 0.4rem;">
                    &times;
                </button>
            </div>
        `;
        
        containerTermin.appendChild(row);
        
        // Add listeners for new row
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
            if (containerTermin.querySelectorAll('.termin-row').length === 0) {
                 createTerminCard();
            }
        } else {
            cardTermin.style.display = 'none';
        }
    }

    function validasiForm(e) {
        if (metodePembayaranSelect.value === 'termin') {
            const totalPembelian = parseFloat(totalHargaInput.value) || 0;
            const totalAlokasi = hitungTotalTermin();
            
            if (Math.abs(totalPembelian - totalAlokasi) > 0.01) {
                e.preventDefault(); 
                alert('Validasi Gagal!\nTotal alokasi termin ( ' + formatRupiah(totalAlokasi) + ' ) tidak sama dengan Total Harga Pembelian ( ' + formatRupiah(totalPembelian) + ' ).\nPastikan Sisa Alokasi adalah Rp 0.');
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



    if (window.oldObat && window.oldObat.length > 0) {
        window.oldObat.forEach(obatData => createObatCard(obatData));
    } else {
        createObatCard();
    }
   
     if (window.oldTermin && window.oldTermin.length > 0) {
        window.oldTermin.forEach(terminData => createTerminCard(terminData));
    }

    hitungTotal();
    toggleTerminCard(); 
});
</script>
@endsection