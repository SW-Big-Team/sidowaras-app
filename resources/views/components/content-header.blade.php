@props(['title', 'subtitle' => ''])

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 font-weight-bold text-dark">{{ $title }}</h4>
                        @if($subtitle)
                            <p class="text-sm text-secondary mb-0 mt-1">{{ $subtitle }}</p>
                        @endif
                    </div>
                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
