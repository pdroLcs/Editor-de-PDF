<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlocoTexto extends Model
{
    protected $table = 'blocos_texto';
    protected $fillable = ['documento_id', 'ordem', 'tipo', 'conteudo'];

    public function documento() {
        return $this->belongsTo(Documento::class);
    }
}
