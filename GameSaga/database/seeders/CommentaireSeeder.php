<?php

namespace Database\Seeders;

use App\Models\Commentaire;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Commentaire::create([
            'article_id' => 1,
            'user_id' => 3,
            "contenu" => "genial ce jeu",
            "note" => 20,
            "status" => "ok",
        ]);

        Commentaire::factory(30)->create();
    }
}
