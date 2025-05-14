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
    public function userBan(int $userId): bool
    {
        try {
            $user = User::findOrFail($userId);
            $user->status = StatusEnum::STATUS_BAN->value;
            return $user->save();
        } catch (\Exception $e) {
            return false;
        }
    }
}
