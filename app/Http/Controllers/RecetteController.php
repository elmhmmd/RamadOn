<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recette;
use App\Models\Category;

class RecetteController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $recettes = Recette::all();
        return view('recettes.index', compact('categories', 'recettes'));
    }
}
