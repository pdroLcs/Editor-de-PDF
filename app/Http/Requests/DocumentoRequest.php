<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:50',
            'blocos' => 'required|array|min:1',
            'blocos.*.conteudo' => 'required|string',
            'blocos.*.tipo' => 'required|in:texto,citacao_curta,citacao_longa'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'blocos.required' => 'É necessário pelo menos um bloco.',
            'blocos.*.conteudo.required' => 'Cada bloco precisa ter algum conteúdo.',
            'blocos.*.tipo;required' => 'Informe o tipo de todos os blocos.'
        ];
    }
}
