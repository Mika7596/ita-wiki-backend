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
            'id' => $this->faker->id(),
            'id_github' => $this->faker->numberBetween(1, 100),
            'title' => $this->faker->sentence(6),
            'url' => $this->faker->url(),
        ];
    }
}
