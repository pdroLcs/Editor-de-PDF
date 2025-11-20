@extends('layouts.base')

@section('title', 'Editar Documento')

@section('content')
    <x-card>
        <x-slot name="header">
            Editar Documento – {{ $documento->titulo }}
        </x-slot>

        {{-- Alertas --}}
        @if(session('success'))
            <x-alert tipo="success" :mensagem="session('success')" />
        @endif

        @if($errors->any())
            <x-alert tipo="danger" mensagem="Verifique os erros no formulário antes de continuar." />
        @endif

        <form method="POST" action="{{ route('documentos.update', $documento) }}">
            @csrf
            @method('PUT')

            {{-- Campo: Título --}}
            <x-input
                name="titulo"
                label="Título do documento"
                :value="old('titulo', $documento->titulo)"
                required="true"
                help="Este título será exibido no preview e no PDF."
            />

            {{-- Campo: Tipo --}}
            <x-select
                name="tipo"
                label="Tipo de documento"
                :options="$tiposDocumento"
                optionValue="id"
                optionLabel="nome"
                :value="old('tipo', $documento->tipo)"
                placeholder="Selecione o tipo"
            />

            <hr>

            <h2 class="h5 mb-3">Blocos de texto</h2>
            <p class="text-muted">
                Edite os blocos existentes ou adicione novos. Você pode remover blocos também.
            </p>

            <div id="blocos-container">

                {{-- Renderizando blocos existentes --}}
                @foreach(old('blocos', $documento->blocos->toArray()) as $i => $bloco)
                    <div class="card mb-3 bloco-item">
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label">Conteúdo</label>
                                <textarea
                                    name="blocos[{{ $i }}][conteudo]"
                                    class="form-control"
                                    rows="3"
                                    required
                                >{{ $bloco['conteudo'] }}</textarea>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Tipo de bloco</label>
                                <select name="blocos[{{ $i }}][tipo]" class="form-select" required>
                                    <option value="texto" {{ $bloco['tipo'] === 'texto' ? 'selected' : '' }}>
                                        Texto comum
                                    </option>
                                    <option value="citacao_curta" {{ $bloco['tipo'] === 'citacao_curta' ? 'selected' : '' }}>
                                        Citação direta curta (≤ 3 linhas)
                                    </option>
                                    <option value="citacao_longa" {{ $bloco['tipo'] === 'citacao_longa' ? 'selected' : '' }}>
                                        Citação direta longa (> 3 linhas)
                                    </option>
                                </select>
                            </div>

                            <x-button type="button" class="btn-danger btn-sm btn-remover-bloco">
                                Remover bloco
                            </x-button>
                        </div>
                    </div>
                @endforeach

            </div>

            <x-button type="button" class="btn-primary mb-3" id="btn-adicionar-bloco">
                Adicionar bloco
            </x-button>

            <div class="mt-3">
                <x-button type="submit" class="btn-success">
                    Salvar alterações
                </x-button>
            </div>
        </form>

        {{-- Template para novos blocos --}}
        <template id="template-bloco">
            <div class="card mb-3 bloco-item">
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label">Conteúdo</label>
                        <textarea class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Tipo de bloco</label>
                        <select class="form-select" required>
                            <option value="texto">Texto comum</option>
                            <option value="citacao_curta">Citação direta curta (≤ 3 linhas)</option>
                            <option value="citacao_longa">Citação direta longa (> 3 linhas)</option>
                        </select>
                    </div>

                    <x-button type="button" class="btn-danger btn-sm btn-remover-bloco">
                        Remover bloco
                    </x-button>
                </div>
            </div>
        </template>
    </x-card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('blocos-container');
            const template  = document.getElementById('template-bloco');
            const btnAdd    = document.getElementById('btn-adicionar-bloco');

            function atualizarIndices() {
                const blocos = container.querySelectorAll('.bloco-item');
                blocos.forEach((bloco, index) => {
                    const textarea = bloco.querySelector('textarea');
                    const select   = bloco.querySelector('select');

                    textarea.name = `blocos[${index}][conteudo]`;
                    select.name   = `blocos[${index}][tipo]`;
                });
            }

            btnAdd.addEventListener('click', function () {
                const clone = template.content.cloneNode(true);
                container.appendChild(clone);
                atualizarIndices();
            });

            container.addEventListener('click', function (event) {
                const btn = event.target.closest('.btn-remover-bloco');
                if (btn) {
                    const bloco = btn.closest('.bloco-item');
                    bloco.remove();
                    atualizarIndices();
                }
            });
        });
    </script>
@endsection
