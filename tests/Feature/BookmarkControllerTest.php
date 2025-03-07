<?php

declare (strict_types= 1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Models\Resource;
use App\Models\Bookmark;

class BookmarkControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $student;
    protected $anonymous;

    public function setUp(): void
    {
        parent::setUp();

        $this->student = Role::factory()->create([
            'github_id' => 9871315,
            'role' => 'student'
        ]);
        $this->anonymous = Role::factory()->create([
            'github_id' => 9861725,
            'role' => 'anonymous'
        ]);

        Resource::factory(2)->create([
            'github_id' => $this->student->github_id
        ]);

        Bookmark::factory()->createMany([
            ['github_id' => $this->student->github_id, 'resource_id' => 1],
            ['github_id' => $this->student->github_id, 'resource_id' => 2]
        ]);
    }


    public function getStudentBookmarks(): void
    {
        $response = $this->get('api/bookmarks/?github_id=' . $this->student->github_id);
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['github_id' => 9871315, 'resource_id' => 1])
            ->assertJsonFragment(['github_id' => 9871315, 'resource_id' => 2]);
    }

    public function destroyBookmark(): void
    {
        $response = $this->post('api/bookmarks', [
            'github_id' => $this->student->github_id,
            'resource_id' => 2]);
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment(['github_id' => 9871315, 'resource_id' => 1]);
    }

    public function createBookmark(): void
    {
        $response = $this->post('api/bookmarks', [
            'github_id' => $this->student->github_id,
            'resource_id' => 2]);
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['github_id' => 9871315, 'resource_id' => 1])
            ->assertJsonFragment(['github_id' => 9871315, 'resource_id' => 2]);
    }

    public function createAnonymousBookmarkFails() : void {
        $response = $this->post('api/bookmarks', [
            'github_id' => $this->anonymous->github_id,
            'resource_id' => 2]);
        $response->assertStatus(422);
    }

    public function getAnonymousBookmarks(): void
    {
        $response = $this->get('api/bookmarks/?github_id=' . $this->anonymous->github_id);
        $response->assertStatus(200)
        ->assertJsonCount(0);
    }
}
