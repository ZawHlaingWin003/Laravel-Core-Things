<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->words(3, true),
            'slug' => fake()->slug(3, false),
            'excerpt' => fake()->sentences(3, true),
            'content' => fake()->paragraphs(3, true),
            'author_id' => rand(1, 3)
        ];
    }
}
