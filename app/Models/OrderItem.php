<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price_cents',
        'subtotal_cents',
        'meta_json',
    ];

    protected $casts = [
        'meta_json' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUnitPriceAttribute(): float
    {
        return $this->unit_price_cents / 100;
    }

    public function getSubtotalAttribute(): float
    {
        return $this->subtotal_cents / 100;
    }

    public function getFormattedUnitPriceAttribute(): string
    {
        return '¥' . number_format($this->unit_price);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '¥' . number_format($this->subtotal);
    }
}
