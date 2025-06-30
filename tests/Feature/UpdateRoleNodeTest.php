<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\RoleNode;
use Illuminate\Foundation\Testing\WithFaker;

class UpdateRoleNodeTest extends TestCase
{
    use WithFaker;

    protected $student;
    protected $mentor;
    protected $admin;
    protected $superadmin;

    public function setUp(): void
    {
        parent::setUp();
        $this->student = RoleNode::factory()->create([
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => 'student'
        ]);
        $this->mentor = RoleNode::factory()->create([
            'node_id' => 'MDQ6VXNlcj234567=',
            'role' => 'mentor'
        ]);
        $this->admin = RoleNode::factory()->create([
            'node_id' => 'MDQ6VXNlcj345678=',
            'role' => 'admin'
        ]);
        $this->superadmin = RoleNode::factory()->create([
            'node_id' => 'MDQ6VXNlcj456789=',
            'role' => 'superadmin'
        ]);
    }

    public function testCanUpdateRoleToLower(): void
    {
        $this->putJson(route('roles-node.update'), [
            'authorized_node_id' => $this->admin->node_id,
            'node_id' => $this->student->node_id,
            'role' => 'mentor'
        ])->assertStatus(200);

        $this->assertDatabaseHas('roles_node', [
            'node_id' => $this->student->node_id,
            'role' => 'mentor'
        ]);
    }

    public function testCannotUpdateHigherRankedRole(): void
    {
        $this->putJson(route('roles-node.update'), [
            'authorized_node_id' => $this->mentor->node_id,
            'node_id' => $this->admin->node_id,
            'role' => 'student'
        ])->assertStatus(403);

        $this->assertDatabaseHas('roles_node', [
            'node_id' => $this->admin->node_id,
            'role' => 'admin'
        ]);
    }

    public function testCannotUpdateRoleToEqual(): void
    {
        $this->putJson(route('roles-node.update'), [
            'authorized_node_id' => $this->superadmin->node_id,
            'node_id' => $this->student->node_id,
            'role' => 'superadmin'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('roles_node', [
            'node_id' => $this->student->node_id,
            'role' => 'superadmin'
        ]);
    }

    public function testCannotUpdateRoleToHigher(): void
    {
        $this->putJson(route('roles-node.update'), [
            'authorized_node_id' => $this->mentor->node_id,
            'node_id' => $this->student->node_id,
            'role' => 'admin'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('roles_node', [
            'node_id' => $this->student->node_id,
            'role' => 'admin'
        ]);
    }

    public function testCannotUpdateRoleToNonExistent(): void
    {
        $this->putJson(route('roles-node.update'), [
            'authorized_node_id' => $this->admin->node_id,
            'node_id' => $this->student->node_id,
            'role' => 'nonexistent'
        ])->assertStatus(422);

        $this->assertDatabaseMissing('roles_node', [
            'node_id' => $this->student->node_id,
            'role' => 'nonexistent'
        ]);
    }

    public function testCannotUpdateRoleWithNonExistentAuthorized(): void
    {
        $this->putJson(route('roles-node.update'), [
            'authorized_node_id' => 'MDQ6VXNlcj999999=',
            'node_id' => $this->student->node_id,
            'role' => 'mentor'
        ])->assertStatus(422);

        $this->assertDatabaseMissing('roles_node', [
            'node_id' => $this->student->node_id,
            'role' => 'mentor'
        ]);
    }
}
