<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(60),
            'description' => fake()->text(128),
            'img_path' => fake()->imageUrl(),
            'album_id' => Album::factory(),
            'created_at' => fake()->dateTime(),
        ];
    }
}
