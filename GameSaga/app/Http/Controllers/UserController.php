<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//$this->authorize('update');
class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $key = trim($request);

        // Recherche des articles en fonction du titre ou du contenu
        $posts = User::query()->get();

        return response()->json([
            'success' => true,
            'data' => [
                'key' => $key,
                'posts' => $posts
            ]
        ]);
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(['message' => 'User updated successfully']);
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
