@extends('layouts.kasir.app')

@section('title', 'Detail Transaksi #' . $transaksi->no_transaksi)

@section('content')
<div class="container-fluid py-4">
    {{-- Navigation Breadcrumb / Back Button --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('kasir.transaksi.riwayat') }}" class="btn btn-outline-secondary btn-sm mb-0">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Riwayat
            </a>
            <div class="d-flex gap-2">
                <button type="button" onclick="printStruk()" class="btn btn-white btn-sm mb-0 text-dark border">
                    <i class="fas fa-print me-2"></i> Cetak Struk
                </button>
                <button class="btn btn-dark btn-sm mb-0 bg-gradient-dark">
                    <i class="fas fa-file-pdf me-2"></i> Download PDF
                </button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg" id="print-area">
                {{-- HEADER SECTION --}}
                <div class="card-header bg-white p-4 border-bottom">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <h5 class="font-weight-bolder text-dark mb-0">Invoice Transaksi</h5>
                            <p class="text-sm text-muted mb-0">Sidowaras Pharmacy</p>
                        </div>
                        <div class="col-md-6 text-md-end text-start mt-3 mt-md-0">
                            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 mb-1">No. Transaksi</h6>
                            <h5 class="text-primary text-gradient font-weight-bold mb-0">{{ $transaksi->no_transaksi }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- INFO GRID --}}
                    <div class="row mb-5">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center p-3 border-radius-lg bg-gray-100">
                                <div class="icon icon-shape icon-sm bg-white shadow text-center border-radius-md">
                                    <i class="ni ni-calendar-grid-58 text-dark opacity-10"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="text-xs font-weight-bold text-secondary mb-0 text-uppercase">Tanggal & Waktu</p>
                                    <h6 class="text-sm font-weight-bolder text-dark mb-0">
                                        {{ $transaksi->tgl_transaksi->format('d M Y') }}
                                        <span class="text-muted ms-1 font-weight-normal">{{ $transaksi->tgl_transaksi->format('H:i') }}</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center p-3 border-radius-lg bg-gray-100">
                                <div class="icon icon-shape icon-sm bg-white shadow text-center border-radius-md">
                                    <i class="ni ni-circle-08 text-dark opacity-10"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="text-xs font-weight-bold text-secondary mb-0 text-uppercase">Kasir Bertugas</p>
                                    <h6 class="text-sm font-weight-bolder text-dark mb-0">{{ $transaksi->user->nama_lengkap }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center p-3 border-radius-lg bg-gray-100">
                                <div class="icon icon-shape icon-sm bg-white shadow text-center border-radius-md">
                                    <i class="ni ni-check-bold text-success opacity-10"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="text-xs font-weight-bold text-secondary mb-0 text-uppercase">Status</p>
                                    <span class="badge badge-sm bg-gradient-success">Lunas / Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Item Obat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Batch</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Qty</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Harga Satuan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->batch->obat->nama_obat }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $item->batch->obat->kategori ?? 'Umum' }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold bg-light px-2 py-1 rounded border">
                                                {{ $item->batch->no_batch }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-dark text-sm font-weight-bold">{{ $item->jumlah }}</span>
                                        </td>
                                        <td class="align-middle text-end">
                                            <span class="text-secondary text-sm">Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle text-end pe-4">
                                            <span class="text-dark text-sm font-weight-bold">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="horizontal dark my-4">

                    {{-- SUMMARY FOOTER --}}
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary text-sm">Subtotal Item</span>
                                <span class="text-dark font-weight-bold text-sm">{{ $detail->sum('jumlah') }} pcs</span>
                            </div>
                            {{-- Add Tax or Discount rows here if needed in future --}}
                            
                            <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-gradient-primary border-radius-lg shadow-primary">
                                <span class="text-white text-uppercase text-xs font-weight-bold">Total Pembayaran</span>
                                <span class="text-white font-weight-bolder text-xl">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- CARD FOOTER (Optional decoration) --}}
                <div class="card-footer bg-white text-center pt-0 pb-4">
                    <p class="text-secondary text-xs mb-0">Terima kasih atas kepercayaan Anda kepada Sidowaras Pharmacy.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gray-100 {
    background-color: #f8f9fa !important;
}

@media print {
    /* Hide unwanted elements di halaman utama */
    .sidenav, 
    .navbar, 
    .sidebar-toggle-plugin,
    .container-fluid > .row:first-child {
        display: none !important;
    }

    .card {
        box-shadow: none !important;
        border: none !important;
    }

    .badge {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        margin: 1.5cm;
        size: A4;
    }

    body {
        padding: 0 !important;
        margin: 0 !important;
    }
}
</style>

@push('scripts')
<script>
 function printStruk() {
    const printArea = document.getElementById('print-area');
    if (!printArea) {
        // fallback, tapi seharusnya tidak kepakai
        window.print();
        return;
    }

    // Ambil HTML struk saja
    const printContents = printArea.innerHTML;

    // Buka window baru khusus untuk printing
    const printWindow = window.open('', '', 'width=800,height=900');

    printWindow.document.open();
    printWindow.document.write('<html><head><title>Struk {{ $transaksi->no_transaksi }}</title>');

    // Tambahkan stylesheet utama supaya tampilan tetap rapi
    printWindow.document.write('<link rel="stylesheet" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}">');

    // Styling minimal khusus print
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: "Inter", sans-serif; background:#ffffff; padding: 1.5cm; }');
    printWindow.document.write('.card { box-shadow: none !important; border: none !important; }');
    printWindow.document.write('@page { size: A4; margin: 0; }');
    printWindow.document.write('</style>');

    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    printWindow.focus();
    printWindow.print();
    // Kalau mau otomatis nutup setelah print:
    // printWindow.close();
 }
</script>
@endpush
