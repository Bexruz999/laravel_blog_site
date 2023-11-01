<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'name' => $this->faker->name(),
            'title'=> $this->faker->title(),
            'meta_title' => $this->faker->title,
            'short_desc' => $this->faker->text,
            'description' => $this->faker->text,
            'created_at' => $this->faker->time()
        ];
    }
}
