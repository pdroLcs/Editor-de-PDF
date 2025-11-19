<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $documento->titulo }} – GhostWriter</title>
    <style>
        /* Margens da página no PDF (ABNT) */
        @page {
            margin-top: 3cm;
            margin-left: 3cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /* CSS ABNT compartilhado */
        {!! file_get_contents(public_path('css/abnt.css')) !!}
    </style>
</head>
<body>
    <div class="abnt-documento">
        @foreach($documento->blocos as $bloco)
            @if($bloco->tipo === 'texto')
                <p class="abnt-paragrafo">{{ $bloco->conteudo }}</p>
            @elseif($bloco->tipo === 'citacao_curta')
                <p class="abnt-paragrafo">
                    &ldquo;{{ $bloco->conteudo }}&rdquo;
                </p>
            @elseif($bloco->tipo === 'citacao_longa')
                <p class="abnt-citacao-longa">
                    {{ $bloco->conteudo }}
                </p>
            @endif
        @endforeach
    </div>
</body>
</html>
