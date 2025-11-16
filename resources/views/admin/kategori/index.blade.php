@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Daftar Kategori Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Kategori Obat</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
        <x-content-header title="Daftar Kategori Obat" subtitle="Kelola kategori dan klasifikasi obat">
        <button type="button" 
                class="btn bg-gradient-primary mb-0" 
                data-bs-toggle="modal" 
                data-bs-target="#kategoriModal" 
                data-mode="create">
            <i class="material-symbols-rounded text-sm">add_circle</i>
            <span class="ms-1">Tambah Kategori</span>
        </button>
    </x-content-header>

    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="material-symbols-rounded">check_circle</i></span>
                    <span class="alert-text">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <x-data-table :headers="['#', 'Nama Kategori', 'Deskripsi', 'Dibuat', 'Aksi']">
                @forelse ($kategori as $item)
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{ $kategori->firstItem() + $loop->index }}</p>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $item->nama_kategori }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $item->deskripsi ?? '-' }}</p>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $item->created_at->format('d M Y') }}</p>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button"
                                    class="btn btn-link text-warning px-3 mb-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#kategoriModal"
                                    data-mode="edit"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama_kategori }}"
                                    title="Edit">
                                    <i class="material-symbols-rounded text-sm">edit</i>
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $item->nama_kategori }}?')">
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
                        <td colspan="5" class="text-center py-4">
                            <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">inventory_2</i>
                            <p class="text-secondary mb-0">Belum ada data kategori</p>
                        </td>
                    </tr>
                @endforelse
            </x-data-table>

            <div class="mt-3">
                {{ $kategori->links() }}
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Kategori -->
    <div class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="kategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="kategoriModalLabel">
                        <i class="material-symbols-rounded me-2">category</i>
                        Tambah Kategori
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kategoriForm" method="POST" action="{{ route('admin.kategori.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="kategoriFormMethod" value="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Nama Kategori <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" 
                                       class="form-control" 
                                       name="nama_kategori" 
                                       id="nama_kategori" 
                                       placeholder="Masukkan nama kategori" 
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">
                            <i class="material-symbols-rounded me-1">close</i> Batal
                        </button>
                        <button type="submit" class="btn bg-gradient-primary mb-0" id="kategoriSubmitBtn">
                            <i class="material-symbols-rounded me-1">save</i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function() {
        const modalEl = document.getElementById('kategoriModal');
        if (!modalEl) return;
        
        modalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const mode = button?.getAttribute('data-mode') || 'create';
            const form = document.getElementById('kategoriForm');
            const methodInput = document.getElementById('kategoriFormMethod');
            const titleEl = document.getElementById('kategoriModalLabel');
            const submitBtn = document.getElementById('kategoriSubmitBtn');
            const namaInput = document.getElementById('nama_kategori');

            if (mode === 'edit') {
                const id = button.getAttribute('data-id');
                form.action = "{{ url('adminx/kategori') }}/" + id;
                methodInput.value = 'PUT';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2">category</i> Edit Kategori';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">update</i> Update';
                namaInput.value = button.getAttribute('data-nama') || '';
            } else {
                form.action = "{{ route('admin.kategori.store') }}";
                methodInput.value = 'POST';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2">category</i> Tambah Kategori';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">save</i> Simpan';
                namaInput.value = '';
            }
        });
    })();
    </script>
    @endpush
</div>
@endsection
