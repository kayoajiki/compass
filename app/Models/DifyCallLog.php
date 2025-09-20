<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DifyCallLog extends Model
{
    protected $fillable = [
        'app_code',
        'success',
        'duration_ms',
        'http_status',
        'request_data',
        'response_data',
        'error_message',
    ];
    
    protected $casts = [
        'success' => 'boolean',
        'duration_ms' => 'integer',
        'http_status' => 'integer',
        'request_data' => 'array',
        'response_data' => 'array',
    ];
    
    public function scopeSuccessful($query)
    {
        return $query->where('success', true);
    }
    
    public function scopeFailed($query)
    {
        return $query->where('success', false);
    }
    
    public function scopeByAppCode($query, string $appCode)
    {
        return $query->where('app_code', $appCode);
    }
    
    public function scopeSlowQueries($query, int $threshold = 5000)
    {
        return $query->where('duration_ms', '>', $threshold);
    }
}
