<?php

declare (strict_types= 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use App\Models\Resource;
use App\Models\Bookmark;

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
    public function definition()
    {
        do {
            $role = Role::where('role', 'student')->inRandomOrder()->first();
            $resource = Resource::inRandomOrder()->first();
        
            if (!$role || !$resource) {
                throw new \Exception('Roles or Resources table is empty.');
            }

            $github_id = $role->github_id;
            $resource_id = $resource->id;

        } while (Bookmark::where('github_id', $github_id)
            ->where('resource_id', $resource_id)
            ->exists());

        return [
            'github_id' => $github_id,
            'resource_id' => $resource_id
        ];   
    }

}