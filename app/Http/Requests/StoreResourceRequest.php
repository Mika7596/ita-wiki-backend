<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /*
        return [
            'id_github' => 'required',
            'title' => 'required',
            'url' => 'required',
        ];
        */

        return [
            'id_github' => [
                'required',
                'integer',
                'exists:roles,github_id',
                function ($_, $value, $fail) {
                    $role = Role::findOrFail($value);
                    if ($role->isAnonymous()) {
                        $fail('Cannot create resource for anonymous role.');
                    }
                },
            ],
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ];
    }
}