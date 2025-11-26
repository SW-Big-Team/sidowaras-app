@extends('layouts.admin.app')

@section('title', 'Tambah User')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.users.index') }}">Manajemen User</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah User</li>
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
                                <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl me-3 d-flex align-items-center justify-content-center">
                                    <i class="material-symbols-rounded text-dark">person_add</i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-white fw-bold">Tambah User Baru</h4>
                                    <p class="text-sm text-white opacity-8 mb-0">Buat pengguna baru untuk akses sistem</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-white mb-0 shadow-sm-sm d-inline-flex align-items-center gap-1">
                                <i class="material-symbols-rounded text-sm">arrow_back</i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Informasi Akun -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-soft-primary text-primary shadow-none text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded text-lg">person</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">Informasi Akun</h6>
                                        <p class="text-xs text-secondary mb-0">Data identitas pengguna</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Email <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Keamanan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-soft-success text-success shadow-none text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded text-lg">lock</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">Keamanan</h6>
                                        <p class="text-xs text-secondary mb-0">Password dan autentikasi</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Minimal 8 karakter" required>
                                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password', this)">
                                            <i class="material-symbols-rounded text-lg">visibility_off</i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required>
                                        <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)">
                                            <i class="material-symbols-rounded text-lg">visibility_off</i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Role & Status -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-soft-warning text-warning shadow-none text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded text-lg">shield</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">Hak Akses</h6>
                                        <p class="text-xs text-secondary mb-0">Role dan status pengguna</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-1">Role <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-outline">
                                        <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                                            <option value="">-- Pilih Role --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->nama_role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('role_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <hr class="horizontal dark my-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1">
                                        <i class="material-symbols-rounded text-sm">close</i> Batal
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary mb-0 d-flex align-items-center gap-1">
                                        <i class="material-symbols-rounded text-sm">save</i> Simpan User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(94, 114, 228, 0.10) !important; }
    .bg-soft-success { background: rgba(40, 167, 69, 0.08) !important; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.12) !important; }
    .shadow-sm-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
    
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7b809a;
        z-index: 5;
    }

    .btn-toggle-password:hover {
        color: #344767;
    }
    
    .input-group-outline {
        position: relative;
    }
</style>

@push('scripts')
<script>
    function togglePasswordVisibility(fieldId, btnElement) {
        const passwordField = document.getElementById(fieldId);
        const icon = btnElement.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.textContent = 'visibility';
        } else {
            passwordField.type = 'password';
            icon.textContent = 'visibility_off';
        }
    }
</script>
@endpush
@endsection
