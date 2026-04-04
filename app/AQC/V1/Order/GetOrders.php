<?php

declare(strict_types=1);

namespace App\AQC\V1\Order;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Order;

final class GetOrders
{
    public function handle(array $params = []): LengthAwarePaginator
    {
        $query = Order::with(['user', 'items.product'])->orderByDesc('created_at');

        $this->applyFilters($query, $params);

        return isset($params['per_page']) 
            ? $query->paginate($params['per_page']) 
            : $query->paginate(15);
    }

    private function applyFilters($query, array $params): void
    {
        if (isset($params['user_id'])) {

            $query->where('user_id', $params['user_id']);
        }

        if (isset($params['status'])) {

            $query->where('status', $params['status']);
        }

        if (isset($params['date_from'])) {

            $query->whereDate('created_at', '>=', $params['date_from']);
        }

        if (isset($params['date_to'])) {
            
            $query->whereDate('created_at', '<=', $params['date_to']);
        }
    }
}
