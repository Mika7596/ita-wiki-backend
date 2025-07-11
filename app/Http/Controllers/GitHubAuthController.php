<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class GitHubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    public function callback(Request $request)
{
    try {
        $githubUser = Socialite::driver('github')->stateless()->user();

        $user = User::updateOrCreate(
            ['github_id' => $githubUser->id],
            [
                'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                'email' => $githubUser->getEmail(),
                'avatar_url' => $githubUser->getAvatar(),
            ]
        );

        // Genera un token de Sanctum
        $token = $user->createToken('github')->plainTextToken;

        // Redirige al frontend con el token como query param
        return redirect(env('FRONTEND_URL', 'http://localhost:5173') . '/oauth/callback?token=' . $token);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 400);
    }
}
}