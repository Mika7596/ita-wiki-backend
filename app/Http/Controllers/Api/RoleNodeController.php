<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleNodeRequest;
use App\Http\Requests\UpdateRoleNodeRequest;
use App\Models\Role;
use App\Services\CreateRoleNodeService;
use App\Services\UpdateRoleNodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleNodeController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/roles-node",
     *     summary="Create a new role using node_id",
     *     tags={"RolesNode"},
     *     description="Allows an authorized user to create a new role for a specific GitHub node_id.
     *
     *     Note: The 'node_id' field must be unique. If you receive a 'has already been taken' error, please use a different value for 'node_id'.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"node_id", "role", "authorized_node_id"},
     *             @OA\Property(
     *                 property="node_id",
     *                 type="string",
     *                 example="MDQ6VXNlcjUNIQUE=",
     *                 description="GitHub node_id of the user to assign the role. Must be unique and not already exist in the database."
     *             ),
     *             @OA\Property(
     *                 property="role",
     *                 type="string",
     *                 enum={"superadmin", "admin", "mentor", "student"},
     *                 example="mentor",
     *                 description="Role to be assigned"
     *             ),
     *             @OA\Property(
     *                 property="authorized_node_id",
     *                 type="string",
     *                 example="MDQ6VXNlcjE=",
     *                 description="GitHub node_id of the user making the request (must have permissions, e.g. superadmin)"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Role created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Role created successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized: Cannot create a role equal or higher than your own",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You cannot create a role equal or higher than your own.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="authorized_node_id", type="array", @OA\Items(type="string"), example={"The selected authorized node id is invalid."}),
     *             @OA\Property(property="message", type="string", example="The request contains an invalid role.")
     *         )
     *     )
     * )
     */

    public function createRoleNode(CreateRoleNodeRequest $request, CreateRoleNodeService $createRoleNodeService): JsonResponse
    {
        return $createRoleNodeService($request->validated());
    }

    /**
     * @OA\Put(
     *     path="/api/roles-node",
     *     summary="Update an existing role using node_id",
     *     tags={"RolesNode"},
     *     description="Allows an authorized user to update the role of a specific GitHub node_id.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"node_id", "role", "authorized_node_id"},
     *             @OA\Property(property="node_id", type="string", example="MDQ6VXNlcjY3Mjk2MDg=", description="GitHub node_id of the user to update the role"),
     *             @OA\Property(property="role", type="string", enum={"superadmin", "admin", "mentor", "student"}, example="mentor", description="Role to be assigned"),
     *             @OA\Property(property="authorized_node_id", type="string", example="MDQ6VXNlcjE=", description="GitHub node_id of the user making the request (must have permissions, e.g. superadmin)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Role updated successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized: Cannot update a role of user of equal or higher role rank or make an update to an equal or higher rank than your own",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="You cannot update a role that is equal or higher than your own.")
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
    public function updateRoleNode(UpdateRoleNodeRequest $request, UpdateRoleNodeService $updateRoleNodeService): JsonResponse
    {
        return $updateRoleNodeService($request->validated());
    }

    //to be added as the transition advances
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
