@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Edit Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('pembelian.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Pembelian</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">edit_note</i> Edit Pembelian</span>
                    <h2 class="welcome-title">{{ $pembelian->no_faktur }}</h2>
                    <p class="welcome-subtitle">Perbarui data pembelian dan detail item obat.</p>
                </div>
                <a href="{{ route('pembelian.index') }}" class="stat-pill"><i class="material-symbols-rounded">arrow_back</i><span>Kembali</span></a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">edit</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">inventory</i></div>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
        <span class="alert-text"><strong>Error!</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

<form action="{{ route('pembelian.update', $pembelian->uuid) }}" method="POST" id="formPembelian">
    @csrf
    @method('PUT')

    {{-- Section 1: Informasi Pembelian --}}
    <div class="card pro-card mb-4">
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon warning"><i class="material-symbols-rounded">receipt_long</i></div>
                <div><h6 class="section-title">Informasi Pembelian</h6><p class="section-subtitle">Data faktur dan supplier</p></div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="form-group-modern"><label class="form-label-modern">No Faktur</label>
                        <div class="input-modern"><i class="material-symbols-rounded input-icon">tag</i><input type="text" name="no_faktur" class="form-control" value="{{ old('no_faktur', $pembelian->no_faktur) }}" placeholder="Auto"></div></div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group-modern"><label class="form-label-modern">Tanggal <span class="required">*</span></label>
                        <div class="input-modern"><i class="material-symbols-rounded input-icon">calendar_today</i><input type="datetime-local" name="tgl_pembelian" class="form-control" value="{{ old('tgl_pembelian', $pembelian->tgl_pembelian->format('Y-m-d\TH:i')) }}" required></div></div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group-modern"><label class="form-label-modern">Pembayaran <span class="required">*</span></label>
                        <div class="input-modern select"><i class="material-symbols-rounded input-icon">payments</i>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                            <option value="tunai" @selected(old('metode_pembayaran', $pembelian->metode_pembayaran) === 'tunai')>Tunai</option>
                            <option value="non tunai" @selected(old('metode_pembayaran', $pembelian->metode_pembayaran) === 'non tunai')>Non Tunai</option>
                            <option value="termin" @selected(old('metode_pembayaran', $pembelian->metode_pembayaran) === 'termin')>Termin</option>
                        </select></div></div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group-modern"><label class="form-label-modern">Total Harga</label>
                        <div class="input-modern"><i class="material-symbols-rounded input-icon">attach_money</i><input type="text" id="total_harga_display" class="form-control total-field" value="Rp 0" readonly><input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', $pembelian->total_harga) }}"></div></div>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6 col-12">
                        <div class="form-group-modern"><label class="form-label-modern">Nama Pengirim <span class="required">*</span></label>
                        <div class="input-modern"><i class="material-symbols-rounded input-icon">local_shipping</i><input type="text" name="nama_pengirim" class="form-control" value="{{ old('nama_pengirim', $pembelian->nama_pengirim) }}" required></div></div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group-modern"><label class="form-label-modern">No Telepon Pengirim</label>
                        <div class="input-modern"><i class="material-symbols-rounded input-icon">phone</i><input type="text" name="no_telepon_pengirim" class="form-control" value="{{ old('no_telepon_pengirim', $pembelian->no_telepon_pengirim) }}"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 2: Detail Obat --}}
    <div class="card pro-card mb-4">
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon success"><i class="material-symbols-rounded">medication</i></div>
                <div><h6 class="section-title">Detail Obat</h6><p class="section-subtitle">Item obat yang dibeli</p></div>
                <button type="button" class="btn-pro" id="btnTambahObat"><i class="material-symbols-rounded">add</i> Tambah Obat</button>
            </div>
            <div class="section-body">
                <div class="row g-3" id="containerObat"></div>
            </div>
        </div>
    </div>
    
    {{-- Section 3: Detail Termin --}}
    <div class="card pro-card mb-4" id="cardTermin" style="display: none;">
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon primary"><i class="material-symbols-rounded">calendar_month</i></div>
                <div><h6 class="section-title">Detail Termin Pembayaran</h6><p class="section-subtitle">Jadwal cicilan</p></div>
                <button type="button" class="btn-pro primary" id="btnTambahTermin"><i class="material-symbols-rounded">add</i> Tambah Termin</button>
            </div>
            <div class="section-body">
                <div id="containerTermin"></div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('pembelian.index') }}" class="btn-outline-pro"><i class="material-symbols-rounded">close</i> Batal</a>
        <button type="submit" class="btn-pro warning"><i class="material-symbols-rounded">save</i> Simpan Perubahan</button>
    </div>
</form>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.form-section { border-bottom: 1px solid #f1f5f9; }
.form-section:last-of-type { border-bottom: none; }
.section-header { display: flex; align-items: center; gap: 12px; padding: 1.25rem 1.5rem; background: #fafbfc; border-bottom: 1px solid #f1f5f9; }
.section-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.section-icon i { font-size: 20px; color: white; }
.section-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.section-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.section-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.section-title { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin: 0; }
.section-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.section-header .btn-pro { margin-left: auto; }
.section-body { padding: 1.5rem; }
.form-group-modern { margin-bottom: 0; }
.form-label-modern { display: block; font-size: 0.7rem; font-weight: 600; color: #475569; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
.form-label-modern .required { color: var(--danger); }
.input-modern { position: relative; }
.input-modern .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 18px; z-index: 2; }
.input-modern .form-control { padding-left: 42px; height: 44px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.875rem; transition: all 0.2s; }
.input-modern .form-control:focus { border-color: var(--warning); box-shadow: 0 0 0 3px rgba(245,158,11,0.15); }
.input-modern.select select { appearance: none; cursor: pointer; }
.total-field { background: #f8fafc !important; color: var(--success) !important; font-weight: 700 !important; }
.btn-pro { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: linear-gradient(135deg, #1e293b, #334155); color: white; font-size: 0.8rem; font-weight: 500; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.btn-pro.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: white; color: var(--secondary); font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
.form-actions { display: flex; justify-content: flex-end; gap: 12px; padding: 1.5rem 0; }
.obat-card { transition: all 0.3s ease; }
.obat-card .card { height: 100%; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: none !important; }
.obat-card:hover .card { border-color: var(--warning) !important; box-shadow: 0 4px 12px rgba(245,158,11,0.1) !important; }
.obat-card .card-header { background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 0.75rem 1rem; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0 !important; }
.termin-row { transition: all 0.3s ease; border-bottom: 1px dashed #e2e8f0; padding-bottom: 1rem; margin-bottom: 1rem; }
.termin-row:last-child { border-bottom: 0; padding-bottom: 0; margin-bottom: 0; }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } .section-header { flex-wrap: wrap; } .section-header .btn-pro { margin-left: 52px; margin-top: 8px; } }
</style>
@endpush

<script>
document.addEventListener('DOMContentLoaded', function() {
    const containerObat = document.getElementById('containerObat');
    const btnTambahObat = document.getElementById('btnTambahObat');
    const totalHargaInput = document.getElementById('total_harga');
    const totalHargaDisplay = document.getElementById('total_harga_display');
    const formPembelian = document.getElementById('formPembelian');
    let obatCounter = 0;
    let terminCounter = 0;
    const obatList = @json($obatList);
    const metodePembayaranSelect = document.getElementById('metode_pembayaran');
    const cardTermin = document.getElementById('cardTermin');
    const containerTermin = document.getElementById('containerTermin');
    const btnTambahTermin = document.getElementById('btnTambahTermin');

    function formatInputRupiah(displayInput, hiddenInput, callbackOnInput = null) {
        displayInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            let numericValue = parseInt(value) || 0;
            hiddenInput.value = numericValue;
            if (value === '') { e.target.value = ''; } 
            else { e.target.value = 'Rp ' + numericValue.toLocaleString('id-ID'); }
            if (callbackOnInput) { callbackOnInput(); }
        });
        let initialValue = hiddenInput.value;
        if (initialValue && parseFloat(initialValue) > 0) {
            let numericValue = parseFloat(initialValue);
            displayInput.value = 'Rp ' + numericValue.toLocaleString('id-ID');
        }
    }

    function formatRupiah(angka) {
        return 'Rp ' + (Number(angka) || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

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
            <div class="card rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="badge bg-gradient-dark badge-number">Obat #${index + 1}</span>
                    <button type="button" class="btn btn-link text-danger mb-0 p-0 btn-remove" onclick="removeObatCard(this)">
                        <i class="material-symbols-rounded">delete</i>
                    </button>
                </div>
                <div class="card-body p-3">
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Pilih Obat <span class="text-danger">*</span></label>
                        <select name="obat[${index}][obat_id]" class="form-select form-select-sm" required>${optionsHtml}</select>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Harga Beli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm harga-beli-display" required placeholder="Rp 0">
                            <input type="hidden" name="obat[${index}][harga_beli]" class="harga-beli" value="${data.harga_beli || 0}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Harga Jual <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm harga-jual-display" required placeholder="Rp 0">
                            <input type="hidden" name="obat[${index}][harga_jual]" class="harga-jual" value="${data.harga_jual || 0}">
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="obat[${index}][jumlah_masuk]" class="form-control form-control-sm jumlah-masuk" required min="1" value="${data.jumlah_masuk || 1}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Kadaluarsa <span class="text-danger">*</span></label>
                            <input type="date" name="obat[${index}][tgl_kadaluarsa]" class="form-control form-control-sm" value="${data.tgl_kadaluarsa ? data.tgl_kadaluarsa.split('T')[0] : ''}" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Subtotal</label>
                        <input type="text" class="form-control form-control-sm subtotal bg-light fw-bold text-success" readonly value="Rp 0">
                    </div>
                </div>
            </div>`;
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
            obatCard.remove(); hitungTotal(); updateObatNumbers();
        } else { alert('Minimal harus ada 1 obat dalam pembelian!'); }
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

    function createTerminCard(data = {}) {
        const index = terminCounter++;
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-center termin-row';
        row.setAttribute('data-index', index);
        const tglJatuhTempo = data.tgl_jatuh_tempo ? data.tgl_jatuh_tempo.split('T')[0] : '';
        row.innerHTML = `
            <div class="col-1"><span class="badge bg-secondary badge-number">#${index + 1}</span></div>
            <div class="col-10">
                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tgl. Jatuh Tempo <span class="text-danger">*</span></label>
                <input type="date" name="termin_list[${index}][tgl_jatuh_tempo]" class="form-control form-control-sm" value="${tglJatuhTempo}" required>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-link text-danger mb-0 p-0 btn-remove-termin"><i class="material-symbols-rounded">close</i></button>
            </div>`;
        containerTermin.appendChild(row);
        row.querySelector('.btn-remove-termin').addEventListener('click', function() { removeTerminCard(this); });
    }

    function removeTerminCard(btn) { btn.closest('.termin-row').remove(); updateTerminNumbers(); }
    function updateTerminNumbers() { containerTermin.querySelectorAll('.termin-row').forEach((row, idx) => { row.querySelector('.badge-number').textContent = `#${idx + 1}`; }); }

    function toggleTerminCard() {
        if (metodePembayaranSelect.value === 'termin') {
            cardTermin.style.display = 'block';
            if (containerTermin.querySelectorAll('.termin-row').length === 0 && !window.oldTermin) { createTerminCard(); }
        } else { cardTermin.style.display = 'none'; }
    }

    function validasiForm(e) {
        if (metodePembayaranSelect.value === 'termin') {
            if (containerTermin.querySelectorAll('.termin-row').length === 0) {
                e.preventDefault(); 
                alert('Validasi Gagal!\nAnda memilih metode TERMIN, tapi belum menambahkan baris termin.');
                cardTermin.scrollIntoView({ behavior: 'smooth' });
                return false;
            }
        }
        return true;
    }

    btnTambahObat.addEventListener('click', function() { createObatCard(); });
    metodePembayaranSelect.addEventListener('change', toggleTerminCard);
    btnTambahTermin.addEventListener('click', function() { createTerminCard(); });
    formPembelian.addEventListener('submit', validasiForm);

    const pembelian = @json($pembelian);
    if (pembelian.stok_batches && pembelian.stok_batches.length > 0) {
        pembelian.stok_batches.forEach(batchData => { createObatCard(batchData); });
    } else { createObatCard(); }
    
    if (pembelian.pembayaran_termin && pembelian.pembayaran_termin.length > 0) {
        pembelian.pembayaran_termin.forEach(terminData => { createTerminCard(terminData); });
    }
    hitungTotal();
    toggleTerminCard();
});
</script>
@endsection