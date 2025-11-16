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
    <x-content-header title="Tambah User Baru" subtitle="Buat pengguna baru untuk akses sistem">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mb-0">
            <i class="material-symbols-rounded text-sm me-1">arrow_back</i> Kembali
        </a>
    </x-content-header>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Informasi Akun -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded opacity-10">person</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Informasi Akun</h6>
                                        <p class="text-sm text-secondary mb-0">Data identitas pengguna</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-3">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Keamanan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded opacity-10">lock</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Keamanan</h6>
                                        <p class="text-sm text-secondary mb-0">Password dan autentikasi</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-3">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Minimal 8 karakter" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-3">
                                    <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password" required>
                                </div>
                            </div>
                        </div>

                        <!-- Role & Status -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md me-3">
                                        <i class="material-symbols-rounded opacity-10">shield</i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Hak Akses</h6>
                                        <p class="text-sm text-secondary mb-0">Role dan status pengguna</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-3">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" required>
                                        <option value="">-- Pilih Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ $role->nama_role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <hr class="horizontal dark my-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mb-0">
                                        <i class="material-symbols-rounded text-sm me-1">close</i> Batal
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary mb-0">
                                        <i class="material-symbols-rounded text-sm me-1">save</i> Simpan User
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
@endsection
