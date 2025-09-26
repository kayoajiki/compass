<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFeatureTag extends Model
{
    protected $fillable = [
        'user_id',
        'theme',
        'tags',
        'sources',
        'score',
        'refreshed_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'sources' => 'array',
        'score' => 'float',
        'refreshed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
