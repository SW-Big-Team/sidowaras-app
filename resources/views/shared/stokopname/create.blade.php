@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Input Stock Opname')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('stokopname.index') }}">Stock Opname</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Input</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark text-3xl">add_task</i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-white font-weight-bolder">Stock Opname Bulanan</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Input stok fisik untuk pengecekan bulanan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            {{-- Fixed Alignment here --}}
                            <div class="d-flex align-items-center justify-content-md-end text-white">
                                <div class="icon icon-sm bg-white-10 rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-symbols-rounded text-sm">calendar_today</i>
                                </div>
                                <span class="font-weight-bold">{{ now()->isoFormat('MMMM Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Error Alert --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm text-white" role="alert">
            <div class="d-flex align-items-start">
                <span class="alert-icon me-2"><i class="material-symbols-rounded align-middle text-lg">error</i></span>
                <div>
                    <strong class="text-sm">Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-1 text-sm ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Summary Card --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-dark shadow-dark text-center border-radius-md me-3">
                            <i class="material-symbols-rounded opacity-10 text-white">inventory_2</i>
                        </div>
                        <div>
                            <p class="text-xs mb-0 text-uppercase font-weight-bold text-secondary">Total Item Obat</p>
                            <h4 class="font-weight-bolder mb-0">{{ $obats->sum(fn($items) => $items->count()) }} <span class="text-xs font-weight-normal text-secondary">Items</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('stokopname.store') }}" method="POST" id="stockOpnameForm">
        @csrf
        <div class="accordion" id="rakAccordion">
            @foreach ($obats as $rak => $items)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white pb-0" id="heading-{{ Str::slug($rak ?: 'tanpa-lokasi') }}">
                        <button class="btn btn-link text-dark text-start w-100 p-0 text-decoration-none accordion-button-custom" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}">
                            
                            <div class="d-flex align-items-center justify-content-between p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape bg-gradient-dark shadow-dark text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded opacity-10 text-white">shelves</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold text-dark">Rak: {{ $rak ?: 'Tanpa Lokasi' }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $items->count() }} item obat</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark border me-3">{{ $items->count() }}</span>
                                    {{-- Added Chevron Icon for better UX --}}
                                    <i class="material-symbols-rounded text-secondary transition-transform accordion-arrow">expand_more</i>
                                </div>
                            </div>
                        </button>
                    </div>

                    <div id="collapse-{{ Str::slug($rak ?: 'tanpa-lokasi') }}" 
                         class="collapse {{ $loop->first ? 'show' : '' }}" 
                         aria-labelledby="heading-{{ Str::slug($rak ?: 'tanpa-lokasi') }}">
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-symbols-rounded text-sm me-2">medication</i> Nama Obat
                                                </div>
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <i class="material-symbols-rounded text-sm me-1">database</i> Stok Sistem
                                                </div>
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <i class="material-symbols-rounded text-sm me-1">inventory</i> Stok Fisik
                                                </div>
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-symbols-rounded text-sm me-1">edit_note</i> Catatan
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $obat)
                                        <tr class="border-bottom stock-row">
                                            <td class="ps-4">
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $obat->nama_obat }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $obat->kode_obat }}</p>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-sm bg-gradient-light text-dark border font-weight-bold px-3">{{ $obat->total_stok ?? 0 }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <input type="number" 
                                                           name="physical_qty[{{ $obat->id }}]" 
                                                           class="form-control text-center stock-input font-weight-bold"
                                                           style="max-width: 100px;"
                                                           min="0"
                                                           required
                                                           value="{{ old('physical_qty.'.$obat->id, 0) }}"
                                                           data-system-qty="{{ $obat->total_stok ?? 0 }}">
                                                </div>
                                            </td>
                                            <td class="pe-4">
                                                <div class="input-group input-group-sm input-group-outline">
                                                    <input type="text" 
                                                           name="notes[{{ $obat->id }}]" 
                                                           class="form-control"
                                                           maxlength="255"
                                                           placeholder="Catatan..."
                                                           value="{{ old('notes.'.$obat->id) }}">
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

        {{-- Action Buttons --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('stokopname.index') }}" class="btn btn-outline-secondary mb-0 d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm me-1">close</i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-success mb-0 d-flex align-items-center shadow-success">
                                <i class="material-symbols-rounded text-sm me-1">send</i> Kirim Approval
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
/* Icon Container Fix */
.icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.75rem;
}

/* Make the icon container in the header semi-transparent */
.bg-white-10 {
    background-color: rgba(255, 255, 255, 0.1);
    width: 32px;
    height: 32px;
}

/* Accordion Arrow Animation */
.transition-transform {
    transition: transform 0.3s ease-in-out;
}

/* Rotate arrow when collapsed is false (open) */
[aria-expanded="true"] .accordion-arrow {
    transform: rotate(180deg);
}

/* Table State Colors */
.stock-row.table-success {
    background-color: #f0fdf4 !important; /* Softer Green */
}
.stock-row.table-danger {
    background-color: #fef2f2 !important; /* Softer Red */
}

/* Input styling */
.stock-input:focus {
    box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.5);
    border-color: #63b3ed;
}

@media (max-width: 768px) {
    .icon-shape {
        width: 40px;
        height: 40px;
    }
    .text-3xl {
        font-size: 1.5rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('stockOpnameForm');
    
    // Highlight rows with variance
    const inputs = document.querySelectorAll('.stock-input');
    inputs.forEach(input => {
        // Initial check on load (in case of validation error redirect)
        checkVariance(input);

        input.addEventListener('input', function() {
            checkVariance(this);
        });
    });

    function checkVariance(input) {
        const systemQty = parseInt(input.dataset.systemQty || 0);
        // Default to 0 if empty to avoid NaN
        const physicalQty = input.value === '' ? 0 : parseInt(input.value);
        const row = input.closest('tr');
        
        row.classList.remove('table-success', 'table-danger');
        
        if (physicalQty > systemQty) {
            row.classList.add('table-success'); // Surplus
        } else if (physicalQty < systemQty) {
            row.classList.add('table-danger'); // Shortage
        }
    }
    
    // Form validation
    form.addEventListener('submit', function(e) {
        let hasInput = false;
        inputs.forEach(input => {
            if (input.value && parseInt(input.value) >= 0) {
                hasInput = true;
            }
        });
        
        // Technically they can submit 0, but maybe warn if EVERYTHING is 0?
        // For now, basic confirm:
        if (!confirm('Pastikan data stok fisik sudah benar. Lanjutkan?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush