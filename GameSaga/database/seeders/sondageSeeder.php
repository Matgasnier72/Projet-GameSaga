<?php

namespace Database\Seeders;

use App\Models\Sondage;
use Illuminate\Database\Seeder;

class SondageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sondage::create([
            'auteur_id' => 1,
            'titre' => 'star wars',
            'question' => 'vous aimer la post-logie star wars?',
            'date_fin' => '2024-09-15 12:00:00'
        ]);
    }
}
