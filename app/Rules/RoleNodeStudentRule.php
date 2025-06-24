<?php

declare (strict_types= 1);

namespace App\Rules;

use Closure;
use App\Models\RoleNode;
use Illuminate\Contracts\Validation\ValidationRule;

class RoleNodeStudentRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $role = RoleNode::where('node_id', $value)->first();
          
        if (!$role || $role->role !== 'student') {
            $fail('The node_id must belong to a student role.');
        }
    }
}
