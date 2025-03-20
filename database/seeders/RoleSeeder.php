<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['github_id' => 1, 'role' => 'superadmin']);

        // Oreana is admin
        Role::create(['github_id' => 92450839, 'role' => 'admin']);

        // Frontend team members
        $studentGithubIds = [
            6729608,
            47982114,
            132897973,
            132501110,
            119063441
        ];

        foreach ($studentGithubIds as $githubId) {
            Role::create([
                'github_id' => $githubId,
                'role' => 'student',
            ]);
        }

        Role::factory(20)->create();
    }
}
