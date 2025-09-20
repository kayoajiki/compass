<?php

namespace App\Domain\Astrology\Services;

use Carbon\Carbon;

class RokuyoService
{
    /**
     * 六曜
     */
    private const ROKUYO = ['大安', '赤口', '先勝', '友引', '先負', '仏滅'];

    /**
     * 指定日の六曜を返す
     *
     * @param Carbon $date
     * @return string
     */
    public function getDayRokuyo(Carbon $date): string
    {
        // MVP: 簡易的な計算（実際の六曜計算は後で実装）
        $dayNumber = abs($date->diffInDays(Carbon::parse('1900-01-01')));
        $index = $dayNumber % count(self::ROKUYO);
        
        return self::ROKUYO[$index];
    }
}
