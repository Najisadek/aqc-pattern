<?php

declare(strict_types=1);

namespace App\AQC\V1\Order;

use InvalidArgumentException;
use App\Enums\OrderStatus;
use App\Models\Order;

final class UpdateOrderStatus
{
    public function handle(Order $order, string $status): Order
    {
        $newStatus = OrderStatus::tryFrom($status);

        if (! $newStatus) {

            throw new InvalidArgumentException('Invalid order status');
        }

        $allowedTransitions = [
            OrderStatus::Pending->value => [OrderStatus::Processing, OrderStatus::Cancelled],
            OrderStatus::Processing->value => [OrderStatus::Shipped, OrderStatus::Cancelled],
            OrderStatus::Shipped->value => [OrderStatus::Delivered],
            OrderStatus::Delivered->value => [OrderStatus::Refunded],
        ];

        $currentStatus = $order->status->value;
        
        $allowed = $allowedTransitions[$currentStatus] ?? [];

        if (! in_array($newStatus, $allowed, true)) {

            throw new InvalidArgumentException(
                "Cannot transition from {$currentStatus} to {$status}"
            );
        }

        $order->update(['status' => $newStatus]);

        return $order->fresh();
    }
}
