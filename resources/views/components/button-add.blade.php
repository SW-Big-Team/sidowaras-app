@props(['href', 'icon' => 'add', 'text' => 'Tambah Data', 'variant' => 'primary'])

@php
    $variantClasses = [
        'primary' => 'bg-gradient-primary',
        'success' => 'bg-gradient-success',
        'warning' => 'bg-gradient-warning',
        'danger' => 'bg-gradient-danger',
        'info' => 'bg-gradient-info',
    ];
    $class = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<a href="{{ $href }}" class="btn {{ $class }} mb-0">
    <i class="material-symbols-rounded text-sm me-1">{{ $icon }}</i>
    {{ $text }}
</a>
