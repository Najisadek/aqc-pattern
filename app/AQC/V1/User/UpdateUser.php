<?php

declare(strict_types=1);

namespace App\AQC\V1\User;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

final class UpdateUser
{
    public function handle(int $id, array $params = []): User
    {
        $user = User::find($id);

        if (! $user) {
            throw new ModelNotFoundException('User not found');
        }

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
