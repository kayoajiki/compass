<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mood extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'mood_score',
        'memo',
    ];

    protected $casts = [
        'date' => 'date',
        'mood_score' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
