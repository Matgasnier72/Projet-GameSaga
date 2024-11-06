<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'pseudo' => 'administrateur',
            'email' => 'admin@admin.net',
            'password' => 'test_Laravel_project',
            'statut' => 'ok',
            'token' => Str::random(40),
            'remember_token' => Str::random(10),
            'role' => RoleEnum::ROLE_ADMIN
        ]);
        User::create([
            'pseudo' => 'redacteur',
            'email' => 'redac@admin.net',
            'password' => 'test_Laravel_project',
            'statut' => 'ok',
            'token' => Str::random(40),
            'remember_token' => Str::random(10),
            'role' => RoleEnum::ROLE_REDACTEUR
        ]);
        User::create([
            'pseudo' => 'user',
            'email' => 'user@admin.net',
            'password' => 'test_Laravel_project',
            'statut' => 'ok',
            'token' => Str::random(40),
            'remember_token' => Str::random(10),
            'role' => RoleEnum::ROLE_USER
        ]);
    }
}
