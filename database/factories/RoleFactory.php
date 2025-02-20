<?php
declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'github_id' => $this->faker->numberBetween(1, 10000000)->unique(),
            'role' => $this->faker->randomElement(['admin', 'mentor', 'student', 'anonymous']),
        ];
    }
}
