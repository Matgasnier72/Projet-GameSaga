<?php

namespace Database\Seeders;

use App\Models\Reponse;
use Illuminate\Database\Seeder;

class ReponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reponse::create([
            'choix' => "oui C'est génial",
            'sondage_id' => 1
        ]);
        Reponse::create([
            'choix' => "non je préfere m'arracher les yeux",
            'sondage_id' => 1
        ]);
        Reponse::create([
            'choix' => "ça me rend indifférent",
            'sondage_id' => 1
        ]);
        Reponse::create([
            'choix' => "c'était mieux avant",
            'sondage_id' => 1
        ]);
    }
}
