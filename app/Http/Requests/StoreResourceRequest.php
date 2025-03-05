<?php

declare (strict_types= 1);

namespace App\Http\Requests;

use App\Rules\RoleAnonymousRule;
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
        return [
            'github_id' => [
                'required',
                new RoleAnonymousRule(),
            ],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'url' => ['required', 'url'],
        ];
       
    }

    public function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        parent::failedValidation($validator);
    }    
}
