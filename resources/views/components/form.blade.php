@props([
    'method' => 'POST',
    'action' => '#',
    'enctype' => null,
])

@php
    // Corrige o método HTTP
    $http = strtoupper($method);
    $spoofMethod = in_array($http, ['PUT', 'PATCH', 'DELETE']);
@endphp

<form 
    action="{{ $action }}" 
    method="{{ $spoofMethod ? 'POST' : $http }}" 
    {{ $enctype ? "enctype=$enctype" : '' }}
    {{ $attributes->merge(['class' => 'needs-validation']) }}
>
    @csrf

    @if($spoofMethod)
        @method($http)
    @endif

    {{-- Exibição global de erros --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erros encontrados:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Conteúdo do formulário --}}
    <div class="mb-3">
        {{ $slot }}
    </div>

    {{-- Slot opcional para botões --}}
    @isset($actions)
        <div class="mt-3">
            {{ $actions }}
        </div>
    @endisset
</form>
