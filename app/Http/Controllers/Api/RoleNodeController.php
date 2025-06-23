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
