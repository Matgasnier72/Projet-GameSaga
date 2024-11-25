<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Genre;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

        // Recherche des articles en fonction du titre ou du contenu
        $posts = Article::query()
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