<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Mockery;

class GitHubAuthControllerTest extends TestCase
{
    public function test_callback_returns_github_user_data()
    {
        // Mock del usuario de GitHub
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('12345');
        $abstractUser->user = ['node_id' => 'MDQ6VXNlcjEyMzQ1'];

        // Mock de Socialite
        Socialite::shouldReceive('driver->stateless->user')
            ->andReturn($abstractUser);

        $response = $this->get('/api/auth/github/callback');

        $response->assertStatus(200)
            ->assertJson([
                'github_id' => '12345',
                'node_id' => 'MDQ6VXNlcjEyMzQ1',
            ]);
    }
}
