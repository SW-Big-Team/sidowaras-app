@extends('layouts.kasir.app')

@section('title', 'Riwayat Transaksi Saya')

@section('content')
<div class="container-fluid py-4">
    
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-lg border-0">
                
                {{-- CARD HEADER: Title & Filters --}}
                <div class="card-header bg-white p-4 pb-0">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h5 class="mb-1 text-dark font-weight-bolder">Riwayat Transaksi Saya</h5>
                            <p class="text-sm text-secondary mb-0">
                                Pantau semua transaksi yang telah Anda proses.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('kasir.transaksi.riwayat') }}" class="d-flex justify-content-md-end justify-content-start gap-2">
                                {{-- Search Input --}}
                                <div class="input-group" style="max-width: 300px;">
                                    <span class="input-group-text text-body bg-gray-100 border-end-0">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-gray-100 border-start-0 ps-0" placeholder="Cari No Transaksi...">
                                </div>
                                {{-- Date Filter Button --}}
                                <button type="button" class="btn btn-outline-secondary mb-0 text-nowrap" data-bs-toggle="modal" data-bs-target="#filterModal">
                                    <i class="material-symbols-rounded align-middle me-1" style="font-size: 1.2rem;">filter_list</i> 
                                    Filter
                                    @if(request('start_date') || request('end_date') || request('metode'))
                                        <span class="badge bg-success ms-1">✓</span>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No. Transaksi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Metode</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end pe-4">Total Nominal</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $t)
                                    <tr class="border-bottom">
                                        {{-- 1. Transaction ID --}}
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-sm icon-shape bg-gradient-primary shadow-primary text-center border-radius-md me-3">
                                                    <i class="material-symbols-rounded opacity-10 text-white text-sm">receipt_long</i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-sm text-dark">{{ $t->no_transaksi }}</h6>
                                                    {{-- Optional: Show customer name if you have it --}}
                                                    <span class="text-xs text-secondary">Umum</span> 
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 2. Date & Time --}}
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark text-sm font-weight-bold">{{ $t->tgl_transaksi->format('d M Y') }}</span>
                                                <span class="text-secondary text-xs">{{ $t->tgl_transaksi->format('H:i') }} WIB</span>
                                            </div>
                                        </td>

                                        {{-- 3. Payment Method --}}
                                        <td>
                                            @if($t->metode_pembayaran === 'tunai')
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-money-bill-wave text-success text-sm me-2"></i>
                                                    <span class="text-xs font-weight-bold text-dark">Tunai</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-credit-card text-info text-sm me-2"></i>
                                                    <span class="text-xs font-weight-bold text-dark">Non Tunai</span>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- 4. Total Amount --}}
                                        <td class="align-middle text-end pe-4">
                                            <span class="text-dark text-sm font-weight-bolder">
                                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        {{-- 5. Action Button --}}
                                        <td class="align-middle text-end pe-4">
                                            <a href="{{ route('kasir.transaksi.show', $t->id) }}" 
                                               class="btn btn-link text-secondary font-weight-bold text-xs p-0 mb-0" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-title="Lihat Detail">
                                                Detail <i class="fas fa-chevron-right text-xs ms-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Empty State --}}
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-gray-100 shadow-none rounded-circle mb-3 text-center">
                                                    <i class="material-symbols-rounded text-secondary opacity-5 text-3xl">receipt_long</i>
                                                </div>
                                                <h6 class="text-secondary font-weight-normal">Belum ada riwayat transaksi.</h6>
                                                <a href="{{ route('karyawan.cart.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    Buat Transaksi Baru
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- PAGINATION --}}
                @if($transaksis->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-end">
                            {{ $transaksis->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Filter Modal --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="material-symbols-rounded align-middle me-2">filter_list</i>
                    Filter Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('kasir.transaksi.riwayat') }}">
                <div class="modal-body">
                    {{-- Preserve search query --}}
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- Date Range --}}
                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold">Rentang Tanggal</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="Dari">
                                <small class="text-muted">Dari</small>
                            </div>
                            <div class="col-6">
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="Sampai">
                                <small class="text-muted">Sampai</small>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold">Metode Pembayaran</label>
                        <select name="metode" class="form-control">
                            <option value="">Semua Metode</option>
                            <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="non tunai" {{ request('metode') == 'non tunai' ? 'selected' : '' }}>Non Tunai</option>
                        </select>
                    </div>

                    {{-- Active Filters Summary --}}
                    @if(request('start_date') || request('end_date') || request('metode'))
                        <div class="alert alert-info">
                            <small class="text-sm">
                                <strong>Filter Aktif:</strong><br>
                                @if(request('start_date'))
                                    • Dari: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}<br>
                                @endif
                                @if(request('end_date'))
                                    • Sampai: {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}<br>
                                @endif
                                @if(request('metode'))
                                    • Metode: {{ ucfirst(request('metode')) }}<br>
                                @endif
                            </small>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <a href="{{ route('kasir.transaksi.riwayat') }}" class="btn btn-outline-secondary mb-0">
                        <i class="material-symbols-rounded align-middle me-1" style="font-size: 1rem;">refresh</i>
                        Reset
                    </a>
                    <button type="submit" class="btn btn-success mb-0">
                        <i class="material-symbols-rounded align-middle me-1" style="font-size: 1rem;">check</i>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Subtle Hover Effect on Rows */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }
    
    /* Custom Input styling */
    .input-group-text {
        border-color: #dee2e6;
    }
    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
        border-left: 1px solid #dee2e6 !important;
    }
</style>
@endpush