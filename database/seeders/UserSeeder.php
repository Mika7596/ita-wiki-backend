<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'github_id' => '999999999',
        ]);

        User::factory(20)->create();
    }
}

