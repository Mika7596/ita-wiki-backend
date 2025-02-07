<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSaveTest extends TestCase
{
    public function testCanUserBeSaved()
    {
        $data = [
            'github_id' => '1234567890123456789012345',
        ];

        $response = $this->postJson(route('user.save'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'github_id' => $data['github_id'],
        ]);
    }

    public function testValidateErrorMinimumGithubCharacters()
    {
        $data = [
            'github_id' => '12345',
        ];

        $response = $this->postJson(route('user.save'), $data);

        $response->assertStatus(422);
    }

    public function testValidateErrorEmptyGithubId()
    {
        $data = [
            'github_id' => '',
        ];

        $response = $this->postJson(route('user.save'), $data);

        $response->assertStatus(422);
    }

    public function testValidateErrorMissingGithubId()
    {
        $response = $this->postJson(route('user.save'));

        $response->assertStatus(422);
    }

}
