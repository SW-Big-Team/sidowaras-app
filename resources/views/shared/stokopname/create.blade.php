@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Input Stock Opname')

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Stock Opname Harian" subtitle="Input stok fisik untuk pengecekan harian">
        <a href="{{ route('stokopname.index') }}" class="btn btn-outline-secondary mb-0">
            <i class="material-symbols-rounded text-sm me-1">arrow_back</i> Kembali
        </a>
    </x-content-header>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded">error</i></span>
            <span class="alert-text">
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Tanggal: {{ now()->format('d/m/Y') }}</h6>
                    <p class="text-sm text-secondary mb-0">Total {{ $obats->sum(fn($items) => $items->count()) }} item obat</p>
                </div>
                <span class="badge bg-gradient-primary">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>
    </div>

    <form action="{{ route('stokopname.store') }}" method="POST" id="stockOpnameForm">
        @csrf
        <div class="accordion" id="rakAccordion">
            @foreach ($obats as $rak => $items)
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading-{{ Str::slug($rak ?: 'tanpa-lokasi') }}">
                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center">
                                    <i class="material-symbols-rounded opacity-10 text-white">shelves</i>
                                </div>
                                <div>
                                    <strong>Rak: {{ $rak ?: 'Tanpa Lokasi' }}</strong>
                                    <span class="badge bg-secondary ms-2">{{ $items->count() }} item</span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}" 
                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                         aria-labelledby="heading-{{ Str::slug($rak ?: 'tanpa-lokasi') }}">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Obat</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok Sistem</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stok Fisik</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $obat)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $obat->nama_obat }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $obat->kode_obat }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge badge-sm bg-gradient-primary">{{ $obat->total_stok ?? 0 }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group input-group-static">
                                                    <input type="number" 
                                                           name="physical_qty[{{ $obat->id }}]" 
                                                           class="form-control text-center"
                                                           min="0"
                                                           required
                                                           value="{{ old('physical_qty.'.$obat->id, 0) }}"
                                                           placeholder="0"
                                                           data-system-qty="{{ $obat->total_stok ?? 0 }}">
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group input-group-static">
                                                    <textarea name="notes[{{ $obat->id }}]" 
                                                              class="form-control"
                                                              rows="1"
                                                              maxlength="500"
                                                              placeholder="Catatan (opsional)">{{ old('notes.'.$obat->id) }}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('stokopname.index') }}" class="btn btn-outline-secondary mb-0">
                        <i class="material-symbols-rounded me-1">close</i> Batal
                    </a>
                    <button type="submit" class="btn bg-gradient-success mb-0">
                        <i class="material-symbols-rounded me-1">send</i> Kirim untuk Approval
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
    }
    .accordion-item {
        border-radius: 0.75rem !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        border: none !important;
    }
    .accordion-button {
        font-weight: 600;
        background-color: #f8f9fa !important;
        border-radius: 0.75rem !important;
    }
    .accordion-button:not(.collapsed) {
        background-color: #fff !important;
        box-shadow: none !important;
    }
    .table th, .table td {
        vertical-align: middle;
        padding: 0.75rem;
    }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: 1;
    }
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        .icon-shape {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('stockOpnameForm');
    
    // Highlight rows with variance
    const inputs = document.querySelectorAll('input[name^="physical_qty"]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const systemQty = parseInt(this.dataset.systemQty || 0);
            const physicalQty = parseInt(this.value || 0);
            const row = this.closest('tr');
            
            // Remove all variance classes
            row.classList.remove('table-success', 'table-danger', 'table-warning');
            
            if (physicalQty > systemQty) {
                row.classList.add('table-success'); // Kelebihan
            } else if (physicalQty < systemQty) {
                row.classList.add('table-danger'); // Kekurangan
            }
        });
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        let hasInput = false;
        inputs.forEach(input => {
            if (input.value && parseInt(input.value) > 0) {
                hasInput = true;
            }
        });
        
        if (!hasInput) {
            e.preventDefault();
            alert('Mohon isi minimal satu item stok fisik!');
            return false;
        }
        
        return confirm('Pastikan data sudah benar. Lanjutkan kirim untuk approval?');
    });
});
</script>
@endpush
