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
            /*Validate de terms an condition box with a boolean
            terms_accepted' => 'required|boolean'*/
        ]);

        /*verify if the terms and conditions were accepted
        if (!$request->input('terms_accepted')) {
            return response()->json([
                'message' => 'You must accept the terms and conditions to log in.',
            ], 400); // Error 400: Bad Request
        }*/

        //Get githubId
        $githubId = $request->input('github_id', $request->query('github_id'));
        $role = Role::where('github_id', $githubId)->first();

        if (!$role) {
            $new = new Role;
            $new->github_id = $githubId;
            $new->save();
            $new = Role::where('github_id', $githubId)->first();

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
