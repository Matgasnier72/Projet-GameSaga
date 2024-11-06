<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required|email',
            'pseudo' => 'required|string',
            'password' => ['required', 'confirmed', Password::defaults()]
        ]);
        //return response()->json($formFields);
        $userFound = DB::table('users')->where('email', $formFields['email']);
        if ($userFound->count() > 0) {
            return response()->json(['user' => null], 401);
        }
        $user = new User();
        $user->fill($formFields);
        $user->token = Str::random(40);
        $user->email_verified_at = now();
        $user->save();

        Mail::to($user->email)->send(new RegisterEmail($user1));
        return response()->json($user);
    }
}
