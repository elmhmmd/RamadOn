<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetteController;


Route::get('/', function () {
    return view('Homepage');
});

Route::get('/recettes', [RecetteController::class, 'index'])->name('recettes.index');

Route::get('/temoignages', [TemoignagesController::class, 'index'])->name('temoignages.index');

Route::get('/recettes/{id}', [RecetteController::class, 'show'])->name('recettes.show');

Route::delete('/recettes/{id}', [RecetteController::class, 'destroy'])->name('recettes.destroy');

Route::post('/recettes', [RecetteController::class, 'store'])->name('recettes.store');

Route::post('/recettes/{id}', [RecetteController::class, 'update'])->name('recettes.update');

Route::post('/recettes/{id}/comments', [RecetteController::class, 'storeComment'])->name('recettes.comments.store');



