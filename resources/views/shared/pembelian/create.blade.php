@php
    $role = Auth::user()->role->nama_role;
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Tambah Pembelian')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('pembelian.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Pembelian</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">add_shopping_cart</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Tambah Pembelian</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Input data pembelian obat baru dari supplier.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <a href="{{ route('pembelian.index') }}" class="btn bg-white mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                <i class="material-symbols-rounded align-middle">arrow_back</i>
                                <span>Kembali</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
            <span class="alert-text"><strong>Error!</strong>
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

        {{-- Informasi Pembelian --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white pb-0">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="material-symbols-rounded text-primary">receipt_long</i>
                    Informasi Pembelian
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">No Faktur</label>
                        <input type="text" name="no_faktur" class="form-control form-control-sm" value="{{ old('no_faktur') }}" placeholder="Auto">
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Tanggal <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="tgl_pembelian" class="form-control form-control-sm" value="{{ old('tgl_pembelian', now()->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select form-select-sm" required>
                            <option value="tunai" @selected(old('metode_pembayaran', 'tunai') === 'tunai')>Tunai</option>
                            <option value="non tunai" @selected(old('metode_pembayaran') === 'non tunai')>Non Tunai</option>
                            <option value="termin" @selected(old('metode_pembayaran') === 'termin')>Termin</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Total Harga</label>
                        <input type="text" id="total_harga_display" class="form-control form-control-sm bg-light fw-bold text-success" value="Rp 0" readonly>
                        <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', 0) }}">
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6 col-12">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Nama Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pengirim" class="form-control form-control-sm" value="{{ old('nama_pengirim') }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">No Telepon Pengirim</label>
                        <input type="text" name="no_telepon_pengirim" class="form-control form-control-sm" value="{{ old('no_telepon_pengirim') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Obat --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="material-symbols-rounded text-success">medication</i>
                    Detail Obat
                </h6>
                <button type="button" class="btn btn-sm bg-gradient-dark mb-0 d-flex align-items-center gap-1" id="btnTambahObat">
                    <i class="material-symbols-rounded text-sm">add</i> Tambah Obat
                </button>
            </div>
            <div class="card-body">
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
       
        {{-- Detail Termin --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4" id="cardTermin" style="display: none;">
            <div class="card-header bg-white pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="material-symbols-rounded text-warning">calendar_month</i>
                    Detail Termin Pembayaran
                </h6>
                <button type="button" class="btn btn-sm bg-gradient-dark mb-0 d-flex align-items-center gap-1" id="btnTambahTermin">
                    <i class="material-symbols-rounded text-sm">add</i> Tambah Termin
                </button>
            </div>
            <div class="card-body">
                <div id="containerTermin">
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

        <div class="text-end mb-4">
            <button type="submit" class="btn bg-gradient-primary btn-lg mb-0 shadow-lg d-inline-flex align-items-center gap-2">
                <i class="material-symbols-rounded">save</i> Simpan Pembelian
            </button>
        </div>
    </form>
</div>

<style>
    .obat-card { transition: all 0.3s ease; }
    .obat-card .card { height: 100%; border: 1px solid #e9ecef !important; box-shadow: none !important; }
    .obat-card:hover .card { box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05) !important; border-color: #dee2e6 !important; }
    .obat-card .card-header { background: #f8f9fa; padding: 0.75rem 1rem; border-bottom: 1px solid #e9ecef; }
    .termin-row { transition: all 0.3s ease; border-bottom: 1px dashed #e9ecef; padding-bottom: 1rem; margin-bottom: 1rem; }
    .termin-row:last-child { border-bottom: 0; padding-bottom: 0; margin-bottom: 0; }
</style>

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
         if (initialValue && parseInt(initialValue) > 0) {
            let numericValue = parseInt(initialValue);
            displayInput.value = 'Rp ' + numericValue.toLocaleString('id-ID');
        }
    }

    function formatRupiah(angka) {
        return 'Rp ' + (Number(angka) || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    function createObatCard(data = {}) {
        // ... (Fungsi createObatCard SAMA SEPERTI SEBELUMNYA, tidak ada perubahan) ...
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
                            <input type="date" name="obat[${index}][tgl_kadaluarsa]" class="form-control form-control-sm" value="${data.tgl_kadaluarsa || ''}" required>
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

    // ... (removeObatCard, updateObatNumbers, hitungTotal SAMA SEPERTI SEBELUMNYA) ...
    window.removeObatCard = function(btn) {
        const obatCard = btn.closest('.obat-card');
        if (containerObat.querySelectorAll('.obat-card').length > 1) {
            obatCard.remove();
            hitungTotal();
            updateObatNumbers();
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

    // --- PERUBAHAN FUNGSI TERMIN DI SINI ---
    function createTerminCard(data = {}) {
        const index = terminCounter++;
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-center termin-row';
        row.setAttribute('data-index', index);
        
        const tglJatuhTempo = data.tgl_jatuh_tempo ? data.tgl_jatuh_tempo.split('T')[0] : '';

        // HANYA INPUT TANGGAL, TANPA JUMLAH BAYAR
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
            // Auto add 1 row if empty
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
            // TIDAK ADA validasi jumlah bayar lagi
        }
        return true;
    }

    btnTambahObat.addEventListener('click', function() { createObatCard(); });
    metodePembayaranSelect.addEventListener('change', toggleTerminCard);
    btnTambahTermin.addEventListener('click', function() { createTerminCard(); });
    formPembelian.addEventListener('submit', validasiForm);

    if (window.oldObat && window.oldObat.length > 0) {
        window.oldObat.forEach(obatData => createObatCard(obatData));
    } else { createObatCard(); }
    
     if (window.oldTermin && window.oldTermin.length > 0) {
        window.oldTermin.forEach(terminData => createTerminCard(terminData));
    }
    hitungTotal();
    toggleTerminCard();
});
</script>
@endsection