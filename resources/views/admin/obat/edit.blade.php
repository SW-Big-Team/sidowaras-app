@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)

@section('title', 'Edit Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm">
        <a class="opacity-5 text-dark" href="{{ route('admin.obat.index') }}">Manajemen Obat</a>
    </li>
    <li class="breadcrumb-item text-sm">
        <a class="opacity-5 text-dark" href="{{ route('admin.obat.index') }}">Data Obat</a>
    </li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Obat</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <x-content-header 
        title="Edit Data Obat" 
        subtitle="Perbarui informasi obat yang sudah terdaftar di sistem dengan data yang akurat"
    >
        <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary mb-0">
            <i class="material-symbols-rounded text-sm me-1">arrow_back</i> Kembali
        </a>
    </x-content-header>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    {{-- Alert Section --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <div class="d-flex">
                                <span class="alert-icon me-2 mt-1">
                                    <i class="material-symbols-rounded">error</i>
                                </span>
                                <div>
                                    <strong class="d-block mb-1">Terdapat kesalahan pada inputan:</strong>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <span class="alert-icon me-2"><i class="material-symbols-rounded">error</i></span>
                            <span class="alert-text">{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <span class="alert-icon me-2"><i class="material-symbols-rounded">check_circle</i></span>
                            <span class="alert-text">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST" id="formObat">
                        @csrf
                        @method('PUT')

                        {{-- SECTION: Informasi Dasar --}}
                        <div class="border rounded-3 p-3 p-md-4 mb-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded opacity-10">info</i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Informasi Dasar</h6>
                                    <p class="text-sm text-secondary mb-0">
                                        Lengkapi identitas utama obat yang akan digunakan di transaksi dan laporan.
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Nama Obat <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-static">
                                        <input 
                                            type="text"
                                            name="nama_obat"
                                            class="form-control"
                                            value="{{ old('nama_obat', $obat->nama_obat) }}"
                                            placeholder="Masukkan nama obat"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Kode Obat</label>
                                    <div class="input-group input-group-static">
                                        <input 
                                            type="text"
                                            name="kode_obat"
                                            class="form-control"
                                            value="{{ old('kode_obat', $obat->kode_obat) }}"
                                            placeholder="Kode unik obat (opsional)"
                                        >
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Stok Minimum</label>
                                    <div class="input-group input-group-static">
                                        <input 
                                            type="number"
                                            name="stok_minimum"
                                            class="form-control"
                                            value="{{ old('stok_minimum', $obat->stok_minimum) }}"
                                            min="0"
                                            placeholder="Contoh: 10"
                                        >
                                    </div>
                                    <small class="text-xs text-secondary">
                                        Sistem dapat memberi tanda peringatan jika stok berada di bawah nilai ini.
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: Klasifikasi --}}
                        <div class="border rounded-3 p-3 p-md-4 mb-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded opacity-10">category</i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Klasifikasi</h6>
                                    <p class="text-sm text-secondary mb-0">
                                        Atur kategori, satuan, dan lokasi rak untuk memudahkan pencarian dan pelaporan.
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Kategori <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-static">
                                        <select name="kategori_id" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategori as $k)
                                                <option value="{{ $k->id }}" 
                                                    {{ old('kategori_id', $obat->kategori_id) == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Satuan <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-static">
                                        <select name="satuan_obat_id" class="form-control" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            @foreach($satuan as $s)
                                                <option value="{{ $s->id }}" 
                                                    {{ old('satuan_obat_id', $obat->satuan_obat_id) == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nama_satuan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Lokasi Rak</label>
                                    <div class="input-group input-group-static">
                                        <input 
                                            type="text"
                                            name="lokasi_rak"
                                            class="form-control"
                                            value="{{ old('lokasi_rak', $obat->lokasi_rak) }}"
                                            maxlength="50"
                                            placeholder="Contoh: A-01, Rak B"
                                        >
                                    </div>
                                    <small class="text-xs text-secondary">
                                        Membantu petugas menemukan obat dengan lebih cepat di apotek.
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: Komposisi & Identifikasi --}}
                        <div class="border rounded-3 p-3 p-md-4 mb-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                    <i class="material-symbols-rounded opacity-10">science</i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Komposisi & Identifikasi</h6>
                                    <p class="text-sm text-secondary mb-0">
                                        Atur kandungan obat, barcode, serta deskripsi untuk informasi yang lebih lengkap.
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label small">
                                        Kandungan Obat 
                                        <small class="text-muted">(bisa pilih lebih dari satu)</small>
                                    </label>
                                    <div class="input-group input-group-static">
                                        <select 
                                            name="kandungan_id[]" 
                                            id="kandunganSelectEdit" 
                                            class="form-control" 
                                            multiple
                                        >
                                            @php
                                                $selectedKandungan = is_array($obat->kandungan_id)
                                                    ? $obat->kandungan_id
                                                    : json_decode($obat->kandungan_id, true);
                                            @endphp
                                            @foreach($kandungan as $k)
                                                <option value="{{ $k->id }}" 
                                                    {{ in_array($k->id, old('kandungan_id', $selectedKandungan ?? [])) ? 'selected' : '' }}>
                                                    {{ $k->nama_kandungan_text }} ({{ $k->dosis_kandungan }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="text-xs text-secondary">
                                        Ketik untuk mencari kandungan, lalu pilih satu atau lebih sesuai komposisi obat.
                                    </small>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Barcode / QR</label>
                                    <div class="input-group">
                                        <input 
                                            type="text"
                                            name="barcode"
                                            id="barcodeInput"
                                            class="form-control"
                                            value="{{ old('barcode', $obat->barcode) }}"
                                            maxlength="100"
                                            placeholder="Scan atau ketik barcode"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary mb-0" 
                                            type="button" 
                                            id="btnOpenQr"
                                            aria-label="Buka pemindai barcode"
                                        >
                                            <i class="material-symbols-rounded">qr_code_scanner</i>
                                        </button>
                                    </div>
                                    <small class="text-xs text-secondary">
                                        Klik ikon untuk membuka pemindai menggunakan kamera perangkat.
                                    </small>
                                </div>

                                <div class="col-12 mb-2">
                                    <label class="form-label small">Deskripsi</label>
                                    <div class="input-group input-group-static">
                                        <textarea 
                                            name="deskripsi"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Masukkan deskripsi obat, indikasi, atau keterangan tambahan"
                                        >{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="pt-2">
                            <hr class="horizontal dark my-4">
                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                                <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary mb-0">
                                    <i class="material-symbols-rounded text-sm me-1">close</i> Batal
                                </a>
                                <button type="submit" class="btn bg-gradient-primary mb-0">
                                    <i class="material-symbols-rounded text-sm me-1">save</i> Simpan Perubahan
                                </button>
                            </div>
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
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white d-flex align-items-center" id="qrScannerLabel">
                    <i class="material-symbols-rounded me-2">qr_code_scanner</i>
                    Pindai QR / Barcode
                </h5>
                <button 
                    type="button" 
                    class="btn-close btn-close-white" 
                    data-bs-dismiss="modal" 
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div 
                    id="qr-reader" 
                    style="width: 100%; border-radius: 0.75rem; overflow: hidden;"
                ></div>
                <div class="alert alert-info mt-3 mb-0 d-flex align-items-center">
                    <i class="material-symbols-rounded me-2">info</i>
                    <span class="text-sm">
                        Izinkan akses kamera dan arahkan ke QR / Barcode yang ingin dipindai.
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <button 
                    type="button" 
                    class="btn btn-outline-secondary mb-0" 
                    data-bs-dismiss="modal"
                >
                    <i class="material-symbols-rounded me-1">close</i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .form-label.small { 
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .card-header { 
        padding-left: .75rem; 
        padding-right: .75rem; 
    }

    #qr-reader__dashboard { 
        padding: 0 !important; 
    }

    #qr-reader__scan_region video { 
        width: 100% !important; 
        height: auto !important; 
    }

    .btn-close { 
        box-shadow: none; 
    }

    .gap-2 {
        gap: .5rem !important;
    }

    /* Select2 Styling (selaras dengan warna primary tema) */
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

    @media (max-width: 576px) {
        .modal-lg { 
            max-width: 95%; 
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
$(document).ready(function () {
    // Initialize Select2 untuk kandungan obat
    $('#kandunganSelectEdit').select2({
        placeholder: 'Pilih kandungan obat (bisa lebih dari satu)',
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
