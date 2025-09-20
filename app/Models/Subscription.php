<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    use HasFactory;
    
    protected $table = 'subscriptions';
    
    protected $fillable = [
        'user_id',
        'name',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantity',
        'trial_ends_at',
        'ends_at',
    ];
    
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function isActive(): bool
    {
        return $this->stripe_status === 'active';
    }
    
    public function isOnGracePeriod(): bool
    {
        return $this->stripe_status === 'past_due' && $this->ends_at && $this->ends_at->isFuture();
    }
    
    public function isCanceled(): bool
    {
        return $this->stripe_status === 'canceled' || ($this->ends_at && $this->ends_at->isPast());
    }
}
