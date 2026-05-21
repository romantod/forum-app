<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $title = fake()->sentence(6);
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 100000),
            'body' => fake()->paragraphs(3, true),
        ];
    }
}
