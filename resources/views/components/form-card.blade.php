@props(['title' => 'Form', 'action', 'method' => 'POST', 'backUrl' => null])

<div class="card shadow-lg border-0">
    <div class="card-header bg-gradient-primary p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-white mb-0">{{ $title }}</h5>
            @if($backUrl)
                <a href="{{ $backUrl }}" class="btn btn-sm bg-white text-primary mb-0">
                    <i class="material-symbols-rounded text-sm me-1">arrow_back</i>
                    Kembali
                </a>
            @endif
        </div>
    </div>
    <div class="card-body p-4">
        <form action="{{ $action }}" method="POST" {{ $attributes }}>
            @csrf
            @if($method !== 'POST')
                @method($method)
            @endif
            
            {{ $slot }}
            
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn bg-gradient-primary mb-0">
                    <i class="material-symbols-rounded text-sm me-1">save</i>
                    Simpan
                </button>
                @if($backUrl)
                    <a href="{{ $backUrl }}" class="btn btn-outline-secondary mb-0">
                        Batal
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
