<?php

declare(strict_types=1);

namespace App\AQC\V1\Order;

use App\Models\Order;

final class DeleteOrder
{
    public function handle(Order $order): bool
    {
        if (! $order->status->canCancel()) {
            
            throw new \InvalidArgumentException('Only cancelled orders can be deleted');
        }

        return $order->delete();
    }
}
