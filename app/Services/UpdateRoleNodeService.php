<?php

declare (strict_types= 1);

namespace App\Services;

use App\Models\Role;
use App\Models\RoleNode;
use Illuminate\Http\JsonResponse;

class UpdateRoleNodeService
{

    public function __invoke(array $data): JsonResponse
    {
        $authorizedRole = RoleNode::where('node_id', $data['authorized_node_id'])->first();
        $target = RoleNode::where('node_id', $data['node_id'])->first();

        if (!$authorizedRole || !$target) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $roleHierarchy = ['superadmin' => 4, 'admin' => 3, 'mentor' => 2, 'student' => 1];
        if ($roleHierarchy[$target->role] >= $roleHierarchy[$authorizedRole->role] 
          || $roleHierarchy[$data['role']] >= $roleHierarchy[$authorizedRole->role]) {
            return response()->json([
                'message' => 'You cannot update a role equal or higher than your own.'
            ], 403);
        }

        $target->role = $data['role'];
        $target->save();

        return response()->json([
            'message' => 'Role updated successfully.'
        ], 200);
    }

}