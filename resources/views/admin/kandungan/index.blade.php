@php
    $role = Auth::user()->role->nama_role; 
    $layoutPath = 'layouts.' . strtolower($role) . '.app';
@endphp

@extends($layoutPath)
@section('title','Daftar Kandungan Obat')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manajemen Obat</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Kandungan Obat</li>
</ol>
@endsection

@section('content')
<div class="container-fluid py-4">
    <x-content-header title="Daftar Kandungan Obat" subtitle="Kelola kandungan aktif dan dosis obat">
        <button type="button" 
                class="btn bg-gradient-primary mb-0" 
                data-bs-toggle="modal" 
                data-bs-target="#kandunganModal" 
                data-mode="create">
            <i class="material-symbols-rounded text-sm">add_circle</i>
            <span class="ms-1">Tambah Kandungan</span>
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

            <x-data-table :headers="['#', 'Nama Kandungan', 'Dosis', 'Dibuat']">
                @forelse ($data as $item)
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{ $data->firstItem() + $loop->index }}</p>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $item->nama_kandungan_text }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-sm bg-gradient-success">{{ $item->dosis_kandungan }}</span>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $item->created_at->format('d M Y') }}</p>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
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
                        <td colspan="5" class="text-center py-4">
                            <i class="material-symbols-rounded text-secondary" style="font-size: 3rem;">science</i>
                            <p class="text-secondary mb-0">Belum ada data kandungan obat</p>
                        </td>
                    </tr>
                @endforelse
            </x-data-table>

            <div class="mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Kandungan -->
    <div class="modal fade" id="kandunganModal" tabindex="-1" aria-labelledby="kandunganModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="kandunganModalLabel">
                        <i class="material-symbols-rounded me-2">science</i>
                        Tambah Kandungan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kandunganForm" method="POST" action="{{ route('admin.kandungan.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="kandunganFormMethod" value="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Nama Kandungan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" 
                                       class="form-control" 
                                       name="nama_kandungan" 
                                       id="nama_kandungan" 
                                       placeholder="Contoh: Paracetamol, Ibuprofen" 
                                       required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Dosis Kandungan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-outline">
                                <input type="text" 
                                       class="form-control" 
                                       name="dosis_kandungan" 
                                       id="dosis_kandungan" 
                                       placeholder="Contoh: 500mg, 100ml" 
                                       required>
                            </div>
                            <small class="text-muted">Masukkan dosis/takaran kandungan (misal: 500mg, 10ml)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">
                            <i class="material-symbols-rounded me-1">close</i> Batal
                        </button>
                        <button type="submit" class="btn bg-gradient-primary mb-0" id="kandunganSubmitBtn">
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
        const modalEl = document.getElementById('kandunganModal');
        if (!modalEl) return;
        
        modalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const mode = button?.getAttribute('data-mode') || 'create';
            const form = document.getElementById('kandunganForm');
            const methodInput = document.getElementById('kandunganFormMethod');
            const titleEl = document.getElementById('kandunganModalLabel');
            const submitBtn = document.getElementById('kandunganSubmitBtn');
            const namaInput = document.getElementById('nama_kandungan');
            const dosisInput = document.getElementById('dosis_kandungan');

            if (mode === 'edit') {
                const id = button.getAttribute('data-id');
                form.action = "{{ url('adminx/kandungan') }}/" + id;
                methodInput.value = 'PUT';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2">science</i> Edit Kandungan';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">update</i> Update';
                namaInput.value = button.getAttribute('data-nama') || '';
                dosisInput.value = button.getAttribute('data-dosis') || '';
            } else {
                form.action = "{{ route('admin.kandungan.store') }}";
                methodInput.value = 'POST';
                titleEl.innerHTML = '<i class="material-symbols-rounded me-2">science</i> Tambah Kandungan';
                submitBtn.innerHTML = '<i class="material-symbols-rounded me-1">save</i> Simpan';
                namaInput.value = '';
                dosisInput.value = '';
            }
        });
    })();
    </script>
    @endpush
</div>
@endsection
