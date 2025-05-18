<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Genre;
use App\Models\Article;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit');
        $orderBy = $request->query('orderBy', 'created_at');
        $order = $request->query('order', 'desc');


        $query = Article::with('author');

        $order = in_array(strtolower($order), ['asc', 'desc']) ? $order : 'desc';

        $allowedFields = ['created_at', 'titre', 'note_auteur'];
        $orderBy = in_array($orderBy, $allowedFields) ? $orderBy : 'created_at';

        $query->orderBy($orderBy, $order);

        if ($limit) {
            $query->limit($limit);
        }

        $articles = $query->get();
        return response()->json($articles);
    }
    public function store(Request $request)
    {
        $validation = $request->validate([
            'titre' => 'bail|required|string|max:255',
            'image_blob' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contenu' => 'bail|required|string',
            'note_auteur' => 'bail|required|int'
        ]);
        $article = new Article();

        if (isset($request->image_blob)) {
            $fileName = time() . '_'  . $request->image_blob->getClientOriginalName();
            $article->image = $fileName;
            $request->image_blob->move(public_path('images/uploads'), $fileName);
        }

        $article->fill($validation);
        $article->user_id = Auth::user()->id;
        $article->save();
        return response()->json([
            'status' => 'Success',
            'data' => $article,
        ]);
    }
    public function show(Article $article)
    {
        return response()->json(Article::with('author')->find($article->id));
    }
    public function update(Article $article, Request $request)
    {
        $validation = $request->validate([
            'titre' => 'bail|string',
            'contenu' => 'bail|string',
            'note_auteur' => 'bail|int',
            'status' => 'bail|in:ok,signaler,attente,banni',
        ]);
        $article->fill($validation);
        $article->save();
        return response()->json([
            'status' => 'Success',
            'data' => $article,
        ]);
    }
    public function destroy(Article $article)
    {
        $article->delete();

        File::delete(public_path('images/uploads/' . $article->image));

        return response()->json([
            'status' => "Suppression effectuée avec succès !"
        ]);
    }
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

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
    public function reportArticle(Request $request, Article $article)
    {
        try {
            $article->status = StatusEnum::STATUS_REPORT->value;
            $article->save();

            return response()->json([
                'status' => 'Success',
                'message' => 'Article signalé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Erreur lors du signalement de l\'article'
            ], 500);
        }
    }
}
