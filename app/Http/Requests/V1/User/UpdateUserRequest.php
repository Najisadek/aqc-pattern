<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\User;

use Illuminate\Validation\{Rule, Rules\Password};
use Illuminate\Foundation\Http\FormRequest;

final class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['sometimes', 'confirmed', Password::min('8')],
        ];
    }
}
