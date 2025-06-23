<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleNode;

class RoleNodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleNode::create(['node_id' => 1, 'role' => 'superadmin']); //1 as a string ??? or gtihub format

        RoleNode::create([
            'node_id' => 'MDQ6VXNlcjE',
            'role' => 'student',
        ]);

        RoleNode::factory()->count(10)->create();
    }
}
