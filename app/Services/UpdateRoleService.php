<?php

declare (strict_types= 1);

namespace App\Services;

use App\Models\Role;
use Illuminate\Http\JsonResponse;

class UpdateRoleService
{
    public function __invoke(array $validated)
    {
        $authorizedRole = (Role::where('github_id', $validated['authorized_github_id'])->first())->role;

        $githubId = $validated['github_id'];
        $roleToUpdate = $validated['role'];

        return $this->processRoleUpdate($authorizedRole, $roleToUpdate, $githubId);
    }

    protected function getRoleLevel(string $role): int
    {
        $roles = ['superadmin'=> 4,'admin'=> 3,'mentor'=> 2,'student'=> 1];
        return $roles[$role] ?? 0; // it returns 0 if the role is not found
    }    

    protected function processRoleUpdate(string $authorizedRole, string $roleToUpdate, int $githubId): JsonResponse
    {
        $authorizedLevel = $this->getRoleLevel($authorizedRole);
        $currentLevel = $this->getRoleLevel(Role::where('github_id', $githubId)->first()->role);
        $updateLevel = $this->getRoleLevel($roleToUpdate);

        if ($authorizedLevel < $currentLevel) {
            return response()->json(['message' => 'No puedes actualizar un rol de orden superior al tuyo.'], 403);
        }

        if ($authorizedLevel ==  0 || $updateLevel == 0) {
            return response()->json(['message' => 'La petición contiene un rol inexistente.'], 422);
        }

        if ($updateLevel >= $authorizedLevel) {
            return response()->json(['message' => 'No puedes crear un rol igual o superior al tuyo.'], 403);
        }

        $role = Role::where('github_id', $githubId)->update([
            'role' => $roleToUpdate
        ]);

        if(!$role){
            return response()->json(['message'=> "No se pudo actualizar el Rol {$roleToUpdate} para el github_id {$githubId}"], 500);
        }

        return response()->json(['message' => "Se ha actualizado el Role {$roleToUpdate} para el github_id {$githubId}"], 200);
    }

}