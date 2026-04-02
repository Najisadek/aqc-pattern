<?php

declare(strict_types=1);

namespace App\AQC\V1\User;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

final class UpdateUser
{
    public function handle(User $user, array $params = []): User
    {
        $data = [
            'name' => $params['name'] ?? $user->name,
            'email' => $params['email'] ?? $user->email,
        ];

        if (isset($params['password'])) {

            $data['password'] = Hash::make($params['password']);
        }

        $user->update($data);

        return $user->fresh();
    }
}
