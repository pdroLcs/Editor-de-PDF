@props([
  'name',
  'label',
  'type' => 'text',
  'value' => '',
  'help' => null,
  'required' => false,
  'step' => null,     //para inputs numéricos ou de data/hora
])

<div class="mb-3">
  <label for="{{ $name }}" class="form-label">{{ $label }}</label>
  <input  type="{{ $type }}" 
          name="{{ $name }}" 
          id="{{ $name }}"
          value="{{ old($name, $value) }}"
          @required($required)
          @if(!is_null($step)) step="{{ $step }}" @endif
          {{ $attributes->merge(['class' => 'form-control']) }}>
  
  @if($help)
    <div class="form-text">{{ $help }}</div>
  @endif
  
  @error($name) 
    <div class="text-danger small">{{ $message }}</div> 
  @enderror
</div>
