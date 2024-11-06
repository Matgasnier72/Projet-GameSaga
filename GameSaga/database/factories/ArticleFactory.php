<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => fake()->name(),
            'user_id' => random_int(1,2),
            'contenu' => fake()->paragraph(),
            'status' => 'ok',
            'note_auteur' => random_int(0,20),
        ];
    }
}
