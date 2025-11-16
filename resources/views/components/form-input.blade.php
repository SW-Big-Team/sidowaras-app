@props(['label', 'name', 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false])

<div class="input-group input-group-outline mb-3 {{ old($name, $value) ? 'is-filled' : '' }}">
    <label class="form-label">{{ $label }}{{ $required ? ' *' : '' }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        class="form-control @error($name) is-invalid @enderror" 
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
