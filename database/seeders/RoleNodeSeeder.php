<?php
namespace Database\Seeders;

use App\Models\RoleNode;
use Illuminate\Database\Seeder;

class RoleNodeSeeder extends Seeder
{
    public function run(): void
    {
        // Use a string node_id in GitHub format for superadmin
        RoleNode::create(['node_id' => 'MDQ6VXNlcjE=', 'role' => 'superadmin']);

        RoleNode::create([
            'node_id' => 'MDQ6VXNlcjY3Mjk2MDg=',
            'role'    => 'student',
        ]);

        RoleNode::factory()->count(10)->create();
    }

}
