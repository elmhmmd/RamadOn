<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\TemoignagesController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/recettes', [RecetteController::class, 'index'])->name('recettes.index');

Route::get('/temoignages', [TemoignagesController::class, 'index'])->name('temoignages.index');

Route::get('/recettes/{id}', [RecetteController::class, 'show'])->name('recettes.show');

Route::delete('/recettes/{id}', [RecetteController::class, 'destroy'])->name('recettes.destroy');

Route::post('/recettes', [RecetteController::class, 'store'])->name('recettes.store');

Route::post('/recettes/{id}', [RecetteController::class, 'update'])->name('recettes.update');

Route::post('/recettes/{id}/comments', [RecetteController::class, 'storeComment'])->name('recettes.comments.store');


Route::get('/temoignages/{id}', [TemoignagesController::class, 'show'])->name('temoignages.show');
Route::post('/temoignages', [TemoignagesController::class, 'store'])->name('temoignages.store');
Route::post('/temoignages/{id}', [TemoignagesController::class, 'update'])->name('temoignages.update');
Route::delete('/temoignages/{id}', [TemoignagesController::class, 'destroy'])->name('temoignages.destroy');
Route::post('/temoignages/{id}/comments', [TemoignagesController::class, 'storeComment'])->name('temoignages.comments.store');



