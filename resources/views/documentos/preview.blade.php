@extends('layouts.base')

@section('title', $documento->titulo . ' – Preview ABNT')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/abnt.css') }}">
@endpush

@section('content')
    <x-card>
        <x-slot name="header">
            Preview ABNT – {{ $documento->titulo }}
        </x-slot>

        @if(session('success'))
            <x-alert tipo="success" :mensagem="session('success')" />
        @endif

        <div class="mb-3 d-flex justify-content-between">
            <a href="{{ route('documentos.index') }}" class="btn btn-outline-secondary btn-sm">
                Voltar
            </a>
            <a href="{{ route('documentos.pdf', $documento) }}" class="btn btn-outline-success btn-sm">
                Baixar PDF
            </a>
        </div>

        {{-- Aqui o “papel A4” do preview --}}
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
    </x-card>
@endsection
