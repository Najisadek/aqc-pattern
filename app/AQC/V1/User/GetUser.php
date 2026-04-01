<?php

declare(strict_types=1);

namespace App\AQC\V1\User;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class GetUser
{
    public function handle(int $id): User
    {
        $user = User::find($id);

        if (! $user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user;
    }
}
