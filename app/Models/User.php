<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the user's profile
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * プロフィールとのリレーション
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * プロフィールが完成しているかチェック
     */
    public function hasCompletedProfile(): bool
    {
        return $this->profile && $this->profile->is_completed;
    }

    /**
     * プロフィールが存在するかチェック
     */
    public function hasProfile(): bool
    {
        return $this->profile !== null;
    }

    /**
     * アクティブなサブスクリプションを持っているかチェック
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscribed('default');
    }

    /**
     * 月額プランに加入しているかチェック
     */
    public function hasMonthlySubscription(): bool
    {
        return $this->subscribed('monthly');
    }

    /**
     * 年額プランに加入しているかチェック
     */
    public function hasYearlySubscription(): bool
    {
        return $this->subscribed('yearly');
    }

    /**
     * サブスクリプションの種類を取得
     */
    public function getSubscriptionType(): ?string
    {
        if ($this->hasYearlySubscription()) {
            return 'yearly';
        } elseif ($this->hasMonthlySubscription()) {
            return 'monthly';
        }
        return null;
    }

    /**
     * サブスクリプションの表示名を取得
     */
    public function getSubscriptionDisplayName(): ?string
    {
        $type = $this->getSubscriptionType();
        return match($type) {
            'monthly' => '月額プラン',
            'yearly' => '年額プラン',
            default => null,
        };
    }

    /**
     * 管理者かどうかチェック
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }
}
