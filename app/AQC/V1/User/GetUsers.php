<?php

declare(strict_types=1);

namespace App\AQC\V1\User;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;

final class GetUsers
{
    public function handle(array $params = []): LengthAwarePaginator
    {
        $query = User::latest();

        if (isset($params['search'])) {

            $query->where(function ($q) use ($params) {
                $q->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('email', 'like', "%{$params['search']}%");
            });
        }

        if (isset($params['role'])) {
            
            $query->where('role', $params['role']);
        }

        return isset($params['per_page'])
            ? $query->paginate((int) $params['per_page'])
            : $query->paginate();
    }
}
