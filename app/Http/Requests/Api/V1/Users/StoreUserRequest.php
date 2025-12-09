<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Users;

use App\Enums\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreUserRequest extends FormRequest
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
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\Rule>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'location' => [
                'required',
                'string',
                'max:255',
                // Must be in "city, country" format
                'regex:/^[\p{L}\p{M}\s\.\'\-]+,\s*[\p{L}\p{M}\s\.\'\-]+$/u',
            ],
            'role' => [
                'required',
                'string',
                Rule::in(array_map(static fn (Roles $role): string => $role->value, Roles::cases())),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'role.in' => 'The selected role is invalid.',
            'location.required' => 'The location field is required.',
            'location.regex' => 'The location must be in the format "city, country".',
        ];
    }
}
