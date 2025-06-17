<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GitHubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    public function callback(Request $request)
    {
        $githubUser = Socialite::driver('github')->stateless()->user();

        return response()->json([
            'github_id' => $githubUser->getId(),
            'node_id' => $githubUser->user['node_id'] ?? null,
        ]);
    }
}