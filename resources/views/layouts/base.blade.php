<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    {{-- Definição do title --}}
    <title>@yield('title', $pageTitle ?? 'Projeto PDFEditor')</title>
    
    {{-- Link do Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Link para estilos específicos da aplicação --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Link para ícones do Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Estilos específicos das views --}}
    @stack('styles')
</head>
<body>
    {{-- Inclusão da barra do menu de navegação --}}
    @include('layouts.menu')

    <div class="container mt-4">
        {{-- Inclusão do conteúdo principal --}}
        @yield('content')

    </div>
    {{-- Inclusão do rodapé --}}
    @include('layouts.footer')

    {{-- Link para o JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>