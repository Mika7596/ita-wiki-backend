<?php
namespace Tests\Feature;

use App\Models\RoleNode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleNodeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $student;

    public function setUp(): void
    {
        parent::setUp();
        $this->student = RoleNode::factory()->create([
            'role' => 'student',
        ]);
    }

    public function testCanUpdateRoleByNodeId(): void
    {
        $superadmin = RoleNode::factory()->create([
            'role' => 'superadmin',
        ]);
        $response = $this->put(route('roles-node.update'), [
            'node_id'            => $this->student->node_id,
            'role'               => 'mentor',
            'authorized_node_id' => $superadmin->node_id,
        ]);
        $response->assertStatus(200);
    }

    public function testCreateRoleNodeSuccessfully()
    {
        // Arrange: create an authorizer RoleNode in DB
        $authorizer = RoleNode::factory()->create(['role' => 'admin']);

        // Payload for creation, with new unique node_id
        $payload = [
            'authorized_node_id' => $authorizer->node_id,
            'node_id'            => 'nodeid-unique-create', // unique string for this test
            'role'               => 'mentor',
        ];

        // Act: call the API endpoint
        $response = $this->postJson('/api/roles-node', $payload);

        // Assert: response status 201 and success message
        //$response->dump();
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Role created successfully.',
            ]);

        // Assert: DB contains new RoleNode with correct role
        $this->assertDatabaseHas('roles_node', [
            'node_id' => 'nodeid-unique-create',
            'role'    => 'mentor',
        ]);
    }

    public function test_create_role_node_success()
    {
        $authorizer    = RoleNode::factory()->create(['role' => 'admin']);
        $newUserNodeId = 'nodeid-newuser';

        $payload = [
            'authorized_node_id' => $authorizer->node_id,
            'node_id'            => $newUserNodeId,
            'role'               => 'mentor',
        ];

        $response = $this->postJson('/api/roles-node', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Role created successfully.',
            ]);

        $this->assertDatabaseHas('roles_node', [
            'node_id' => $newUserNodeId,
            'role'    => 'mentor',
        ]);
    }

    public function test_create_role_node_unauthorized()
    {
        $authorizer = RoleNode::factory()->create(['role' => 'mentor']);
        $payload    = [
            'authorized_node_id' => $authorizer->node_id,
            'node_id'            => 'nodeid-newuser',
            'role'               => 'admin', // equal or higher than authorizer
        ];
        $response = $this->postJson('/api/roles-node', $payload);

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'You cannot create a role equal or higher than your own.',
            ]);
    }

    public function test_create_role_node_validation_error()
    {
        $payload = [
            'authorized_node_id' => '',
            'node_id'            => '',
            'role'               => 'invalidrole',
        ];
        $response = $this->postJson('/api/roles-node', $payload);
        $response->assertStatus(422);
    }

    
    public function testCanGetRoleByNodeId(): void
    {
        $roleNode = RoleNode::factory()->create([
            'role' => 'student'
        ]);

        $response = $this->post(route('login-node'), [
            'node_id' => $roleNode->node_id
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Role found.',
                'role' => [
                    'node_id' => $roleNode->node_id,
                    'role' => 'student'
                ]
            ]);
    }


    public function testRoleNotFound(): void
    {
        $random_node_id = 'MDQ6VXNlcj' . random_int(100000, 999999) . '=';
        $response = $this->post(route('login-node'), [
            'node_id' => $random_node_id
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Role not found.'
            ]);
    }

}