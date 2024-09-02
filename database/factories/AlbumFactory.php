<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'album_name' => fake()->text(20),
            'album_thumb' => fake()->imageUrl(),
            'description' => fake()->text(100),
            'created_at' => fake()->dateTime(),
            'user_id' => User::factory()
        ];
    }
}
