@extends('layouts.admin.app')
@section('title','Daftar Kandungan Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Kandungan Obat</li>
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
                                    <i class="material-symbols-rounded text-dark">science</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Daftar Kandungan Obat</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Kelola kandungan aktif dan dosis obat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <button type="button" 
                                    class="btn bg-white text-dark mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#kandunganModal" 
                                    data-mode="create">
                                <i class="material-symbols-rounded text-sm">add_circle</i> Tambah Kandungan
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
                                Total Kandungan
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">{{ $data->total() }}</h4>
                            <p class="mb-0 text-xxs text-muted mt-1">Jenis kandungan terdaftar</p>
                        </div>
                        <div class="summary-icon bg-soft-primary">
                            <i class="material-symbols-rounded text-primary">science</i>
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
                                Kandungan Baru
                            </p>
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ \App\Models\KandunganObat::where('created_at', '>=', now()->subDays(7))->count() }}
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
                                <h6 class="mb-0 fw-bold">Data Kandungan</h6>
                                <span class="badge bg-soft-primary text-primary text-xs fw-bold rounded-pill">
                                    {{ $data->total() }} data
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-stok">
                            <thead class="bg-gradient-dark">
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-4">Nama Kandungan</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Dosis</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-9 ps-2">Dibuat Pada</th>
                                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-9">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm fw-bold text-dark">{{ $item->nama_kandungan_text }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-soft-info text-info">
                                                {{ $item->dosis_kandungan }}
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
                                                    data-bs-target="#kandunganModal"
                                                    data-mode="edit"
                                                    data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->nama_kandungan_text }}"
                                                    data-dosis="{{ $item->dosis_kandungan }}"
                                                    title="Edit">
                                                    <i class="material-symbols-rounded text-sm">edit</i>
                                                </button>
                                                <form action="{{ route('admin.kandungan.destroy', $item->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus kandungan {{ $item->nama_kandungan_text }}?')">
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
                                                    <i class="material-symbols-rounded text-secondary opacity-5" style="font-size: 2rem;">science</i>
                                                </div>
                                                <h6 class="text-secondary mb-1">Belum ada data kandungan</h6>
                                                <p class="text-xs text-secondary">Silakan tambahkan kandungan baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
                        <div class="text-xs text-secondary">
                            Menampilkan {{ $data->firstItem() ?? 0 }} sampai {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
                        </div>
                        <div>
                            {{ $data->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Kandungan -->
    <div class="modal fade" id="kandunganModal" tabindex="-1" aria-labelledby="kandunganModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-dark">
                    <h5 class="modal-title text-white" id="kandunganModalLabel">
                        <i class="material-symbols-rounded me-2 align-middle">science</i>
                        Tambah Kandungan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kandunganForm" method="POST" action="{{ route('admin.kandungan.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="kandunganFormMethod" value="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Nama Kandungan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" 
                                       class="form-control" 
                                       name="nama_kandungan" 
                                       id="nama_kandungan" 
                                       placeholder="Contoh: Paracetamol, Ibuprofen" 
                                       required>
                            </div>
                            <small class="text-xs text-muted mt-1 d-block">Pisahkan dengan koma jika lebih dari satu</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Dosis Kandungan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" 
                                       class="form-control" 
                                       name="dosis_kandungan" 
                                       id="dosis_kandungan" 
                                       placeholder="Contoh: 500mg, 100ml" 
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top p-3">
                        <button type="button" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1" data-bs-dismiss="modal">
                            <i class="material-symbols-rounded text-sm">close</i> Batal
                        </button>
                        <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1" id="kandunganSubmitBtn">
                            <i class="material-symbols-rounded text-sm">save</i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
    (function() {
        // Init Tagify
        var input = document.querySelector('#nama_kandungan');
        var tagify = new Tagify(input, {
            delimiters: ",",
            placeholder: "Ketik nama kandungan",
            dropdown: {
                enabled: 0
            }
        });

        const modalEl = document.getElementById('kandunganModal');
        if (!modalEl) return;
        
        modalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const mode = button?.getAttribute('data-mode') || 'create';
            const form = document.getElementById('kandunganForm');
            const methodInput = document.getElementById('kandunganFormMethod');
            const titleEl = document.getElementById('kandunganModalLabel');
            const submitBtn = document.getElementById('kandunganSubmitBtn');
            const dosisInput = document.getElementById('dosis_kandungan');

            if (mode === 'edit') {
                const id = button.getAttribute('data-id');
                form.action = "{{ url('adminx/kandungan') }}/" + id;
                methodInput.value = 'PUT';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">science</i> Edit Kandungan';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">update</i> Update';
                
                // Set values
                const namaVal = button.getAttribute('data-nama') || '';
                tagify.removeAllTags();
                tagify.addTags(namaVal);
                
                dosisInput.value = button.getAttribute('data-dosis') || '';
            } else {
                form.action = "{{ route('admin.kandungan.store') }}";
                methodInput.value = 'POST';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2 align-middle">science</i> Tambah Kandungan';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1 text-sm">save</i> Simpan';
                
                tagify.removeAllTags();
                dosisInput.value = '';
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
        
        /* Tagify Customization */
        .tagify {
            --tagify-dd-color-primary: rgb(53,149,246);
            --tagify-bg: transparent;
            width: 100%;
            border: 1px solid #d2d6da;
            border-radius: 0.375rem;
            padding: 0.3rem 0.5rem;
        }
        .tagify:hover {
            border-color: #b1b7c1;
        }
        .tagify.tagify--focus {
            border-color: #e91e63;
            box-shadow: inset 0 0 0 1px #e91e63;
        }
    </style>
</div>
@endsection
