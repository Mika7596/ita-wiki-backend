<?php

declare (strict_types= 1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ResourceSeeder::class,
            BookmarkSeeder::class
        ]);

        // Run adjustment query to update bookmark_count in resources
        DB::statement("
            UPDATE resources
            SET bookmark_count = (
                SELECT COUNT(*)
                FROM bookmarks
                WHERE bookmarks.resource_id = resources.id
            )
        ");
    
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
