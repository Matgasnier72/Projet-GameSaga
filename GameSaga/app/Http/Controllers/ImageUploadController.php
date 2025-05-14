<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ImageUploadController extends Controller
{
    public function index()
    {
        $image = Image::all();

        // On retourne les informations des utilisateurs en format JSON
        return response()->json($image);
    }
    public function store(Request $request)
    {
        if (!($request->user()->isAdmin() || $request->user()->isRedacteur())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Permission denied'
            ], 403); // Retourne une erreur 403 (Forbidden)
        }
        // Validation
        $validator =  $request->validate([
            'image_blob' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nom' => 'required|string',
            'description' => 'string',
            'statut' => 'attente',
            'article_id' => 'required|integer'
        ]);
        $image = new Image();
        if ($request->file('image_blob')) {
            $fileName = time() . '_' . $request->image_blob->getClientOriginalName();
            $image->path = $fileName;
            $request->image_blob->move(public_path('images/uploads'), $fileName);
        }
        $image->fill($validator);
        $image->save();

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $image,
        ]);
    }

    public function show(Image $image)
    {
        return response()->json($image);
    }

    public function destroy(Image $image,Request $request)
    {
        $image->delete();
        if (!File::exists(public_path('images/uploads/' . $image->path))) {
            return response()->json([
                'status' => 'Error',
                'message' => 'File not found'
            ], 404); // Retourne une erreur 404 (Not Found)
            
        }
        if (!($request->user()->isAdmin() || $request->user()->isRedacteur()) && $image->user_id === Auth::user()->id){
            return response()->json([
                'status' => 'Error',
                'message' => 'Permission denied'
            ], 403);
        }

        File::delete(public_path('images/uploads/' . $image->path));
        return response()->json([
            'status' => 'Success',
            'message' => 'Image deleted successfully'
        ]);
    }
    public function getImagesByArticle($idArticle)
    {
        $images = Image::where('article_id', $idArticle)->get();
        return response()->json($images);
    }
}