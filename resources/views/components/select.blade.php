@props([
  'label',
  'name',
  'options' => [],
  'optionValue' => 'id',
  'optionLabel' => 'nome',
  'value' => null,
  'placeholder' => 'Selecione...',
])

<div class="mb-3">
  <label for="{{ $name }}" class="form-label">{{ $label }}</label>
  <select
      name="{{ $name }}"
      id="{{ $name }}"
      {{ $attributes->merge(['class' => 'form-select']) }}
  >
    @if($placeholder)
      <option value="">{{ $placeholder }}</option>
    @endif

    @foreach($options as $option)
        @php
            $val = is_array($option) ? $option[$optionValue] : $option->{$optionValue};
            $lab = is_array($option) ? $option[$optionLabel] : $option->{$optionLabel};
        @endphp
        <option value="{{ $val }}" @selected(old($name, $value) == $val)>
            {{ $lab }}
        </option>
    @endforeach
  </select>

  @error($name)
    <div class="text-danger small">{{ $message }}</div>
  @enderror
</div>
