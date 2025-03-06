<?php

declare (strict_types= 1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bookmark;
use App\Models\Resource;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resource = Resource::all()->first();
        Bookmark::create([
            'github_id' => 6729608,
            'resource_id' => $resource->id,
        ]);

        Bookmark::factory(5)->create();
    }
}
