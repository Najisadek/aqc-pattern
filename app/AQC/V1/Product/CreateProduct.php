<?php  

declare(strict_types=1);

namespace App\AQC\V1\Product;

use App\Models\Product;

final class CreateProduct
{
    public function handle(array $params = []): Product
    {
        return Product::create([
            'stock_quantity' => $params['stock_quantity'] ?? 0,
            'name' => $params['name'],
            'description' => $params['description'] ?? null,
            'sku' => $this->generateUniqueSku(),
            'price' => $params['price'] ?? 0.00,
            'status' => $params['status'] ?? 'draft',
        ]);
    }

    private function generateUniqueSku(): string 
    {
        do {
            $sku = 'SKU-' . strtoupper(bin2hex(random_bytes(4)));
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }
}