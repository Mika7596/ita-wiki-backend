<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RoleNode;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\WithFaker;

class CreateRoleNodeTest extends TestCase
{
    use WithFaker;

    private function createRoleNode(string $role): RoleNode
    {
        return RoleNode::create([
            'node_id' => $this->faker->unique()->regexify('MDQ6VXNlcj[0-9]{6}='),
            'role' => $role,
        ]);
    }

    private function requestCreateRoleNode(string $authorized_node_id, string $role)
    {
        return $this->post(route('roles-node.create'), [
            'authorized_node_id' => $authorized_node_id,
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => $role,
        ]);
    }

    public function testCanCreateRoleNodeBeingSuperadmin(): void
    {
        $superadmin = $this->createRoleNode('superadmin');

        $this->requestCreateRoleNode($superadmin->node_id, 'admin')
            ->assertStatus(201);

        $this->assertDatabaseHas('roles_node', [
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => 'admin'
        ]);
    }

    public function testCanCreateRoleNodeBeingAdmin(): void
    {
        $admin = $this->createRoleNode('admin');

        $this->requestCreateRoleNode($admin->node_id, 'mentor')
            ->assertStatus(201);

        $this->assertDatabaseHas('roles_node', [
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => 'mentor'
        ]);
    }

    public function testCanCreateRoleNodeBeingMentor(): void
    {
        $mentor = $this->createRoleNode('mentor');

        $this->requestCreateRoleNode($mentor->node_id, 'student')
            ->assertStatus(201);

        $this->assertDatabaseHas('roles_node', [
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => 'student'
        ]);
    }

    public function testShowErrorWhenStudentWantsToCreateSuperiorRole()
    {
        $student = $this->createRoleNode('student');

        $this->requestCreateRoleNode($student->node_id, 'mentor')
            ->assertStatus(403);

        $this->assertDatabaseMissing('roles_node', [
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => 'mentor'
        ]);
    }

    public function testShowErrorWhenMentorWantsToCreateSuperiorRole()
    {
        $mentor = $this->createRoleNode('mentor');

        $this->requestCreateRoleNode($mentor->node_id, 'admin')
            ->assertStatus(403);

        $this->assertDatabaseMissing('roles_node', [
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => 'admin'
        ]);
    }

    public function testShowErrorWhenAdminWantsToCreateSuperiorRole()
    {
        $admin = $this->createRoleNode('admin');

        $this->requestCreateRoleNode($admin->node_id, 'superadmin')
            ->assertStatus(403);

        $this->assertDatabaseMissing('roles_node', [
            'node_id' => 'MDQ6VXNlcj123456=',
            'role' => 'superadmin'
        ]);
    }

    public function testShowStatus422WhenNodeIdIsDuplicated()
    {
        $admin = $this->createRoleNode('admin');

        $this->requestCreateRoleNode($admin->node_id, 'student');
        $this->requestCreateRoleNode($admin->node_id, 'student')
            ->assertStatus(422);
    }

    private function getRoleNodeData(): array
    {
        return RoleNode::factory()->raw();
    }

    #[DataProvider('roleNodeValidationProvider')]
    public function testShowStatus422WithInvalidData(array $invalidData, string $fieldName): void
    {
        $data = $this->getRoleNodeData();
        $data = array_merge($data, $invalidData);

        $response = $this->postJson(route('roles-node.create'), $data)
            ->assertStatus(422)
            ->assertJsonPath($fieldName, function ($errors) {
                return is_array($errors) && count($errors) > 0;
            });
    }

    public static function roleNodeValidationProvider(): array
    {
        return [
            // authorized_node_id
            'missing authorized_node_id' => [['authorized_node_id' => null], 'authorized_node_id'],
            'authorized_node_id must be a string' => [['authorized_node_id' => 123456], 'authorized_node_id'],
            'authorized_node_id must exist in roles_node table' => [['authorized_node_id' => 'MDQ6VXNlcj000000='], 'authorized_node_id'],
            // node_id
            'missing node_id' => [['node_id' => null], 'node_id'],
            'node_id must be a string' => [['node_id' => 123456], 'node_id'],
            // role
            'missing role' => [['role' => null], 'role'],
            'role must be a string' => [['role' => 123456], 'role'],
            'role must be one of the following: superadmin, admin, mentor, student' => [['role' => 'visitor'], 'role'],
        ];
    }
}
