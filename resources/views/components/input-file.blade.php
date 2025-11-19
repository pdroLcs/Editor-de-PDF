@props(['label', 'name', 'preview' => null, 'type' => 'default'])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="file" name="{{ $name }}" class="form-control" id="{{ $name }}">
    
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror

    @if($preview)
        <div class="mt-2">
            @if($type === 'image')
                <img src="{{ asset('storage/'.$preview) }}" width="150" class="img-thumbnail">
            @elseif($type === 'audio')
                <audio controls>
                    <source src="{{ asset('storage/'.$preview) }}" type="audio/mpeg">
                </audio>
            @else
                <a href="{{ asset('storage/'.$preview) }}" target="_blank">📄 Ver arquivo</a>
            @endif
        </div>
    @endif
</div>
