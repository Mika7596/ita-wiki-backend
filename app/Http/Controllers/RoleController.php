<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    //
    public function getRoleByGithubId(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $request->validate([
            'github_id' => 'required|integer'
        ]);

        //$role = Role::where('github_id', $request->github_id)->first();
        $role = Role::where('github_id', $request->query('github_id'))->first();

        if (!$role) {
            $new = new Role;
            //$new->github_id = $request->github_id;
            $new->github_id = $request->query('github_id');
            $new->save();
            $new = Role::where('github_id', $request->query('github_id'))->first();

            return response()->json([
                'message' => 'Role not found. Created as new anonymous user.',
                'role' => [
                    'github_id' => $new->github_id,
                    'role' => $new->role
                ]
            ], 201);
        }

        return response()->json([
            'message' => 'Role found.',
            'role' => [
                'github_id' => $role->github_id,
                'role' => $role->role
            ]
        ], 200);
    }
}
