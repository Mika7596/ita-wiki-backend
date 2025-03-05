<?php

declare (strict_types= 1);

namespace App\Rules;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RoleAnonymousRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $role = Role::where('github_id', $value)->firstOrFail();
            $roleValue = $role->role;
            if ($roleValue == 'anonymous') {
                $fail('Cannot create resource for anonymous role.');
            }
    }
}
