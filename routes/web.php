<?php

use App\Http\Controllers\DocumentoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('documentos.index');
});

Route::resource('documentos', DocumentoController::class);

// Rotas extras
Route::get('documentos/{documento}/preview', [DocumentoController::class, 'preview'])
    ->name('documentos.preview');

Route::get('documentos/{documento}/pdf', [DocumentoController::class, 'pdf'])
    ->name('documentos.pdf');
