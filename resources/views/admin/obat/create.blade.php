@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title', 'Tambah Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.obat.index') }}">Data Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">medication</i> Master Obat</span>
                    <h2 class="welcome-title">Tambah Obat Baru</h2>
                    <p class="welcome-subtitle">Lengkapi formulir berikut untuk menambahkan obat baru ke dalam sistem apotek.</p>
                </div>
                <a href="{{ route('admin.obat.index') }}" class="stat-pill">
                    <i class="material-symbols-rounded">arrow_back</i><span>Kembali</span>
                </a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">pill</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">vaccines</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Alert Section --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
        <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
        <span class="alert-text fw-bold">Terdapat kesalahan pada inputan:</span>
        <ul class="mb-0 text-sm mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Form Card --}}
<div class="card pro-card">
    <form action="{{ route('admin.obat.store') }}" method="POST" id="formObat">
        @csrf
        
        {{-- Section 1: Informasi Dasar --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon info"><i class="material-symbols-rounded">info</i></div>
                <div><h6 class="section-title">Informasi Dasar</h6><p class="section-subtitle">Data utama identitas obat</p></div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Nama Obat <span class="required">*</span></label>
                            <div class="input-modern"><i class="material-symbols-rounded input-icon">medication</i><input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" placeholder="Masukkan nama obat" required></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Kode Obat</label>
                            <div class="input-modern"><i class="material-symbols-rounded input-icon">tag</i><input type="text" name="kode_obat" class="form-control" value="{{ old('kode_obat') }}" placeholder="Kode unik"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Stok Minimum</label>
                            <div class="input-modern"><i class="material-symbols-rounded input-icon">warning</i><input type="number" name="stok_minimum" class="form-control" value="{{ old('stok_minimum', 10) }}" min="0" placeholder="10"></div>
                            <small class="text-xs text-secondary mt-1 d-block">Batas peringatan stok rendah</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Klasifikasi --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon primary"><i class="material-symbols-rounded">category</i></div>
                <div><h6 class="section-title">Klasifikasi & Lokasi</h6><p class="section-subtitle">Kategori, satuan, dan penempatan obat</p></div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Kategori <span class="required">*</span></label>
                            <div class="input-modern select">
                                <i class="material-symbols-rounded input-icon">folder</i>
                                <select name="kategori_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $k)<option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>@endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Satuan <span class="required">*</span></label>
                            <div class="input-modern select">
                                <i class="material-symbols-rounded input-icon">scale</i>
                                <select name="satuan_obat_id" class="form-control" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    @foreach($satuan as $s)<option value="{{ $s->id }}" {{ old('satuan_obat_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_satuan }}</option>@endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Lokasi Rak</label>
                            <div class="input-modern"><i class="material-symbols-rounded input-icon">location_on</i><input type="text" name="lokasi_rak" class="form-control" value="{{ old('lokasi_rak') }}" maxlength="50" placeholder="Contoh: A-01"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Komposisi --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon success"><i class="material-symbols-rounded">science</i></div>
                <div><h6 class="section-title">Komposisi & Identifikasi</h6><p class="section-subtitle">Kandungan, barcode, dan deskripsi obat</p></div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Kandungan Obat <small class="text-secondary text-lowercase fw-normal">(bisa pilih lebih dari satu)</small></label>
                            <select name="kandungan_id[]" id="kandunganSelect" class="form-control" multiple>
                                @foreach($kandungan as $k)<option value="{{ $k->id }}" {{ (is_array(old('kandungan_id')) && in_array($k->id, old('kandungan_id'))) ? 'selected' : '' }}>{{ $k->nama_kandungan_text }} ({{ $k->dosis_kandungan }})</option>@endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Barcode / QR</label>
                            <div class="input-modern barcode">
                                <i class="material-symbols-rounded input-icon">qr_code</i>
                                <input type="text" name="barcode" id="barcodeInput" class="form-control" value="{{ old('barcode') }}" maxlength="100" placeholder="Scan atau ketik">
                                <button class="btn-scan" type="button" id="btnOpenQr" aria-label="Scan"><i class="material-symbols-rounded">qr_code_scanner</i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Deskripsi</label>
                            <div class="input-modern textarea"><i class="material-symbols-rounded input-icon">description</i><textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi obat, indikasi, atau keterangan">{{ old('deskripsi') }}</textarea></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('admin.obat.index') }}" class="btn-outline-pro"><i class="material-symbols-rounded">arrow_back</i> Kembali</a>
            <button type="submit" class="btn-pro info"><i class="material-symbols-rounded">save</i> Simpan Data Obat</button>
        </div>
    </form>
</div>

{{-- Modal: QR Code Scanner --}}
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content pro-modal info">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="modal-icon"><i class="material-symbols-rounded">qr_code_scanner</i></div>
                    <h5 class="modal-title" id="qrScannerLabel">Pindai QR / Barcode</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="qr-reader" style="width: 100%; border-radius: 12px; overflow: hidden;"></div>
                <div class="scan-info mt-3"><i class="material-symbols-rounded">info</i><span>Izinkan akses kamera dan arahkan ke QR / Barcode yang ingin dipindai.</span></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn-outline-pro" data-bs-dismiss="modal"><i class="material-symbols-rounded">close</i> Tutup</button></div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; transform: translateY(-2px); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.form-section { border-bottom: 1px solid #f1f5f9; }
.form-section:last-of-type { border-bottom: none; }
.section-header { display: flex; align-items: center; gap: 12px; padding: 1.25rem 1.5rem; background: #fafbfc; border-bottom: 1px solid #f1f5f9; }
.section-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.section-icon i { font-size: 20px; color: white; }
.section-icon.info { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.section-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.section-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.section-title { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin: 0; }
.section-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.section-body { padding: 1.5rem; }
.form-group-modern { margin-bottom: 0; }
.form-label-modern { display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.form-label-modern .required { color: var(--danger); }
.input-modern { position: relative; }
.input-modern .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 20px; z-index: 2; }
.input-modern.textarea .input-icon { top: 18px; }
.input-modern .form-control { padding-left: 46px; height: 48px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; transition: all 0.2s; }
.input-modern textarea.form-control { height: auto; padding-top: 12px; }
.input-modern .form-control:focus { border-color: var(--info); box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
.input-modern.select select { appearance: none; cursor: pointer; }
.input-modern.barcode .form-control { padding-right: 50px; }
.btn-scan { position: absolute; right: 4px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; border-radius: 8px; background: var(--info); color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
.btn-scan:hover { background: #1d4ed8; }
.btn-scan i { font-size: 20px; }
.form-actions { display: flex; justify-content: flex-end; gap: 12px; padding: 1.25rem 1.5rem; background: #fafbfc; border-top: 1px solid #f1f5f9; }
.btn-pro { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro.info { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: var(--secondary); font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
.btn-outline-pro i { font-size: 18px; }
.pro-modal { border-radius: 16px; border: none; overflow: hidden; }
.pro-modal .modal-header { background: linear-gradient(135deg, #8b5cf6, #7c3aed); padding: 1.25rem 1.5rem; border: none; }
.pro-modal.info .modal-header { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.pro-modal .modal-title { color: white; font-weight: 600; margin: 0; }
.modal-icon { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; }
.modal-icon i { color: white; font-size: 20px; }
.pro-modal .modal-footer { border-top: 1px solid #f1f5f9; padding: 1rem 1.5rem; }
.pro-modal .btn-close { filter: brightness(0) invert(1); opacity: 0.8; }
.pro-modal .btn-close:hover { opacity: 1; }
.scan-info { display: flex; align-items: center; gap: 8px; padding: 12px 16px; background: rgba(59,130,246,0.1); border-radius: 10px; color: var(--info); font-size: 0.85rem; }
.scan-info i { font-size: 20px; }
/* Select2 Styling */
.select2-container--default .select2-selection--multiple { border: 1px solid #e2e8f0 !important; border-radius: 10px !important; min-height: 48px !important; padding: 6px 10px !important; }
.select2-container--default.select2-container--focus .select2-selection--multiple { border-color: var(--info) !important; box-shadow: 0 0 0 3px rgba(59,130,246,0.15) !important; }
.select2-container--default .select2-selection--multiple .select2-selection__choice { background-color: var(--info) !important; border-color: var(--info) !important; color: #fff !important; padding: 4px 8px !important; border-radius: 6px !important; }
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove { color: #fff !important; margin-right: 4px !important; }
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover { color: rgba(255,255,255,0.7) !important; }
.select2-dropdown { border: 1px solid #e2e8f0 !important; border-radius: 10px !important; }
.select2-container--default .select2-results__option--highlighted[aria-selected] { background-color: var(--info) !important; }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
$(document).ready(function () {
    $('#kandunganSelect').select2({ placeholder: 'Pilih kandungan obat', allowClear: true, width: '100%' });
    let html5QrCode = null;
    const btnOpenQr = document.getElementById('btnOpenQr');
    const barcodeInput = document.getElementById('barcodeInput');
    const qrScannerModalEl = document.getElementById('qrScannerModal');
    const qrScannerModal = new bootstrap.Modal(qrScannerModalEl);
    if (btnOpenQr) {
        btnOpenQr.addEventListener('click', function () {
            qrScannerModal.show();
            setTimeout(() => {
                if (!html5QrCode) html5QrCode = new Html5Qrcode("qr-reader");
                html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: { width: 250, height: 250 } },
                    (decodedText) => { barcodeInput.value = decodedText; html5QrCode.stop().then(() => qrScannerModal.hide()).catch(err => console.error(err)); },
                    () => {}
                ).catch(err => { console.error(err); alert("Tidak dapat memulai scanner."); qrScannerModal.hide(); });
            }, 400);
        });
        qrScannerModalEl.addEventListener('hidden.bs.modal', function () { if (html5QrCode) html5QrCode.stop().catch(err => console.error(err)); });
    }
});
</script>
@endpush
@endsection
