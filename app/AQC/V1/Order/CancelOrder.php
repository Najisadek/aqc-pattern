<?php

declare(strict_types=1);

namespace App\AQC\V1\Order;

use Illuminate\Support\Facades\DB;
use App\Models\{Order, Product};
use InvalidArgumentException;
use App\Enums\OrderStatus;

final class CancelOrder
{
    public function handle(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            if (! $order->status->canCancel()) {
                
                throw new InvalidArgumentException(
                    'Order cannot be cancelled in current status'
                );
            }

            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)
                    ->increment('stock_quantity', $item->quantity);
            }

            $order->update(['status' => OrderStatus::Cancelled]);

            return $order->fresh();
        });
    }
}
