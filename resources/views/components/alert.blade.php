@props(['tipo' => 'info', 'mensagem' => null])

@if($mensagem)
<div class="alert alert-{{ $tipo }} alert-dismissible fade show" role="alert">
    {{ $mensagem }}
    <x-button type="button" data-bs-dismiss="alert" aria-label="Fechar">Fechar</x-button>
</div>
@endif
