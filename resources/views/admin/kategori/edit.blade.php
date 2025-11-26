@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title', 'Edit Kategori Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.kategori.index') }}">Kategori Obat</a></li>
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
                            <i class="material-symbols-rounded text-dark">category</i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white fw-bold">Edit Kategori Obat</h5>
                            <p class="text-sm text-white opacity-8 mb-0">Perbarui data kategori obat</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label text-sm fw-bold text-uppercase text-secondary mb-1">Nama Kategori <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ $kategori->nama_kategori }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1">
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
</style>
@endsection
