<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class AuthController extends Controller
{
    //User register antiguamente createRole en RoleController
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
          //  'github_id' =>'required|integer|min:1|max:9999999999|unique:users',
          //  'github_user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
           // 'password_confirmation' => 'required|same:password',
        ]);
        
        $user = User::create([
            'name' => $request->name,
          //  'github_id' => $request->github_id,
          //  'github_user_name' => $request->github_user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
        ], 201);         
    }
}
