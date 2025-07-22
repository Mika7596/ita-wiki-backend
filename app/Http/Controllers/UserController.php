<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class); 
        return User::all();
    }


    /**
     * Display the specified resource.
     * GET    api/user/{id}   Read User 
     * Para admins o usuarios con permisos
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return $user;
    }

    /**
     * Update user profile in storage.
     * PUT    api/user/{id}   Actualiza User    
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $user->update($request->only(['name', 'level', 'email']));
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE api/users/{id}  Borra usuario  
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
