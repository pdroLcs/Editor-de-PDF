@props([
'label', 
'name', 
'rows' => 3, 
'value' => '', 
'help' => null
])

<div class="mb-3">
  <label for="{{ $name }}" class="form-label">{{ $label }}</label>
  <textarea
      name="{{ $name }}"
      id="{{ $name }}"
      rows="{{ $rows }}"
      {{ $attributes->merge(['class' => 'form-control']) }}
  >{{ old($name, $value) }}</textarea>

  @if($help)
    <div class="form-text">{{ $help }}</div>
  @endif

  @error($name)
    <div class="text-danger small">{{ $message }}</div>
  @enderror
</div>
