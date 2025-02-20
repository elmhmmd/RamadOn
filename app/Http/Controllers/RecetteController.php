<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recette;
use App\Models\Category;
//use Illuminate\Support\Facades\Storage;

class RecetteController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $recettes = Recette::all();
        return view('recettes.index', compact('categories', 'recettes'));
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

    public function show($id)
{
    try {
        $recette = Recette::with('category')->findOrFail($id);
        return view('recettes.show', compact('recette'));
    } catch (\Exception $e) {
        abort(404, 'Recette not found');
    }
}

}

    /*public function update(Request $request, $id)
{
    $recette = Recette::findOrFail($id);
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($recette->image) {
            Storage::delete('public/images/' . $recette->image);
        }
        
        // Store new image
        $imagePath = $request->file('image')->store('public/images');
        $validated['image'] = basename($imagePath);
    }

    $recette->update($validated);

    return response()->json(['message' => 'Recipe updated successfully']);
}*/

