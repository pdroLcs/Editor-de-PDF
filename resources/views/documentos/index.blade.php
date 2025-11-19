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
                            <a href="{{ route('documentos.preview', $doc) }}" class="btn btn-sm btn-outline-secondary">
                                Visualizar
                            </a>
                            <a href="{{ route('documentos.pdf', $doc) }}" class="btn btn-sm btn-outline-success">
                                PDF
                            </a>
                            <form action="{{ route('documentos.destroy', $doc) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Confirma excluir este documento?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
