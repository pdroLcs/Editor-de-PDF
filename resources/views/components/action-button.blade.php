@props(['route' => null, 'obj' => null, 'type' => 'submit', 'style' => 'primary', 'text' => null, 'method' => 'GET'])

@if ($route && in_array($method, ['DELETE', 'POST', 'PUT']))
    <form action="{{ route($route, $obj) }}" method="POST" class="d-inline">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <button type="submit" class="btn btn-sm btn-outline-{{ $style }}" 
            @if ($method === 'DELETE') onclick="return confirm('Tem certeza de que deseja excluir?')" @endif>
            {{ $text }}
        </button>
    </form>

@elseif($route)
    <a href="{{ route($route, $obj) }}" class="btn btn-sm btn-outline-{{ $style }}">
        {{ $text }}
    </a>
@endif