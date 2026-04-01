<?php

declare(strict_types=1);

namespace App\AQC\V1\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class LoginUser
{
    public function handle(array $params = []): User
    {
        $user = User::where('email', $params['email'])->first();

        if (! $user || ! Hash::check($params['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user;
    }
}
