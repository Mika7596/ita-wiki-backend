<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;

class RoleControllerTest extends TestCase
{
    /*
    A basic feature test example.
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    */

    public function setUp(): void
    {
        parent::setUp();
        $student = Role::factory()->create([
            'github_id' => 123456,
            'role' => 'student'
        ]);
        //$this->seed();
    }

    public function testCanGetRoleByGithubId(): void
    {
        $response = $this->get('/users/user-signedin-as?github_id=123456');
        $response->assertStatus(200)
        ->assertJsonStructure(['message', 'role'])
        ->assertJson([
            'message' => 'Role found.',
            'role' => 'student'
        ]);
    }

    public function testSignsUpAsAnonymous(): void
    {
        $random_github_id = random_int(1, 10000000);
        $response = $this->get('/users/user-signedin-as?github_id=' . $random_github_id);
        $response->assertStatus(201)
        ->assertJsonStructure(['message', 'role'])
        ->assertJson([
            'message' => 'Role not found. Created as new anonymous user.',
            'role' => 'anonymous'
        ]);
    }

}
