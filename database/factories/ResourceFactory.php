<?php

namespace Database\Factories;

use App\Models\Role;
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
        $role = Role::where('role', '!=', 'anonymous')
        ->inRandomOrder()
        ->first();

        return [
            'id_github' => $role->github_id,
            'title' => $this->faker->sentence(6),
            'url' => $this->faker->url()
        ];
    }
}
