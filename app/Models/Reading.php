<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reading extends Model
{
    protected $fillable = [
        'user_id',
        'person_id',
        'product_id',
        'status',
        'title',
        'summary',
        'json_result',
        'notes',
    ];

    protected $casts = [
        'json_result' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'person_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isReady(): bool
    {
        return $this->status === 'ready';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending_generation';
    }

    public function isGenerating(): bool
    {
        return $this->status === 'generating';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }
}
