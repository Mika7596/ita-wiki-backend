<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'github_id' => 'required|string|min:25'
        ]);

        User::updateOrCreate(
            ['github_id' => $request->github_id]
        );

        return response()->json([
            'message' => 'User saved successfully',
        ], 200);
    }
}
