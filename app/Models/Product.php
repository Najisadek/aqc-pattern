<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;

final class Product extends Model
{
    protected $fillable = [
        'stock_quantity',
        'name',
        'description',
        'sku',
        'price',
        'status',
    ];

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
