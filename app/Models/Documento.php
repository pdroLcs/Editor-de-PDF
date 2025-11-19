<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = ['titulo', 'tipo'];

    public function blocos() {
        return $this->hasMany(BlocoTexto::class)->orderBy('ordem');
    }
}
