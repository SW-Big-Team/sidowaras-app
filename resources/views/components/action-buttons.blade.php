@props(['editUrl' => '#', 'deleteUrl' => '#', 'deleteMessage' => 'Yakin ingin menghapus data ini?', 'viewUrl' => null])

<div class="d-flex gap-2">
    @if($viewUrl)
        <a href="{{ $viewUrl }}" class="btn btn-link text-info px-3 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
            <i class="material-symbols-rounded text-sm">visibility</i>
        </a>
    @endif
    
    <a href="{{ $editUrl }}" class="btn btn-link text-warning px-3 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
        <i class="material-symbols-rounded text-sm">edit</i>
    </a>
    
    <form action="{{ $deleteUrl }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $deleteMessage }}')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-link text-danger px-3 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
            <i class="material-symbols-rounded text-sm">delete</i>
        </button>
    </form>
</div>
