<?php

namespace App\Domain\Calendar\Services;

use App\Models\User;
use Carbon\Carbon;

class LuckRankService
{
    /**
     * 運勢ランクの種類
     */
    private const LUCK_RANKS = [
        '大吉', '吉', '中吉', '小吉', '凶'
    ];

    /**
     * 指定日の運勢ランクを返す（MVP: モック実装）
     *
     * @param User|object $subject
     * @param Carbon $date
     * @return string
     */
    public function getDayLuckRank($subject, Carbon $date): string
    {
        // MVP: 簡易的な計算（実際の運勢計算は後で実装）
        $dayNumber = abs($date->diffInDays(Carbon::parse('1900-01-01')));
        $index = $dayNumber % count(self::LUCK_RANKS);
        
        return self::LUCK_RANKS[$index];
    }
}
