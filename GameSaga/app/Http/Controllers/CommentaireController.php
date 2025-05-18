<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function index()
    {
        $commentaire = Commentaire::with('article','user')->get();
        return response()->json($commentaire);
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'article_id' => 'bail|required|int',
            'contenu' => 'bail|string',
            'note' => 'bail|required|int',
            'status' => 'bail|in:ok,signaler,attente,banni',
        ]);

        if ($this->hasRole(['ROLE_USER', 'ROLE_REDACTEUR', 'ROLE_ADMIN'])) {
            $commentaire = new Commentaire();
            $commentaire->fill($validation);
            $commentaire->user_id = Auth::user()->id;
            $commentaire->save();

            return response()->json([
                'status' => 'Success',
                'data' => $commentaire,
            ]);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Permission denied'
            ], 403); 
        }
    }

    public function show(Commentaire $commentaire)
    {
        return response()->json($commentaire);
    }

    public function update(Commentaire $commentaire, Request $request)
    {
        if (($this->hasRole(['ROLE_USER']) && $commentaire->user_id === Auth::user()->id) || $this->hasRole(['ROLE_REDACTEUR', 'ROLE_ADMIN'])) {
            $validation = $request->validate([
                'article_id' => 'bail|int',
                'contenu' => 'bail|string',
                'note' => 'bail|int',
                'status' => 'bail|in:ok,signaler,attente,banni',
            ]);

            $commentaire->fill($validation);
            $commentaire->save();

            return response()->json([
                'status' => 'Success',
                'data' => $commentaire,
            ]);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Permission denied'
            ], 403);
        }
    }

    public function destroy(Commentaire $commentaire)
    {
        if ($this->hasRole(['ROLE_ADMIN']) || ($this->hasRole(['ROLE_USER']) && $commentaire->user_id === Auth::user()->id)) {
            $commentaire->delete();

            return response()->json([
                'status' => "Suppression effectuée avec succès !"
            ]);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Permission denied'
            ], 403);
        }
    }
    private function hasRole(array $roles)
    {
        return in_array(Auth::user()->role, $roles);
    }

    private function bannissement()
    {
       /*  $user = Auth::user();
        $user->banned = true;
        $user->save();

        return response()->json([
            'status' => 'Error',
            'message' => 'Vous avez été banni pour avoir enfreint les règles de la communauté.'
        ]);  */
    }
}

