<?php

namespace App\Domain\Calendar\Services;

use Carbon\Carbon;

class StemBranchService
{
    /**
     * 十干
     */
    private const TENKAN = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];

    /**
     * 十二支
     */
    private const JUNISHI = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];

    /**
     * 指定日の十干・十二支を返す
     *
     * @param Carbon $date
     * @return array{tenkan: string, chishi: string}
     */
    public function getDayKanShi(Carbon $date): array
    {
        // MVP: 簡易的な計算（実際の暦計算は後で実装）
        $dayNumber = abs($date->diffInDays(Carbon::parse('1900-01-01')));
        
        $tenkanIndex = $dayNumber % 10;
        $chishiIndex = $dayNumber % 12;

        return [
            'tenkan' => self::TENKAN[$tenkanIndex],
            'chishi' => self::JUNISHI[$chishiIndex],
        ];
    }
}
