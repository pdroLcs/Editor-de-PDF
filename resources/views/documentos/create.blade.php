@extends('layouts.base')

@section('title', 'Novo Documento')

@section('content')
    <x-card>
        <x-slot name="header">
            Novo Documento ABNT – GhostWriter
        </x-slot>

        {{-- Alertas de sucesso/erro --}}
        @if(session('success'))
            <x-alert tipo="success" :mensagem="session('success')" />
        @endif

        @if($errors->any())
            <x-alert tipo="danger" mensagem="Verifique os erros no formulário antes de continuar." />
        @endif

        <form method="POST" action="{{ route('documentos.store') }}">
            @csrf

            {{-- Campo: Título --}}
            <x-input
                name="titulo"
                label="Título do documento"
                :value="old('titulo')"
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
                :value="old('tipo', 'artigo')"
                placeholder="Selecione o tipo"
            />

            <hr>

            <h2 class="h5 mb-3">Blocos de texto</h2>
            <p class="text-muted">
                Cada bloco representa um parágrafo ou uma citação. Você poderá marcar se é texto comum,
                citação direta curta (até três linhas) ou citação direta longa (mais de três linhas).
            </p>

            <div id="blocos-container">
                {{-- Bloco inicial --}}
                <div class="card mb-3 bloco-item">
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label">Conteúdo</label>
                            <textarea
                                name="blocos[0][conteudo]"
                                class="form-control"
                                rows="3"
                                required
                            >{{ old('blocos.0.conteudo') }}</textarea>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Tipo de bloco</label>
                            <select name="blocos[0][tipo]" class="form-select" required>
                                <option value="texto" {{ old('blocos.0.tipo') === 'texto' ? 'selected' : '' }}>
                                    Texto comum
                                </option>
                                <option value="citacao_curta" {{ old('blocos.0.tipo') === 'citacao_curta' ? 'selected' : '' }}>
                                    Citação direta curta (≤ 3 linhas)
                                </option>
                                <option value="citacao_longa" {{ old('blocos.0.tipo') === 'citacao_longa' ? 'selected' : '' }}>
                                    Citação direta longa (&gt; 3 linhas)
                                </option>
                            </select>
                        </div>

                        <x-button type="button" class="btn-danger btn-sm btn-remover-bloco">
                            Remover bloco
                        </x-button>
                    </div>
                </div>
            </div>

            <x-button type="button" class="btn-primary mb-3" id="btn-adicionar-bloco">
                Adicionar bloco
            </x-button>

            <div class="mt-3">
                <x-button type="submit" class="btn-success">
                    Salvar e visualizar
                </x-button>
            </div>
        </form>

        {{-- Template para novos blocos (clonado via JS) --}}
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
                            <option value="citacao_longa">Citação direta longa (&gt; 3 linhas)</option>
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
        // Script para gerenciar os blocos do GhostWriter (adicionar/remover)
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('blocos-container');
            const template  = document.getElementById('template-bloco');
            const btnAdd    = document.getElementById('btn-adicionar-bloco');

            // Atualiza os índices dos blocos para manter o padrão blocos[0], blocos[1], ...
            function atualizarIndices() {
                const blocos = container.querySelectorAll('.bloco-item');
                blocos.forEach((bloco, index) => {
                    const textarea = bloco.querySelector('textarea');
                    const select   = bloco.querySelector('select');

                    textarea.name = `blocos[${index}][conteudo]`;
                    select.name   = `blocos[${index}][tipo]`;
                });
            }

            // Adiciona um novo bloco com base no template
            btnAdd.addEventListener('click', function () {
                const clone = template.content.cloneNode(true);
                container.appendChild(clone);
                atualizarIndices();
            });

            // Remove um bloco quando o botão correspondente é clicado
            container.addEventListener('click', function (event) {
                const botaoRemover = event.target.closest('.btn-remover-bloco');
                if (botaoRemover) {
                    const bloco = botaoRemover.closest('.bloco-item');
                    bloco.remove();
                    atualizarIndices();
                }
            });
        });
    </script>
@endsection
