<?php

declare(strict_types=1);

namespace App\AQC\V1\User;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
