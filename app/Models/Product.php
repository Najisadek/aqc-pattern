<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;

#[Fillable(['stock_quantity', 'name', 'description', 'sku', 'price', 'status'])]
final class Product extends Model
{
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'status' => ProductStatus::class,
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}