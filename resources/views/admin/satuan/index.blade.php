@extends('layouts.admin.app')
@section('title','Daftar Satuan Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Satuan Obat</li>
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
                                    <i class="material-symbols-rounded text-dark">scale</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Daftar Satuan Obat</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Kelola satuan dan konversi ukuran obat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <button type="button" 
                                    class="btn bg-white text-dark mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#satuanModal" 
                                    data-mode="create">
                                <i class="material-symbols-rounded text-sm">add_circle</i> Tambah Satuan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Total Satuan
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">{{ $satuan->total() }}</h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Jenis satuan terdaftar</p>
                        </div>
                        <div class="summary-icon bg-soft-primary">
                            <i class="material-symbols-rounded text-primary">scale</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 summary-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-1 text-secondary text-uppercase fw-bold text-xxs">
                                Satuan Baru
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ \App\Models\SatuanObat::where('created_at', '>=', now()->subDays(7))->count() }}
                            </h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Ditambahkan 7 hari terakhir</p>
                        </div>
                        <div class="summary-icon bg-soft-success">
                            <i class="material-symbols-rounded text-success">new_releases</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="material-symbols-rounded align-middle">check_circle</i></span>
            <span class="alert-text fw-bold">{{ session('success') }}</span>
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
                                <h6 class="mb-0 fw-bold">Data Satuan</h6>
                                <span class="badge bg-soft-primary text-primary text-xs fw-bold rounded-pill">
                                    {{ $satuan->total() }} data
                                </span>
                            </div>
                        </div>
                        {{-- Search UI --}}
                        <div class="d-flex align-items-center gap-2">
                            <form action="{{ route('admin.satuan.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-nowrap">
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
                                           placeholder="Cari satuan...">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                </div>
                                {{-- Search Button --}}
                                <button type="submit" class="btn bg-gradient-dark mb-0 px-3" style="border-radius: 8px;">
                                    <i class="material-symbols-rounded" style="font-size: 18px;">search</i>
                                </button>
                                {{-- Clear Filter --}}
                                @if(request('search'))
                                    <a href="{{ route('admin.satuan.index') }}" class="btn btn-outline-secondary mb-0 px-3" style="border-radius: 8px;" title="Hapus Filter">
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
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Nama Satuan</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Faktor Konversi</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Dibuat Pada</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-9">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($satuan as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm fw-bold text-dark">{{ $item->nama_satuan }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-soft-info text-info">
                                                {{ $item->faktor_konversi }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">{{ $item->created_at->format('d M Y') }}</p>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button type="button"
                                                    class="btn btn-link text-warning px-3 mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#satuanModal"
                                                    data-mode="edit"
                                                    data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->nama_satuan }}"
                                                    data-faktor="{{ $item->faktor_konversi }}"
                                                    title="Edit">
                                                    <i class="material-symbols-rounded text-sm">edit</i>
                                                </button>
                                                <form action="{{ route('admin.satuan.destroy', $item->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus satuan {{ $item->nama_satuan }}?')">
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
                                        <td colspan="4" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="icon icon-lg icon-shape bg-light shadow-sm rounded-circle mb-3">
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">scale</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data satuan</h6>
                                                <p class="text-xs text-secondary">Silakan tambahkan satuan baru</p>
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
                                        onchange="window.location.href='{{ route('admin.satuan.index') }}?per_page='+this.value">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-xs text-secondary">data per halaman</span>
                            </div>
                            {{-- Center: Info --}}
                            <p class="text-xs text-secondary mb-0">
                                <span class="fw-bold">{{ $satuan->firstItem() ?? 0 }}</span> - 
                                <span class="fw-bold">{{ $satuan->lastItem() ?? 0 }}</span> dari 
                                <span class="fw-bold">{{ $satuan->total() }}</span> data
                            </p>
                            {{-- Right: Pagination --}}
                            <div>
                                {{ $satuan->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Satuan -->
    <div class="modal fade" id="satuanModal" tabindex="-1" aria-labelledby="satuanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-dark">
                    <h5 class="modal-title text-white" id="satuanModalLabel">
                        <i class="material-symbols-rounded me-2 align-middle">scale</i>
                        Tambah Satuan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="satuanForm" method="POST" action="{{ route('admin.satuan.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="satuanFormMethod" value="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Nama Satuan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" 
                                       class="form-control" 
                                       name="nama_satuan" 
                                       id="nama_satuan" 
                                       placeholder="Contoh: Tablet, Kapsul, Box" 
                                       required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Faktor Konversi <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="number" 
                                       class="form-control" 
                                       name="faktor_konversi" 
                                       id="faktor_konversi" 
                                       placeholder="Masukkan nilai konversi" 
                                       required 
                                       min="1">
                            </div>
                            <small class="text-xs text-muted mt-1 d-block">Nilai konversi satuan terkecil (misal: 1 box = 10 strip)</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top p-3">
                        <button type="button" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1" data-bs-dismiss="modal">
                            <i class="material-symbols-rounded text-sm">close</i> Batal
                        </button>
                        <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1" id="satuanSubmitBtn">
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
        const modalEl = document.getElementById('satuanModal');
        if (!modalEl) return;
        
        modalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const mode = button?.getAttribute('data-mode') || 'create';
            const form = document.getElementById('satuanForm');
            const methodInput = document.getElementById('satuanFormMethod');
            const titleEl = document.getElementById('satuanModalLabel');
            const submitBtn = document.getElementById('satuanSubmitBtn');
            const namaInput = document.getElementById('nama_satuan');
            const faktorInput = document.getElementById('faktor_konversi');

            if (mode === 'edit') {
                const id = button.getAttribute('data-id');
                form.action = "{{ url('adminx/satuan') }}/" + id;
                methodInput.value = 'PUT';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">scale</i> Edit Satuan';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">update</i> Update';
                namaInput.value = button.getAttribute('data-nama') || '';
                faktorInput.value = button.getAttribute('data-faktor') || '';
            } else {
                form.action = "{{ route('admin.satuan.store') }}";
                methodInput.value = 'POST';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">scale</i> Tambah Satuan';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">save</i> Simpan';
                namaInput.value = '';
                faktorInput.value = '';
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
