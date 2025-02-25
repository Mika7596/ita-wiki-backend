<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $response->assertStatus(200);
    }

}
