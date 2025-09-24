<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'type',
        'price_cents',
        'currency',
        'stock',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }

    public function getPriceAttribute(): float
    {
        return $this->price_cents / 100;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '¥' . number_format($this->price);
    }

    public function isInStock(): bool
    {
        if ($this->stock === null) {
            return true; // unlimited stock
        }
        return $this->stock > 0;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * 商品画像のURLを取得
     */
    public function getImageUrlAttribute(): ?string
    {
        if (isset($this->metadata['image'])) {
            return asset('storage/' . $this->metadata['image']);
        }
        return null;
    }

    /**
     * 商品画像のパスを取得
     */
    public function getImagePathAttribute(): ?string
    {
        return $this->metadata['image'] ?? null;
    }
}
