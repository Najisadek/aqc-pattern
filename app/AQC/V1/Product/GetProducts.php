<?php 

declare(strict_types=1);

namespace App\AQC\V1\Product;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetProducts
{
    public function handle(array $params = []): LengthAwarePaginator
    {
        $query = Product::latest();

        $this->applyFilters($query, $params);

        $this->applySearch($query, $params);

        return isset($params['per_page']) 
            ? $query->paginate((int)$params['per_page']) 
            : $query->paginate(15);
    }

    private function applyFilters($query, array $params): void
    {
        if (isset($params['status'])) {

            $query->where('status', $params['status']);
        }

        if (isset($params['min_price'])) {

            $query->where('price', '>=', $params['min_price']);
        }

        if (isset($params['max_price'])) {

            $query->where('price', '<=', $params['max_price']);
        }
    }

    private function applySearch($query, array $params = []): void
    {
        if (isset($params['search'])) {
            
            $query->where(function ($q) use ($params) {
                $q->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('description', 'like', "%{$params['search']}%");
            });
        }

        if (isset($params['sku'])) {
            
            $query->where('sku', $params['sku']);
        }
    }
}