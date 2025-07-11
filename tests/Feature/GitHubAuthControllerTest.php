<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GitHubAuthControllerTest extends TestCase
{
    use RefreshDatabase;
    

    public function test_callback_redirects_with_token_only()
    {
        $abstractUser = Mockery::mock(\Laravel\Socialite\Contracts\User::class);
        $abstractUser->shouldReceive('getId')->andReturn('12345');
        $abstractUser->shouldReceive('getName')->andReturn('Test User');
        $abstractUser->shouldReceive('getNickname')->andReturn('testuser');
        $abstractUser->shouldReceive('getEmail')->andReturn('unique_test@example.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://avatar.url');
        $abstractUser->id = '12345'; // Asegura la propiedad id

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver->stateless->user')
            ->andReturn($abstractUser);

        $response = $this->get('/api/auth/github/callback');
        $response->assertRedirect();
        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('/oauth/callback?token=', $redirectUrl);
        $this->assertStringNotContainsString('email', $redirectUrl);
        $this->assertStringNotContainsString('password', $redirectUrl);
    }

    public function test_callback_creates_new_user()
    {
        $abstractUser = Mockery::mock(\Laravel\Socialite\Contracts\User::class);
        $abstractUser->shouldReceive('getId')->andReturn('54321');
        $abstractUser->shouldReceive('getName')->andReturn('New User');
        $abstractUser->shouldReceive('getNickname')->andReturn('newuser');
        $abstractUser->shouldReceive('getEmail')->andReturn('newuser@example.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://avatar.url');
        $abstractUser->id = '54321'; // Asegura la propiedad id

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver->stateless->user')
            ->andReturn($abstractUser);

        $this->get('/api/auth/github/callback');
        $this->assertDatabaseHas('users', [
            'github_id' => '54321',
            'email' => 'newuser@example.com',
            'name' => 'New User',
        ]);
    }

    public function test_callback_handles_exception_and_returns_error()
    {
        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver->stateless->user')
            ->andThrow(new \Exception('GitHub error'));

        $response = $this->get('/api/auth/github/callback');
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'error' => 'GitHub error',
        ]);
    }
}
