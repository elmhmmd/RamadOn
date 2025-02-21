<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Temoignage;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class TemoignagesController extends Controller
{
    public function index()
    {
        $temoignages = Temoignage::all();
        return view('temoignages.index', compact('temoignages'));
    }

    public function show(Request $request, $id) // Changed from Temoignage $temoignage for consistency
    {
        try {
            $temoignage = Temoignage::with('comments')->findOrFail($id);

            if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'id' => $temoignage->id,
                    'auteur' => $temoignage->auteur,
                    'title' => $temoignage->title,
                    'content' => $temoignage->content,
                ]);
            }

            return view('temoignages.show', compact('temoignage'));
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Témoignage not found'], 404);
            }
            abort(404, 'Témoignage not found');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'auteur' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $temoignage = new Temoignage();
        $temoignage->auteur = $request->auteur;
        $temoignage->title = $request->title;
        $temoignage->content = $request->content;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('temoignages', 'public');
            $temoignage->image = $imagePath;
        }

        $temoignage->save();

        return response()->json([
            'success' => true,
            'temoignage' => $temoignage
        ]);
    }

    public function update(Request $request, $id) // Changed from Temoignage $temoignage
    {
        $request->validate([
            'auteur' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $temoignage = Temoignage::findOrFail($id);
        $temoignage->auteur = $request->auteur;
        $temoignage->title = $request->title;
        $temoignage->content = $request->content;

        if ($request->hasFile('image')) {
            if ($temoignage->image && Storage::disk('public')->exists($temoignage->image)) {
                Storage::disk('public')->delete($temoignage->image);
            }
            $imagePath = $request->file('image')->store('temoignages', 'public');
            $temoignage->image = $imagePath;
        }

        $temoignage->save();

        return response()->json([
            'success' => true,
            'temoignage' => $temoignage
        ]);
    }

    public function destroy($id) // Changed from Temoignage $temoignage
    {
        try {
            $temoignage = Temoignage::findOrFail($id);
            if ($temoignage->image && Storage::disk('public')->exists($temoignage->image)) {
                Storage::disk('public')->delete($temoignage->image);
            }
            $temoignage->delete();
            return response()->json([
                'success' => true,
                'message' => 'Témoignage supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'auteur' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $temoignage = Temoignage::findOrFail($id);
        $comment = new Comment();
        $comment->auteur = $request->input('auteur');
        $comment->content = $request->input('content');
        $temoignage->comments()->save($comment);

        return redirect()->route('temoignages.show', $id)->with('success', 'Commentaire ajouté avec succès');
    }
}