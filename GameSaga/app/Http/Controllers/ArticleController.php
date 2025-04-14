<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::with('author')->get();

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
        return response()->json($article::with('author')->first());
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
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

        // Recherche des articles en fonction du titre ou du contenu
        $posts = Article::query()->with('author')
            ->where('titre', 'like', "%{$key}%")
            ->orderBy('created_at', 'desc')
            ->get();/* 

        // Récupérer tous les genres
        $tags = Genre::all();

        // Récupérer les 5 derniers articles avec un statut "ok"
        $recent_posts = Article::query()
            ->where('status', 'ok')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get(); */

        // Retourner les données sous forme de réponse JSON
        return response()->json([
            'success' => true,
            'data' => [
                'key' => $key,
                'posts' => $posts/* ,
                'tags' => $tags,
                'recent_posts' => $recent_posts */
            ]
        ]);
    }
}
