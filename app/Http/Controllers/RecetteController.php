<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recette;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\Storage;

class RecetteController extends Controller
{
    public function index(Request $request, $category = null)
{
    $categories = Category::all();

    if ($request->wantsJson()) {
        \Log::info("Filtering recipes for category: " . ($category ?? 'all'));
        $query = Recette::with('category');
        if ($category && $category !== 'all') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->whereRaw('TRIM(LOWER(name)) = ?', [trim(strtolower($category))]);
            });
        }
        $recettes = $query->get();
        \Log::info("Found recipes: " . $recettes->count());
        return response()->json($recettes);
    }

    $recettes = $category && $category !== 'all'
        ? Recette::whereHas('category', function ($q) use ($category) {
            $q->whereRaw('TRIM(LOWER(name)) = ?', [trim(strtolower($category))]);
        })->get()
        : Recette::all();

    return view('recettes.index', compact('categories', 'recettes', 'category'));
}
    public function destroy($id)
    {
        try {
            $recette = Recette::find($id);

            $recette->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Recette supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $recette = Recette::with(['category', 'comments'])->findOrFail($id);

            if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'id' => $recette->id,
                    'name' => $recette->name,
                    'category_id' => $recette->category_id,
                    'content' => $recette->content,
                    'category' => [
                        'name' => $recette->category->name
                    ]
                ]);
            }

            return view('recettes.show', compact('recette'));
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Recette not found'], 404);
            }
            abort(404, 'Recette not found');
        }
    }


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'content' => 'required|string',
        'image' => 'nullable|image',
    ]);

    $recette = new Recette();
    $recette->name = $request->name;
    $recette->category_id = $request->category_id;
    $recette->content = $request->content;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('recettes', 'public');
        $recette->image = $imagePath;
    }

    $recette->save();

    return response()->json([
        'success' => true,
        'recette' => $recette
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'content' => 'required|string',
        'image' => 'nullable|image',
    ]);

    $recette = Recette::findOrFail($id);
    $recette->name = $request->name;
    $recette->category_id = $request->category_id;
    $recette->content = $request->content;

    if ($request->hasFile('image')) {
        // Optionally delete old image
        if ($recette->image && Storage::disk('public')->exists($recette->image)) {
            Storage::disk('public')->delete($recette->image);
        }
        $imagePath = $request->file('image')->store('recettes', 'public');
        $recette->image = $imagePath;
    }

    $recette->save();

    return response()->json([
        'success' => true,
        'recette' => $recette
    ]);
}

public function storeComment(Request $request, $id)
    {
        $request->validate([
            'auteur' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $recette = Recette::findOrFail($id);
        $comment = new Comment();
        $comment->auteur = $request->input('auteur');
        $comment->content = $request->input('content');
        $recette->comments()->save($comment);

        return redirect()->route('recettes.show', $id)->with('success', 'Commentaire ajouté avec succès');
    }


}


