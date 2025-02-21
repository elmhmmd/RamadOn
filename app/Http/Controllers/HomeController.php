<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recette;
use App\Models\Temoignage;

class HomeController extends Controller
{
    public function index()
    {
        // Total counts
        $recettesCount = Recette::count();
        $temoignagesCount = Temoignage::count();

        // Most popular (by comment count)
        $popularRecette = Recette::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->first();

        $popularTemoignage = Temoignage::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->first();

        return view('Homepage', [
            'recettesCount' => $recettesCount,
            'temoignagesCount' => $temoignagesCount,
            'popularRecette' => $popularRecette ? $popularRecette->name : 'Aucune recette',
            'popularTemoignage' => $popularTemoignage ? $popularTemoignage->title : 'Aucun témoignage',
        ]);
    }
}