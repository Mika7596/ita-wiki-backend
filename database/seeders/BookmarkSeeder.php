<?php

declare (strict_types= 1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bookmark;
use App\Models\Resource;
use App\Models\Role;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = Role::where('github_id', 6729608)->firstOrFail();
        $resources = Resource::inRandomOrder()->take(3)->get();

        if ($student && $resources) {
            foreach ($resources as $resource) {
                Bookmark::create([
                    'github_id' => $student->github_id,
                    'resource_id' => $resource->id,
                ]);
            }
        }

        //Bookmark::factory(5)->create();
    }
}