<?php

namespace App\Domain\Chatbot\Services;

use App\Models\ChatbotUsage;
use App\Models\User;
use Carbon\Carbon;

class ChatbotUsageService
{
    /**
     * 指定ユーザーが指定ボットを利用可能かチェック
     *
     * @param int $userId
     * @param string $botKey
     * @return bool
     */
    public function canUse(int $userId, string $botKey): bool
    {
        $today = Carbon::today();
        
        // 今日の利用回数を取得
        $usage = ChatbotUsage::where('user_id', $userId)
            ->where('bot_key', $botKey)
            ->where('date', $today)
            ->first();
        
        $count = $usage ? $usage->count : 0;
        
        // 1回目は無料で許可
        if ($count === 0) {
            return true;
        }
        
        // 2回目以降はサブスク会員のみ
        $user = User::find($userId);
        return $user && $user->hasActiveSubscription();
    }

    /**
     * 利用回数をインクリメント
     *
     * @param int $userId
     * @param string $botKey
     * @return void
     */
    public function incrementUsage(int $userId, string $botKey): void
    {
        $today = Carbon::today();
        
        $usage = ChatbotUsage::where('user_id', $userId)
            ->where('bot_key', $botKey)
            ->where('date', $today)
            ->first();
        
        if ($usage) {
            $usage->increment('count');
        } else {
            ChatbotUsage::create([
                'user_id' => $userId,
                'bot_key' => $botKey,
                'date' => $today,
                'count' => 1,
            ]);
        }
    }

    /**
     * 今日の利用回数を取得
     *
     * @param int $userId
     * @param string $botKey
     * @return int
     */
    public function getTodayUsageCount(int $userId, string $botKey): int
    {
        $today = Carbon::today();
        
        $usage = ChatbotUsage::where('user_id', $userId)
            ->where('bot_key', $botKey)
            ->where('date', $today)
            ->first();
        
        return $usage ? $usage->count : 0;
    }
}
