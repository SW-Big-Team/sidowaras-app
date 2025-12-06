@extends('layouts.admin.app')

@section('title', 'Daftar Supplier')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Data</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Supplier</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-dark border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                                    <i class="material-symbols-rounded text-dark">local_shipping</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Daftar Supplier</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Kelola data supplier dan pemasok obat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <button type="button" 
                                    class="btn bg-white text-dark mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#supplierModal" 
                                    data-mode="create">
                                <i class="material-symbols-rounded text-sm">add_circle</i> Tambah Supplier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Total Supplier
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">{{ $suppliers->total() }}</h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Seluruh supplier terdaftar</p>
                        </div>
                        <div class="summary-icon bg-soft-primary">
                            <i class="material-symbols-rounded text-primary">inventory_2</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Supplier Aktif
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ \App\Models\Supplier::where('supplier_status', true)->count() }}
                            </h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Supplier yang aktif</p>
                        </div>
                        <div class="summary-icon bg-soft-success">
                            <i class="material-symbols-rounded text-success">check_circle</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Supplier Nonaktif
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ \App\Models\Supplier::where('supplier_status', false)->count() }}
                            </h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Supplier yang tidak aktif</p>
                        </div>
                        <div class="summary-icon bg-soft-secondary">
                            <i class="material-symbols-rounded text-secondary">cancel</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
            <span class="alert-text fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">error</i></span>
            <span class="alert-text">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0 fw-bold">Data Supplier</h6>
                                <span class="badge bg-soft-primary text-primary text-xs fw-bold rounded-pill">
                                    {{ $suppliers->total() }} supplier
                                </span>
                            </div>
                        </div>
                        {{-- Filter & Search UI - Inline Layout --}}
                        <div class="d-flex align-items-center gap-2">
                            <form action="{{ route('admin.supplier.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-nowrap">
                                {{-- Status Filter with Icon --}}
                                <div class="input-group" style="width: auto;">
                                    <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                                        <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">filter_list</i>
                                    </span>
                                    <select name="status" class="form-control form-select-sm" onchange="this.form.submit()" style="min-width: 130px; border-radius: 0 8px 8px 0;">
                                        <option value="">Semua Status</option>
                                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                </div>
                                {{-- Search Input with Icon --}}
                                <div class="input-group" style="width: 220px;">
                                    <span class="input-group-text bg-white" style="border-radius: 8px 0 0 8px; border-right: 0;">
                                        <i class="material-symbols-rounded text-secondary" style="font-size: 18px;">search</i>
                                    </span>
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           class="form-control ps-0" 
                                           style="border-radius: 0 8px 8px 0; border-left: 0;"
                                           placeholder="Cari supplier...">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                </div>
                                {{-- Search Button --}}
                                <button type="submit" class="btn bg-gradient-dark mb-0 px-3" style="border-radius: 8px;">
                                    <i class="material-symbols-rounded" style="font-size: 18px;">search</i>
                                </button>
                                {{-- Clear Filter --}}
                                @if(request('search') || request('status'))
                                    <a href="{{ route('admin.supplier.index') }}" class="btn btn-outline-secondary mb-0 px-3" style="border-radius: 8px;" title="Hapus Filter">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">close</i>
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Nama Supplier</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Kontak</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Email & Website</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2 text-center">Status</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-9">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm fw-bold text-dark">{{ $supplier->supplier_name }}</h6>
                                                    @if($supplier->supplier_address)
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($supplier->supplier_address, 50) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-dark">{{ $supplier->supplier_phone }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-xs text-secondary mb-0">{{ $supplier->supplier_email ?? '-' }}</span>
                                                <span class="text-xs text-secondary mb-0">{{ $supplier->supplier_website ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.supplier.toggle-status', $supplier->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="border-0 bg-transparent p-0 cursor-pointer" title="Klik untuk mengubah status">
                                                    @if($supplier->supplier_status)
                                                        <span class="badge badge-sm bg-soft-success text-success">
                                                            <i class="material-symbols-rounded text-xxs me-1 align-middle">check_circle</i>Aktif
                                                        </span>
                                                    @else
                                                        <span class="badge badge-sm bg-soft-secondary text-secondary">
                                                            <i class="material-symbols-rounded text-xxs me-1 align-middle">cancel</i>Non-Aktif
                                                        </span>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button type="button"
                                                    class="btn btn-link text-warning px-3 mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#supplierModal"
                                                    data-mode="edit"
                                                    data-id="{{ $supplier->id }}"
                                                    data-name="{{ $supplier->supplier_name }}"
                                                    data-phone="{{ $supplier->supplier_phone }}"
                                                    data-address="{{ $supplier->supplier_address }}"
                                                    data-email="{{ $supplier->supplier_email }}"
                                                    data-website="{{ $supplier->supplier_website }}"
                                                    data-logo="{{ $supplier->supplier_logo }}"
                                                    data-status="{{ $supplier->supplier_status ? 1 : 0 }}"
                                                    title="Edit">
                                                    <i class="material-symbols-rounded text-sm">edit</i>
                                                </button>
                                                <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus supplier {{ $supplier->supplier_name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-link text-danger px-3 mb-0"
                                                            title="Hapus">
                                                        <i class="material-symbols-rounded text-sm">delete</i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">local_shipping</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data supplier</h6>
                                                <p class="text-xs text-secondary">Silakan tambahkan supplier baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-top">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            {{-- Left: Per Page Selector --}}
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-xs text-secondary">Tampilkan</span>
                                <select class="form-select form-select-sm border rounded-2 px-2 py-1" 
                                        style="width: auto; min-width: 65px;" 
                                        onchange="window.location.href='{{ route('admin.supplier.index') }}?per_page='+this.value+'&search={{ request('search') }}&status={{ request('status') }}'">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-xs text-secondary">data per halaman</span>
                            </div>
                            {{-- Center: Info --}}
                            <p class="text-xs text-secondary mb-0">
                                <span class="fw-bold">{{ $suppliers->firstItem() ?? 0 }}</span> - 
                                <span class="fw-bold">{{ $suppliers->lastItem() ?? 0 }}</span> dari 
                                <span class="fw-bold">{{ $suppliers->total() }}</span> data
                            </p>
                            {{-- Right: Pagination --}}
                            <div>
                                {{ $suppliers->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Supplier -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-dark">
                    <h5 class="modal-title text-white" id="supplierModalLabel">
                        <i class="material-symbols-rounded me-2 align-middle">local_shipping</i>
                        Tambah Supplier
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="supplierForm" method="post" action="{{ route('admin.supplier.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="supplierFormMethod" value="POST">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Nama Supplier <span class="text-danger">*</span></label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Contoh: PT. Kimia Farma" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">No. Telepon <span class="text-danger">*</span></label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" name="supplier_phone" id="supplier_phone" placeholder="Contoh: 08123456789" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Alamat</label>
                                <div class="input-group input-group-outline">
                                    <textarea class="form-control" name="supplier_address" id="supplier_address" rows="3" placeholder="Masukkan alamat lengkap supplier"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Email</label>
                                <div class="input-group input-group-outline">
                                    <input type="email" class="form-control" name="supplier_email" id="supplier_email" placeholder="nama@domain.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Website</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" name="supplier_website" id="supplier_website" placeholder="https://example.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Logo (URL/Path)</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" name="supplier_logo" id="supplier_logo" placeholder="/path/to/logo.png atau URL">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Status</label>
                                <div class="form-check form-switch ps-0 mt-2">
                                    <input class="form-check-input ms-0" type="checkbox" name="supplier_status" value="1" checked id="supplier_status_modal">
                                    <label class="form-check-label ms-3 text-sm fw-bold text-dark" for="supplier_status_modal">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top p-3">
                        <button type="button" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1" data-bs-dismiss="modal">
                            <i class="material-symbols-rounded text-sm">close</i> Batal
                        </button>
                        <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1" id="supplierSubmitBtn">
                            <i class="material-symbols-rounded text-sm">save</i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function() {
        const modalEl = document.getElementById('supplierModal');
        if (!modalEl) return;
        modalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const mode = button?.getAttribute('data-mode') || 'create';
            const form = document.getElementById('supplierForm');
            const methodInput = document.getElementById('supplierFormMethod');
            const titleEl = document.getElementById('supplierModalLabel');
            const submitBtn = document.getElementById('supplierSubmitBtn');

            // fields
            const f = {
                name: document.getElementById('supplier_name'),
                phone: document.getElementById('supplier_phone'),
                address: document.getElementById('supplier_address'),
                email: document.getElementById('supplier_email'),
                website: document.getElementById('supplier_website'),
                logo: document.getElementById('supplier_logo'),
                status: document.getElementById('supplier_status_modal'),
            };

            if (mode === 'edit') {
                const id = button.getAttribute('data-id');
                form.action = "{{ url('adminx/supplier') }}/" + id;
                methodInput.value = 'PUT';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">local_shipping</i> Edit Supplier';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">update</i> Update';

                f.name.value = button.getAttribute('data-name') || '';
                f.phone.value = button.getAttribute('data-phone') || '';
                f.address.value = button.getAttribute('data-address') || '';
                f.email.value = button.getAttribute('data-email') || '';
                f.website.value = button.getAttribute('data-website') || '';
                f.logo.value = button.getAttribute('data-logo') || '';
                f.status.checked = (button.getAttribute('data-status') === '1');
            } else {
                form.action = "{{ route('admin.supplier.store') }}";
                methodInput.value = 'POST';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">local_shipping</i> Tambah Supplier';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">save</i> Simpan';

                f.name.value = '';
                f.phone.value = '';
                f.address.value = '';
                f.email.value = '';
                f.website.value = '';
                f.logo.value = '';
                f.status.checked = true;
            }
        });
    })();
    </script>
    @endpush
    
    <style>
        .text-xxs { font-size: 0.65rem !important; }
        .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
        
        .bg-gradient-info-soft {
            background: linear-gradient(135deg, rgba(23, 162, 184, .08), rgba(23, 162, 184, .16));
            color: #138496;
        }

        .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
        .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
        .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
        .bg-soft-info { background: rgba(23, 162, 184, 0.12) !important; }
        .bg-soft-secondary { background: rgba(108, 117, 125, 0.12) !important; }

        .table-stok thead tr th {
            border-top: none;
            font-weight: 600;
            letter-spacing: .04em;
        }

        .table-stok tbody tr {
            transition: background-color 0.15s ease, box-shadow 0.15s ease;
        }
        .table-stok tbody tr:hover {
            background-color: #f8f9fe;
        }

        .table td, .table th { vertical-align: middle; }
        
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
        
        .cursor-pointer {
            cursor: pointer;
        }
        
        /* Summary Card Styles */
        .summary-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }
        .summary-icon {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</div>
@endsection