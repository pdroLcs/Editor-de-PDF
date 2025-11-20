@extends('layouts.base')

@section('title', 'GhostWriter – Documentos ABNT')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">GhostWriter – Documentos ABNT</h1>
        <a href="{{ route('documentos.create') }}" class="btn btn-primary">
            Novo documento
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($documentos->isEmpty())
        <p>Não há documentos cadastrados ainda.</p>
    @else
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Criado em</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documentos as $doc)
                    <tr>
                        <td>{{ $doc->titulo }}</td>
                        <td>{{ $doc->tipo }}</td>
                        <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <x-action-button route="documentos.preview" :obj="$doc" style="secondary" text="Visualizar"/>
                            <x-action-button route="documentos.pdf" :obj="$doc" style="success" text="PDF"/>
                            <x-action-button route="documentos.destroy" :obj="$doc" style="danger" text="Excluir" method="DELETE"/>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
