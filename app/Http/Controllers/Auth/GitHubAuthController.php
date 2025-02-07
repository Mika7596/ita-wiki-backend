<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GitHubAuthController extends Controller
{
    public function redirectToGitHub()
    {
        $url = Socialite::driver('github')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    public function handleGitHubCallback()
    {
        $githubUser = Socialite::driver('github')->stateless()->user();

        User::updateOrCreate(
            ['github_id' => $githubUser->id],
            ['nickname' => $githubUser->nickname]
        );

        return response()->json([
            'message' => 'Usuario creado o actualizado correctamente',
            'github_nickname' => $githubUser->nickname,
            'github_id' => $githubUser->id
        ], 200);

    }
}
