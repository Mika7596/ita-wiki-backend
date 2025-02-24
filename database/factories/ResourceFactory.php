<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'github_id' => $this->faker->text(15),
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->sentence(50),
            'url' => $this->faker->url(),
        ];
    }
}
