@auth
<div class="text-secondary flex items-center space-x-4 ms-auto ">
    <span>
        Olá, <strong>{{ Auth::user()->name }}</strong>
        @if(Auth::user()->role)
            <span class="text-xs">({{ Auth::user()->role }})</span>
        @endif
    </span>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="btn btn-danger">
            Sair
        </button>
    </form>
</div>
@endauth

@guest
<div class="flex items-center space-x-4 ms-auto">
    <a href="{{ route('login') }}" class="btn btn-success">Entrar</a>
    <a href="{{ route('register') }}" class="btn btn-primary">Registrar</a>
</div>
@endguest
