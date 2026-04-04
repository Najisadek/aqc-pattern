<?php 

declare(strict_types=1);

namespace App\AQC\V1\Product;

use App\Models\Product;

final class UpdateProduct
{
    public function handle(Product $product, array $params = []): Product
    {
        $data = [
            'stock_quantity' => $params['stock_quantity'] ?? $product->stock_quantity,
            'name' => $params['name'] ?? $product->name,
            'description' => $params['description'] ?? $product->description,
            'sku' => $product->sku,
            'price' => $params['price'] ?? $product->price,
            'status' => $params['status'] ?? $product->status,
        ];

        $product->update($data);

        return $product->fresh();
    }
}