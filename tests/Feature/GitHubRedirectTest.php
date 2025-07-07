<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;

class GitHubRedirectTest extends TestCase
{
    public function test_github_redirect_returns_302_status()
    {
        $response = $this->get('/api/auth/github/redirect');

        $response->assertStatus(302);
    }

} 