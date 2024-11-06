<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::all();

        // On retourne les informations des utilisateurs en format JSON
        return response()->json($article);
    }
    public function store(Request $request)
    {
        $validation = $request->validate([
            'titre' => 'bail|required|string|max:255',
            'contenu' => 'bail|required|string',
            'note_auteur' => 'bail|required|int'
        ]);
        $article = new Article();
        $article->fill($validation);
        $article->user_id = Auth::user()->id;
        $article->save();
        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $article,
        ]);
    }
    public function show(Article $article)
    {
        return response()->json($article);
    }
    public function update(Article $article, Request $request)
    {
        $validation = $request->validate([
            'titre' => 'bail|string',
            'contenu' => 'bail|string',
            'note_auteur' => 'bail|int',
        ]);

        $article->fill($validation);
        $article->save();
        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $article,
        ]);
    }
    public function destroy(Article $article)
    {
        $article->delete();

        // On retourne la réponse au format JSON
        return response()->json([
            'status' => "Suppression effectuée avec succès !"
        ]);
    }
}
