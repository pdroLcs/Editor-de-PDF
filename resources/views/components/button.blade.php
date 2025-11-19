@props(['type' => 'button', 'style' => 'primary'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-$style"]) }}>
  {{ $slot }}
</button>
