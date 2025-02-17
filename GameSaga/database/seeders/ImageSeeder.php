<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::create([
            'nom' => "png.png",
            'description' => 'les lettres PNG au format png',
            'article_id' => 1,
            'statut' => 'ok',
            'path' => '/'
        ]);
    }
}
