<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class TriArticleController extends Controller
{
    public function ArticleTri(Request $request)
{
    // Récupérer les paramètres de tri avec des valeurs par défaut
    $sort = $request->query('sort', 'id'); // Par défaut, on trie par 'id'
    $order = $request->query('order', 'asc'); // Ordre par défaut 'asc'
    $perPage = (int) $request->query('per_page', 30); // Nombre d'articles par page, par défaut 30

    // Valider les colonnes de tri valides
    $validSorts = ['id', 'titre', 'user_id', 'note_auteur', 'created_at', 'updated_at'];
    if (!in_array($sort, $validSorts)) {
        $sort = 'id'; // Défaut sur la colonne 'id' si la colonne est invalide
    }

    // Valider l'ordre de tri
    $validOrders = ['asc', 'desc'];
    if (!in_array($order, $validOrders)) {
        $order = 'asc'; // Défaut à 'asc' si l'ordre est invalide
    }

    // Vérifier que 'per_page' est un nombre valide et positifc
    if ($perPage <= 0) {
        $perPage = 30; // Si 'per_page' est invalide, on le fixe à 30
    }

    // Récupérer les articles triés et paginés en fonction des paramètres
    $articles = Article::orderBy($sort, $order)->paginate($perPage);

    // Retourner une réponse JSON avec les articles triés et paginés
    return response()->json([
        'success' => true,
        'data' => $articles
    ]);
}

}
