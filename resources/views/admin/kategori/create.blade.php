@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title', 'Tambah Kategori Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.kategori.index') }}">Kategori Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah</li>
</ol>
@endsection

@section('content')
{{-- Welcome Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <span class="greeting-badge">
                        <i class="material-symbols-rounded">category</i>
                        Kategori Baru
                    </span>
                    <h2 class="welcome-title">Tambah Kategori Obat</h2>
                    <p class="welcome-subtitle">Lengkapi form berikut untuk menambahkan kategori obat baru ke sistem.</p>
                </div>
                <div class="welcome-stats">
                    <a href="{{ route('admin.kategori.index') }}" class="stat-pill">
                        <i class="material-symbols-rounded">arrow_back</i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
            <div class="welcome-illustration">
                <div class="floating-icon icon-1"><i class="material-symbols-rounded">folder</i></div>
                <div class="floating-icon icon-2"><i class="material-symbols-rounded">add_box</i></div>
            </div>
        </div>
    </div>
</div>

{{-- Form Card --}}
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card pro-card">
            <div class="card-header pro-card-header">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="material-symbols-rounded">edit_note</i>
                    </div>
                    <div>
                        <h6 class="header-title">Form Kategori</h6>
                        <p class="header-subtitle">Isi data kategori obat</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon primary">
                                <i class="material-symbols-rounded">label</i>
                            </div>
                            <div>
                                <h6 class="section-title">Informasi Kategori</h6>
                                <p class="section-subtitle">Detail kategori yang akan dibuat</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">Nama Kategori <span class="required">*</span></label>
                                    <div class="input-modern">
                                        <i class="material-symbols-rounded input-icon">category</i>
                                        <input type="text" name="nama_kategori" id="nama_kategori" 
                                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                                               placeholder="Contoh: Obat Bebas, Obat Keras" 
                                               value="{{ old('nama_kategori') }}" required>
                                    </div>
                                    @error('nama_kategori')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.kategori.index') }}" class="btn-outline-pro">
                            <i class="material-symbols-rounded">close</i>
                            Batal
                        </a>
                        <button type="submit" class="btn-pro">
                            <i class="material-symbols-rounded">save</i>
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
:root {
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --primary: #8b5cf6;
    --secondary: #64748b;
}

.welcome-banner {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.welcome-content { position: relative; z-index: 2; }
.greeting-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; color: white; font-weight: 500; margin-bottom: 12px; }
.welcome-title { font-size: 1.75rem; font-weight: 700; color: white; margin: 0 0 8px; }
.welcome-subtitle { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0 0 16px; max-width: 500px; }
.welcome-stats { display: flex; gap: 10px; }
.stat-pill { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 8px; font-size: 0.8rem; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.stat-pill:hover { background: rgba(255,255,255,0.3); color: white; transform: translateY(-2px); }
.welcome-illustration { position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); display: flex; gap: 1rem; }
.floating-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite; }
.floating-icon i { color: white; font-size: 24px; }
.floating-icon.icon-2 { animation-delay: 0.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

.pro-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }
.pro-card-header { padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; }
.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; }
.header-icon i { color: white; font-size: 22px; }
.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }

.form-section { margin-bottom: 2rem; }
.section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px dashed #e2e8f0; }
.section-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.section-icon i { font-size: 20px; }
.section-icon.primary { background: rgba(139,92,246,0.12); }
.section-icon.primary i { color: var(--primary); }
.section-title { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin: 0; }
.section-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 0; }

.form-group-modern { margin-bottom: 1.25rem; }
.form-label-modern { display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.form-label-modern .required { color: var(--danger); }

.input-modern { position: relative; }
.input-modern .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--secondary); font-size: 20px; z-index: 2; }
.input-modern .form-control { padding-left: 46px; height: 48px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; transition: all 0.2s; }
.input-modern .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139,92,246,0.15); }

.form-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; }
.btn-pro { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-pro:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139,92,246,0.4); }
.btn-pro i { font-size: 18px; }
.btn-outline-pro { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: white; color: var(--secondary); font-size: 0.875rem; font-weight: 500; border-radius: 10px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s; }
.btn-outline-pro:hover { background: #f8fafc; color: #1e293b; }
.btn-outline-pro i { font-size: 18px; }

@media (max-width: 768px) {
    .welcome-banner { flex-direction: column; text-align: center; }
    .welcome-stats { justify-content: center; }
    .welcome-illustration { display: none; }
    .form-actions { flex-direction: column; }
    .form-actions button, .form-actions a { width: 100%; justify-content: center; }
}
</style>
@endpush
@endsection
