@props(['title', 'subtitle' => '', 'icon' => 'dashboard'])

<div class="page-header min-height-200 border-radius-xl mt-4" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
    <span class="mask bg-gradient-primary opacity-6"></span>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 text-start">
                <div class="d-flex align-items-center">
                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-md me-3">
                        <i class="material-symbols-rounded opacity-10" style="color: #06b6d4; font-size: 2rem;">{{ $icon }}</i>
                    </div>
                    <div>
                        <h3 class="text-white mb-0">{{ $title }}</h3>
                        @if($subtitle)
                            <p class="text-white opacity-8 mb-0">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
