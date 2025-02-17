<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'titre' => "Skyrim",
            'user_id' => 2,
            "contenu" => "surement le meilleur action rpg 3D de tous les temps, a tester absolument avec des mods.Attention, destruction de toute vie sociable possible",
            "note_auteur" => 20,
            "status" => "ok"
        ]);

        Article::factory(9)->create();
    }
}
