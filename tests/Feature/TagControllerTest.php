<?php

declare (strict_types= 1);

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCanGetTagsList(): void
    {
        $response = $this->get(route('tags'));
        $response->assertStatus(200);
    }
}
