<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArticleCommentaireController extends Controller
{
    public function getCommentaires(Request $request, int $id)
    {
        return Commentaire::where('article_id', $id)
        ->with('user')
        ->get();
    }
    public function getCommentaireByID(Request $request, int $idArticle, int $idCommentaire)
    {
        //$commentaires = DB::select('select * from articles inner join Commentaires where article_id = articles.id and articles.id = ?', [$idArticle]);
        $article = Article::find($idArticle);
        $commentaires = $article->commentaires->where('id', $idCommentaire);

        return response()->json($commentaires);
    }
    public function CommentaireArticle(Request $request, int $idArticle)
    {
        $validation = $request->validate([
            'article_id' => 'required|int',
            'contenu' => 'string',
            'note' => 'required|int',
        ]);
        $commentaire = new Commentaire();
        $commentaire->fill($validation);
        $commentaire->user_id = Auth::user()->id;
        $commentaire->save();
        return response()->json([
            'status' => 'Success',
            'data' => $commentaire,
        ]);
    }
    /* public function countCommentaireArticle(Request $request, int $idArticle)
    {
        $article = Article::find($idArticle);
        //$nbCommentaires = DB::select('select COUNT * from articles inner join Commentaires where article_id = articles.id and articles.id = '.$idArticle , [$idArticle] );
        $nbCommentaires = DB::table('articles') ->join('Commentaires' , 'article_id','=', 'articles.id')-> where('articles.id',$idArticle);
        return response()->json($nbCommentaires);
    }*/
}
