<?php

declare (strict_types= 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRoleNodeRequest;
use App\Http\Requests\UpdateRoleNodeRequest;
use App\Services\CreateRoleNodeService;
use App\Services\UpdateRoleNodeService;
use App\Rules\NodeIdRule;
use App\Models\Role;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\JsonResponse;


class RoleNodeController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/roles-node",
     *     summary="Create a new role using node_id",
     *     tags={"RolesNode"},
     *     description="Allows an authorized user to create a new role for a specific GitHub node_id.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"node_id", "role", "authorized_node_id"},
     *             @OA\Property(property="node_id", type="string", example="MDQ6VXNlcjY3Mjk2MDg=", description="GitHub node_id of the user to assign the role"),
     *             @OA\Property(property="role", type="string", example="mentor", description="Role to be assigned"),
     *             @OA\Property(property="authorized_node_id", type="string", example="MDQ6VXNlcjE=", description="GitHub node_id of the user making the request (must have permissions)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Role created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Role created successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized: Cannot create a role equal or higher than your own",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="You cannot create a role equal or higher than your own.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The request contains an invalid role.")
     *         )
     *     )
     * )
     */

    public function createRoleNode(CreateRoleNodeRequest $request, CreateRoleNodeService $createRoleNodeService): JsonResponse
    {
        return $createRoleNodeService($request->validated());
    }


    
    //to be added as the transition advances
    public function updateRoleNode(UpdateRoleNodeRequest $request, UpdateRoleNodeService $updateRoleNodeService): JsonResponse
    {
        return $updateRoleNodeService($request->validated());
    }

    public function getRoleByGithubId(Request $request)
    {
        //
    }

    // Feature Flag : Role Self Assignment
    public function roleSelfAssignment(Request $request)
    {
        //
    }

}
