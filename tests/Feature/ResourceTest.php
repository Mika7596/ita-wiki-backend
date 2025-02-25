<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCanGetList(): void
    {
        Role::factory(10)->create();
        Resource::factory()->count(5)->create();

        $response = $this->get('/api/resources/lists');

        $response->assertStatus(200)->assertJsonCount(5);
    }

/*     public function testCanStoreResource(): void
    {
        $response = $this->post('/resources', [
            'id_github' => '123',
            'title' => 'Test',
            'url' => 'http://test.com',
        ]);

        $response->assertStatus(201);
    }
    
    public function testCanDeleteResource(): void
    {
        $response = $this->delete('/resources/1');

        $response->assertStatus(204);
    } */
}
