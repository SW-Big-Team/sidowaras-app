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
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-header bg-gradient-dark p-4 rounded-top-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                            <i class="material-symbols-rounded text-dark">medication</i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white fw-bold">Tambah Obat Baru</h5>
                            <p class="text-sm text-white opacity-8 mb-0">Lengkapi formulir untuk menambahkan obat baru ke dalam sistem</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    {{-- Alert Section --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
                            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
                            <span class="alert-text fw-bold">Terdapat kesalahan pada inputan:</span>
                            <ul class="mb-0 text-sm mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.obat.store') }}" method="POST" id="formObat">
                        @csrf

                        {{-- SECTION: Informasi Dasar --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 mb-3">Informasi Dasar</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Nama Obat <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" placeholder="Masukkan nama obat" required>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Kode Obat</label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" name="kode_obat" class="form-control" value="{{ old('kode_obat') }}" placeholder="Kode unik (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Stok Minimum</label>
                                    <div class="input-group input-group-outline">
                                        <input type="number" name="stok_minimum" class="form-control" value="{{ old('stok_minimum', 10) }}" min="0" placeholder="Contoh: 10">
                                    </div>
                                    <small class="text-xs text-muted mt-1 d-block">Batas untuk peringatan stok rendah</small>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: Klasifikasi --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 mb-3">Klasifikasi & Lokasi</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Kategori <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <select name="kategori_id" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategori as $k)
                                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Satuan <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <select name="satuan_obat_id" class="form-control" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            @foreach($satuan as $s)
                                                <option value="{{ $s->id }}" {{ old('satuan_obat_id') == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nama_satuan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Lokasi Rak</label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" name="lokasi_rak" class="form-control" value="{{ old('lokasi_rak') }}" maxlength="50" placeholder="Contoh: A-01, Rak B">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: Komposisi & Identifikasi --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 mb-3">Komposisi & Identifikasi</h6>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">
                                        Kandungan Obat <small class="text-muted text-lowercase fw-normal">(bisa pilih lebih dari satu)</small>
                                    </label>
                                    <div class="input-group input-group-outline">
                                        <select name="kandungan_id[]" id="kandunganSelect" class="form-control" multiple>
                                            @foreach($kandungan as $k)
                                                <option value="{{ $k->id }}" {{ (is_array(old('kandungan_id')) && in_array($k->id, old('kandungan_id'))) ? 'selected' : '' }}>
                                                    {{ $k->nama_kandungan_text }} ({{ $k->dosis_kandungan }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Barcode / QR</label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" name="barcode" id="barcodeInput" class="form-control" value="{{ old('barcode') }}" maxlength="100" placeholder="Scan atau ketik barcode">
                                        <button class="btn btn-outline-secondary mb-0" type="button" id="btnOpenQr" aria-label="Buka pemindai barcode">
                                            <i class="material-symbols-rounded">qr_code_scanner</i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12 mb-2">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Deskripsi</label>
                                    <div class="input-group input-group-outline">
                                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi obat, indikasi, atau keterangan tambahan">{{ old('deskripsi') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">arrow_back</i> Kembali
                            </a>
                            <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">save</i> Simpan Data Obat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: QR Code Scanner --}}
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title text-white d-flex align-items-center" id="qrScannerLabel">
                    <i class="material-symbols-rounded me-2">qr_code_scanner</i>
                    Pindai QR / Barcode
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="qr-reader" style="width: 100%; border-radius: 0.75rem; overflow: hidden;"></div>
                <div class="alert alert-info mt-3 mb-0 d-flex align-items-center text-white" role="alert">
                    <i class="material-symbols-rounded me-2">info</i>
                    <span class="text-sm">Izinkan akses kamera dan arahkan ke QR / Barcode yang ingin dipindai.</span>
                </div>
            </div>
            <div class="modal-footer border-top p-3">
                <button type="button" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1" data-bs-dismiss="modal">
                    <i class="material-symbols-rounded text-sm">close</i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .text-xxs { font-size: 0.65rem !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
    
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .input-group-outline {
        display: flex;
        width: 100%;
    }

    /* Select2 Styling */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #d2d6da !important;
        border-radius: .375rem !important;
        min-height: 42px !important;
        padding: .25rem .5rem !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #e91e63 !important;
        box-shadow: 0 0 0 1px rgba(233, 30, 99, 0.1);
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e91e63 !important;
        border-color: #e91e63 !important;
        color: #fff !important;
        padding: .25rem .5rem !important;
        border-radius: .25rem !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff !important;
        margin-right: .25rem !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #ffddeb !important;
    }

    .select2-dropdown {
        border: 1px solid #d2d6da !important;
        border-radius: .375rem !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #e91e63 !important;
    }

    #qr-reader__dashboard { padding: 0 !important; }
    #qr-reader__scan_region video { width: 100% !important; height: auto !important; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
$(document).ready(function () {
    // Initialize Select2
    $('#kandunganSelect').select2({
        placeholder: 'Pilih kandungan obat',
        allowClear: true,
        width: '100%'
    });

    // QR Scanner
    let html5QrCode = null;
    const btnOpenQr = document.getElementById('btnOpenQr');
    const barcodeInput = document.getElementById('barcodeInput');
    const qrScannerModalEl = document.getElementById('qrScannerModal');
    const qrScannerModal = new bootstrap.Modal(qrScannerModalEl);

    if (btnOpenQr) {
        btnOpenQr.addEventListener('click', function () {
            qrScannerModal.show();

            setTimeout(() => {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("qr-reader");
                }

                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    (decodedText) => {
                        barcodeInput.value = decodedText;
                        html5QrCode.stop().then(() => {
                            qrScannerModal.hide();
                        }).catch((err) => {
                            console.error("Error stopping QR scanner:", err);
                        });
                    },
                    () => {
                        // error scanning, diamkan saja
                    }
                ).catch((err) => {
                    console.error("Unable to start QR scanner:", err);
                    alert("Tidak dapat memulai scanner. Pastikan Anda memberikan izin kamera.");
                    qrScannerModal.hide();
                });
            }, 400);
        });

        qrScannerModalEl.addEventListener('hidden.bs.modal', function () {
            if (html5QrCode) {
                html5QrCode.stop().catch((err) => {
                    console.error("Error stopping QR scanner on modal close:", err);
                });
            }
        });
    }
});
</script>
@endpush
@endsection
