@extends('layouts.admin.app')
@section('title', 'Tambah User')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.users.index') }}">Manajemen User</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah User</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge"><i class="material-symbols-rounded">person_add</i> User Baru</span>
                    <h2 class="welcome-title">Tambah User</h2>
                    <p class="welcome-subtitle">Buat akun pengguna baru untuk mengakses sistem apotek.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="stat-pill"><i class="material-symbols-rounded">arrow_back</i><span>Kembali</span></a>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">badge</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">security</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Form Card --}}
<div class="card pro-card">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        {{-- Section 1: Informasi Akun --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon primary"><i class="material-symbols-rounded">person</i></div>
                <div><h6 class="section-title">Informasi Akun</h6><p class="section-subtitle">Data identitas pengguna</p></div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Nama Lengkap <span class="required">*</span></label>
                            <div class="input-modern"><i class="material-symbols-rounded input-icon">badge</i><input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required></div>
                            @error('nama_lengkap')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Email <span class="required">*</span></label>
                            <div class="input-modern"><i class="material-symbols-rounded input-icon">mail</i><input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required></div>
                            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Keamanan --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon success"><i class="material-symbols-rounded">lock</i></div>
                <div><h6 class="section-title">Keamanan</h6><p class="section-subtitle">Password dan autentikasi</p></div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Password <span class="required">*</span></label>
                            <div class="input-modern password">
                                <i class="material-symbols-rounded input-icon">key</i>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Minimal 8 karakter" required>
                                <button type="button" class="btn-toggle" onclick="togglePassword('password', this)"><i class="material-symbols-rounded">visibility_off</i></button>
                            </div>
                            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Konfirmasi Password <span class="required">*</span></label>
                            <div class="input-modern password">
                                <i class="material-symbols-rounded input-icon">key</i>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required>
                                <button type="button" class="btn-toggle" onclick="togglePassword('password_confirmation', this)"><i class="material-symbols-rounded">visibility_off</i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Hak Akses --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon warning"><i class="material-symbols-rounded">shield</i></div>
                <div><h6 class="section-title">Hak Akses</h6><p class="section-subtitle">Role dan status pengguna</p></div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Role <span class="required">*</span></label>
                            <div class="input-modern select">
                                <i class="material-symbols-rounded input-icon">admin_panel_settings</i>
                                <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach ($roles as $role)<option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>@endforeach
                                </select>
                            </div>
                            @error('role_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-outline-pro"><i class="material-symbols-rounded">close</i> Batal</a>
            <button type="submit" class="btn-pro primary"><i class="material-symbols-rounded">save</i> Simpan User</button>
        </div>
    </form>
</div>

@push('styles')
<style>
:root { --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6; --primary: #8b5cf6; --secondary: #64748b; }
.welcome-banner { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 16px; padding: 2rem; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; }
.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; border: none; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); overflow: hidden; }
.form-section { border-bottom: 1px solid #f1f5f9; }
.form-section:last-of-type { border-bottom: none; }
.section-header { display: flex; align-items: center; gap: 12px; padding: 1.25rem 1.5rem; background: #fafbfc; border-bottom: 1px solid #f1f5f9; }
.section-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.section-icon i { font-size: 20px; color: white; }
.section-icon.primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.section-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.section-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.section-title { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin: 0; }
.section-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }
.section-body { padding: 1.5rem; }
.form-group-modern { margin-bottom: 0; }
.form-label-modern { display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.form-label-modern .required { color: var(--danger); }
.input-modern { position: relative; }
.input-modern .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 20px; z-index: 2; }
.input-modern .form-control { padding-left: 46px; height: 48px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; transition: all 0.2s; }
.input-modern .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.15); }
.input-modern.select select { appearance: none; cursor: pointer; }
.input-modern.password .form-control { padding-right: 50px; }
.btn-toggle { position: absolute; right: 4px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; border-radius: 8px; background: transparent; color: var(--secondary); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
.btn-toggle:hover { background: #f1f5f9; }
.btn-toggle i { font-size: 20px; }
.form-actions { display: flex; justify-content: flex-end; gap: 12px; padding: 1.25rem 1.5rem; background: #fafbfc; border-top: 1px solid #f1f5f9; }
.btn-pro { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: var(--secondary); font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
.btn-outline-pro i { font-size: 18px; }
@media (max-width: 768px) { .welcome-banner { flex-direction: column; text-align: center; } .welcome-illustration { display: none; } }
</style>
@endpush

@push('scripts')
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility_off';
    }
}
</script>
@endpush
@endsection
