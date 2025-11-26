@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title', 'Edit Kandungan Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.kandungan.index') }}">Kandungan Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-header bg-gradient-dark p-4 rounded-top-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3">
                            <i class="material-symbols-rounded text-dark">science</i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white fw-bold">Edit Kandungan Obat</h5>
                            <p class="text-sm text-white opacity-8 mb-0">Perbarui data kandungan obat</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.kandungan.update', $kandungan->id) }}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="mb-4">
                            <label for="nama_kandungan" class="form-label text-sm fw-bold text-uppercase text-secondary mb-1">Nama Kandungan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" name="nama_kandungan" id="nama_kandungan" value="{{ $kandungan->nama_kandungan_text }}" class="form-control" required>
                            </div>
                            <small class="text-xs text-muted mt-1 d-block">Pisahkan dengan koma jika lebih dari satu</small>
                        </div>

                        <div class="mb-4">
                            <label for="dosis_kandungan" class="form-label text-sm fw-bold text-uppercase text-secondary mb-1">Dosis Kandungan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" name="dosis_kandungan" value="{{ $kandungan->dosis_kandungan }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.kandungan.index') }}" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">arrow_back</i> Kembali
                            </a>
                            <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">update</i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<script>
var input = document.querySelector('#nama_kandungan');
var tagify = new Tagify(input, {
    delimiters: ",",
    placeholder: "Ketik nama kandungan",
    dropdown: {
        enabled: 0
    }
});
</script>
@endpush

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
@endsection
