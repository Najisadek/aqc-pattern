<?php

declare(strict_types=1);

namespace App\AQC\V1\Order;

use Illuminate\Support\Facades\DB;
use App\Models\{Product, Order};
use InvalidArgumentException;
use App\Enums\OrderStatus;

final class CreateOrder
{
    public function handle(array $params = []): Order
    {
        return DB::transaction(function () use ($params) {

            ['items' => $orderItems, 'totalAmount' => $totalAmount] = $this->processOrderItems($params['items']);

            $order = $this->createOrder($params, $totalAmount);

            $this->attachOrderItems($order, $orderItems);

            return $order->fresh()->load('items');
        });
    }

    private function processOrderItems(array $items): array
    {
        $orderItems = [];
        
        $totalAmount = 0;

        foreach ($items as $item) {
            $product = $this->findProduct($item['product_id']);

            $this->validateProductStock($product, $item['quantity']);

            $itemTotal = $product->price * $item['quantity'];
            
            $totalAmount += $itemTotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'total_price' => $itemTotal,
            ];

            $product->decrement('stock_quantity', $item['quantity']);
        }

        return [
            'items' => $orderItems,
            'totalAmount' => $totalAmount,
        ];
    }

    private function findProduct(int $productId): Product
    {
        $product = Product::find($productId);

        if (! $product) {

            throw new InvalidArgumentException("Product {$productId} not found");
        }

        return $product;
    }

    private function validateProductStock(Product $product, int $quantity): void
    {
        if ($product->stock_quantity < $quantity) {

            throw new InvalidArgumentException("Insufficient stock for product: {$product->name}");
        }
    }

    private function createOrder(array $params, float $totalAmount): Order
    {
        return Order::create([
            'user_id' => $params['user_id'],
            'status' => OrderStatus::Pending,
            'total_amount' => $totalAmount,
            'address' => $params['address'],
            'notes' => $params['notes'] ?? null,
        ]);
    }

    private function attachOrderItems(Order $order, array $orderItems): void
    {
        $order->items()->createMany($orderItems);
    }
}