<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

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
        // Validation
        $validator =  $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nom' => 'required|string',
            'description' => 'string',
            'statut' => 'attente',
            'article_id' => 'required|integer'
        ]);
        $image = new Image();
        if ($request->file('image')) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $image->path = $fileName;
            $request->image->move(public_path('images/uploads'), $fileName);
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

    public function update(Request $request, Image $image)
    {
        // Validation
        $validator =  $request->validate([
            'image' => 'bail|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nom' => 'bail|string',
            'description' => 'bail|string',
            'statut' => 'attente',
            'article_id' => 'bail|integer'
        ]);
        if ($request->file('image') && File::exists(public_path('images/uploads/' . $image->path))) {
            File::delete(public_path('images/uploads/' . $image->path));
        }
        if ($request->file('image')) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $image->path = $fileName;
            $request->image->move(public_path('images/uploads'), $fileName);
        }
        $image->fill($validator);
        $image->save();
        

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $image,
        ]);
    }

    public function destroy(Image $image)
    {
        $image->delete();
        if (File::exists(public_path('images/uploads/' . $image->path))) {
            File::delete(public_path('images/uploads/' . $image->path));
        }
        // On retourne la réponse au format JSON
        return response()->json([
            'status' => "Suppression effectuée avec succès !"
        ]);
    }
}
