<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RegisterEmail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required|email:strict,dns',
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
        $user->email_verified_at = null;
        $user->role=RoleEnum::ROLE_USER;
        $user->save();

        Mail::to($user->email)->send(new RegisterEmail($user));
        return response()->json($user);
    }
    public function verification(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required|string|email|exists:users',
            'token' => 'required|string|min:40|exists:users'
        ]);

        $user = User::where('email', '=', $formFields['email'])
            ->where('token', '=', $formFields['token'])
            ->where('email_verified_at', '=', now())
            ->first();

        if (!$user) {
            return response()->json(['failed' => 'failed', 400]);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['status' => 'success'],200);
    }
}
