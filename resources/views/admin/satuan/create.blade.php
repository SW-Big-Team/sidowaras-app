@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title', 'Tambah Satuan Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.satuan.index') }}">Satuan Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah</li>
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
                            <i class="material-symbols-rounded text-dark">scale</i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white fw-bold">Tambah Satuan Obat</h5>
                            <p class="text-sm text-white opacity-8 mb-0">Isi form berikut untuk menambahkan satuan obat baru</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.satuan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_satuan" class="form-label text-sm fw-bold text-uppercase text-secondary mb-1">Nama Satuan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" name="nama_satuan" id="nama_satuan" class="form-control" placeholder="Contoh: Tablet, Kapsul, Box" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="faktor_konversi" class="form-label text-sm fw-bold text-uppercase text-secondary mb-1">Faktor Konversi <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="number" name="faktor_konversi" class="form-control" placeholder="Masukkan nilai konversi" required min="1">
                            </div>
                            <small class="text-xs text-muted mt-1 d-block">Nilai konversi satuan terkecil (misal: 1 box = 10 strip)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.satuan.index') }}" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">arrow_back</i> Kembali
                            </a>
                            <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">save</i> Simpan
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
