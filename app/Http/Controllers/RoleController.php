<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/roles",
    *     summary="Retrieve a role by GitHub ID",
    *     description="Fetches a role using the provided GitHub ID. If the role does not exist, it creates a new role for the user as anonymous.",
    *     @OA\Response(
    *         response=200,
    *         description="Role found",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Role found."),
    *             @OA\Property(
    *                 property="role",
    *                 type="object",
    *                 ref="#/components/schemas/Role"
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Role not found, created as a new anonymous user",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Role not found. Created as new anonymous user."),
    *             @OA\Property(
    *                 property="role",
    *                 type="object",
    *                 ref="#/components/schemas/Role"
    *             )
    *         )
    *     )
    * )
    */

    public function githubLogin(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $request->validate([
            'github_id' => 'required|integer'
        ]);

        $githubId = $request->input('github_id', $request->query('github_id'));
        $role = Role::where('github_id', $githubId)->first();

        if (!$role) {
            return response()->json([
                'message' => 'Role not found.',
                'role' => null
            ], 404); 
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