<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recette;

class RecetteController extends Controller
{
    public function index()
    {
        $recettes = Recette::all();
        return view('recettes.index', compact('recettes'));
    }
}
