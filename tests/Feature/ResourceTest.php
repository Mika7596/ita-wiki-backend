<?php

namespace Tests\Feature;

use App\Models\Resource;
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
        $result = Resource::factory()->count(5)->create();
        var_dump($result);

        $response = $this->get('/api/resources/lists');

        $response->assertStatus(200);
    }

}
