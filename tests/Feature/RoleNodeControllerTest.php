<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\RoleNode;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleNodeControllerTest extends TestCase
{
    use RefreshDatabase;
    
public function testCreateRoleNodeSuccessfully()
{
    // Arrange: create an authorizer RoleNode in DB
    $authorizer = RoleNode::factory()->create(['role' => 'admin']);

    // Payload for creation, with new unique node_id
    $payload = [
        'authorized_node_id' => $authorizer->node_id,
        'node_id' => 'nodeid-unique-create',  // unique string for this test
        'role' => 'mentor',
    ];

    // Act: call the API endpoint
    $response = $this->postJson('/api/roles-node', $payload);

    // Assert: response status 201 and success message
    //$response->dump();
    $response->assertStatus(201)
             ->assertJson([
                'message' => 'Role created successfully.'
            ]);

    // Assert: DB contains new RoleNode with correct role
    $this->assertDatabaseHas('roles_node', [
        'node_id' => 'nodeid-unique-create',
        'role' => 'mentor',
    ]);
}


    public function test_create_role_node_success()
    {
        $authorizer = RoleNode::factory()->create(['role' => 'admin']);
        $newUserNodeId = 'nodeid-newuser';

        $payload = [
            'authorized_node_id' => $authorizer->node_id,
            'node_id' => $newUserNodeId,
            'role' => 'mentor',
        ];

        $response = $this->postJson('/api/roles-node', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Role created successfully.'
            ]);

        $this->assertDatabaseHas('roles_node', [
            'node_id' => $newUserNodeId,
            'role' => 'mentor',
        ]);
    }

    public function test_create_role_node_unauthorized()
    {
        $authorizer = RoleNode::factory()->create(['role' => 'mentor']);
        $payload = [
            'authorized_node_id' => $authorizer->node_id,
            'node_id' => 'nodeid-newuser',
            'role' => 'admin', // equal or higher than authorizer
        ];
        $response = $this->postJson('/api/roles-node', $payload);

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'You cannot create a role equal or higher than your own.'
            ]);
    }

    public function test_create_role_node_validation_error()
    {
        $payload = [
            'authorized_node_id' => '',
            'node_id' => '',
            'role' => 'invalidrole',
        ];
        $response = $this->postJson('/api/roles-node', $payload);
        $response->assertStatus(422);
    }

    

}