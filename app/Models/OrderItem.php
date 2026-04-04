<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable('product_id', 'order_id', 'quantity', 'unit_price', 'total_price')]
final class OrderItem extends Model
{
    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
