<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function canGetList(): void
    {
        $response = $this->get('/resources/lists');

        $response->assertStatus(200);
    }

/*     public function canStoreResource(): void
    {
        $response = $this->post('/resources', [
            'id_github' => '123',
            'title' => 'Test',
            'url' => 'http://test.com',
        ]);

        $response->assertStatus(201);
    }
    
    public function canDeleteResource(): void
    {
        $response = $this->delete('/resources/1');

        $response->assertStatus(204);
    } */
}
