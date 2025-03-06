<?php

declare (strict_types= 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bookmark;
use App\Models\Role;
use App\Models\Resource;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'github_id' => Role::where('role', 'student')->inRandomOrder()->first()->github_id,
            'resource_id' => Resource::inRandomOrder()->first()->id
        ];
    }
}
