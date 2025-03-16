<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Retrieve a role by GitHub ID",
     *     description="Fetches a role using the provided GitHub ID. If the role does not exist, it returns an error.",
     *     @OA\Parameter(
     *         name="github_id",
     *         in="query",
     *         description="GitHub ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
     *         response=404,
     *         description="Role not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Role not found."),
     *             @OA\Property(
     *                 property="role",
     *                 type="null"
     *             )
     *         )
     *     )
     * )
     */

    public function getRoleWithGithubIdLogin(Request $request)
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