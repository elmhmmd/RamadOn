<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetteController;


Route::get('/', function () {
    return view('Homepage');
});

Route::get('/recettes', [RecetteController::class, 'index'])->name('recettes.index');

Route::get('/temoignages', [TemoignagesController::class, 'index'])->name('temoignages.index');

Route::delete('/recettes/{recette}', [RecetteController::class, 'destroy'])->name('recettes.destroy');

Route::get('/recettes/{id}', [RecetteController::class, 'show'])->name('recettes.show');



