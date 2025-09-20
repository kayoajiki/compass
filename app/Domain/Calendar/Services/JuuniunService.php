<?php

namespace App\Domain\Calendar\Services;

use App\Models\User;
use Carbon\Carbon;

class JuuniunService
{
    /**
     * 十二運の種類
     */
    private const JUNIUN_TYPES = [
        '長生', '沐浴', '冠帯', '建禄', '帝旺', '衰', '病', '死', '墓', '絶', '胎', '養'
    ];

    /**
     * 指定日の十二運を返す（MVP: モック実装）
     *
     * @param User|object $subject
     * @param Carbon $date
     * @return string
     */
    public function getDayJuuniun($subject, Carbon $date): string
    {
        // MVP: 簡易的な計算（実際の四柱推命計算は後で実装）
        $dayNumber = abs($date->diffInDays(Carbon::parse('1900-01-01')));
        $index = $dayNumber % count(self::JUNIUN_TYPES);
        
        return self::JUNIUN_TYPES[$index];
    }
}
