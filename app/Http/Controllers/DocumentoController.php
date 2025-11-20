<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentoRequest;
use App\Models\BlocoTexto;
use App\Models\Documento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentos = Documento::latest()->get();
        return view('documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposDocumento = [
            ['id' => 'artigo', 'nome' => 'Artigo'],
            ['id' => 'tcc', 'nome' => 'TCC'],
            ['id' => 'relatorio', 'nome' => 'Relatório'],
        ];
        return view('documentos.create', compact('tiposDocumento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentoRequest $request)
    {
        $dados = $request->validated();

        $documento = Documento::create([
            'titulo' => $dados['titulo'],
            'tipo' => $dados['tipo'] ?? 'artigo'
        ]);

        foreach ($dados['blocos'] as $ordem => $bloco) {
            BlocoTexto::create([
                'documento_id' => $documento->id,
                'ordem' => $ordem,
                'tipo' => $bloco['tipo'],
                'conteudo' => $bloco['conteudo']
            ]);
        }

        return redirect()->route('documentos.preview', $documento)->with('success', 'Documento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento)
    {
        return redirect()->route('documentos.preview', $documento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //TODO: Implementar formulário de edição de documento
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //TODO: Implementar atualização do documento
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        $documento->delete();
        return redirect()->route('documentos.preview')->with('success', 'Documento excluído com sucesso!');
    }

    //Preview HTML com formatação ABNT
    public function preview(Documento $documento) 
    {
        $documento->load('blocos');
        $paragrafos = $this->montarParagrafos($documento->blocos);
        return view('documentos.preview', compact('documento', 'paragrafos'));
    }

    //Download em PDF
    public function pdf(Documento $documento) 
    {
        $documento->load('blocos');
        $paragrafos = $this->montarParagrafos($documento->blocos);
        $pdf = Pdf::loadView('documentos.preview_pdf', compact('documento', 'paragrafos'))->setPaper('a4', 'portrait');
        $filename = str()->slug($documento->titulo) . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Monta uma lista de parágrafos a partir dos blocos.
     * - texto: abre / atualiza parágrafo em construção
     * - citacao_curta: concatena ao parágrafo anterior, com espaço e aspas
     * - citacao_longa: vira parágrafo próprio, com classe específica
     */
    protected function montarParagrafos(Collection $blocos)
    {
        $paragrafos = [];
        $paragrafoAtual = null;

        foreach ($blocos as $bloco) {
            $conteudo = $bloco->conteudo;

            match ($bloco->tipo) {
                'texto' => $this->abriNovoParagrafo($paragrafos, $paragrafoAtual, $conteudo),
                'citacao_curta' => $this->adicionarCitacaoCurta($paragrafos, $paragrafoAtual, $conteudo),
                'citacao_longa' => $this->adicionarCitacaoLonga($paragrafos, $paragrafoAtual, $conteudo)
            };
        }
        if (!is_null($paragrafoAtual)) {
            $paragrafos[] = [
                'tipo' => 'texto',
                'conteudo' => $paragrafoAtual
            ];
        }
        return $paragrafos;
    }

    protected function abriNovoParagrafo(array &$paragrafos, ?string &$paragrafoAtual, string $conteudo)
    {
        if (!is_null($paragrafoAtual)) {
            $paragrafos[] = [
                'tipo' => 'texto',
                'conteudo' => $paragrafoAtual
            ];
        }
        $paragrafoAtual = $conteudo;
    }

    protected function adicionarCitacaoCurta(array &$paragrafos, ?string &$paragrafoAtual, string $conteudo)
    {
        if (!is_null($paragrafoAtual)) {
            $paragrafoAtual .= ' "' . $conteudo . '"';
        } else {
            $paragrafos[] = [
                'tipo' => 'texto',
                'conteudo' => '"' . $conteudo . '"'
            ];
        }
    }

    protected function adicionarCitacaoLonga(array &$paragrafos, ?string &$paragrafoAtual, string $conteudo)
    {
        if (!is_null($paragrafoAtual)) {
            $paragrafos[] = [
                'tipo' => 'texto',
                'conteudo' => $paragrafoAtual
            ];
            $paragrafoAtual = null;
        }
        $paragrafos[] = [
            'tipo' => 'citacao_longa',
            'conteudo' => $conteudo
        ];
    }
}
