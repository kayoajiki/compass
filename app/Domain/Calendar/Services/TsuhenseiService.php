<?php

namespace App\Domain\Calendar\Services;

use App\Models\User;
use Carbon\Carbon;

class TsuhenseiService
{
    /**
     * 通変星の種類
     */
    private const TSUHENSEI_TYPES = [
        '比肩', '劫財', '食神', '傷官', '偏財', '正財', '偏官', '正官', '偏印', '正印'
    ];

    /**
     * 指定日の通変星を返す（MVP: モック実装）
     *
     * @param User|object $subject
     * @param Carbon $date
     * @return string
     */
    public function getDayTsuhensei($subject, Carbon $date): string
    {
        // MVP: 簡易的な計算（実際の四柱推命計算は後で実装）
        $dayNumber = abs($date->diffInDays(Carbon::parse('1900-01-01')));
        $index = $dayNumber % count(self::TSUHENSEI_TYPES);
        
        return self::TSUHENSEI_TYPES[$index];
    }
}
