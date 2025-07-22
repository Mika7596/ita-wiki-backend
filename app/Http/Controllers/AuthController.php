<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class AuthController extends Controller
{
    //User register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'github_id' =>'required|int|in(1,999999999)|unique:users',
            'github_user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => "required|same:password",
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'github_id' => $request->github_id,
            'github_user_name' => $request->github_user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'user' =>$user,
            'access_token'=> $token,
            'token_type' =>'Bearer', 
            'message' => "User created successfully",
        ],
            Response::HTTP_CREATED); // 201

    }

   



}
