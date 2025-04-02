<?php

declare (strict_types= 1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            BookmarkSeeder::class,
            LikeSeeder::class
        ]);

        // Run adjustment query to update like_count in resources
        DB::statement("
            UPDATE resources
            SET like_count = (
                SELECT COALESCE(SUM(like_dislike), 0)
                FROM likes
                WHERE likes.resource_id = resources.id
            )
        ");
    }
}