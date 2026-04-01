<?php

declare(strict_types=1);

namespace App\AQC\V1\User;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

final class CreateUser
{
    public function handle(array $params = []): User
    {
        return User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);
    }
}
