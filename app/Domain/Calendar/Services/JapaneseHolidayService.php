<?php

namespace App\Domain\Calendar\Services;

use Carbon\Carbon;

class JapaneseHolidayService
{
    /**
     * 指定日の祝日名を返す（MVP: 簡易実装）
     *
     * @param Carbon $date
     * @return string|null
     */
    public function getDayHoliday(Carbon $date): ?string
    {
        // MVP: 主要な祝日のみ簡易実装
        $month = $date->month;
        $day = $date->day;

        // 新年
        if ($month === 1 && $day === 1) return '元日';
        if ($month === 1 && $day === 8) return '成人の日'; // 簡易版（実際は第2月曜日）
        
        // 春
        if ($month === 2 && $day === 11) return '建国記念の日';
        if ($month === 2 && $day === 23) return '天皇誕生日';
        
        // 夏
        if ($month === 4 && $day === 29) return '昭和の日';
        if ($month === 5 && $day === 3) return '憲法記念日';
        if ($month === 5 && $day === 4) return 'みどりの日';
        if ($month === 5 && $day === 5) return 'こどもの日';
        
        // 秋
        if ($month === 9 && $day === 15) return '敬老の日'; // 簡易版（実際は第3月曜日）
        if ($month === 9 && $day === 23) return '秋分の日'; // 簡易版（実際は計算で決定）
        if ($month === 11 && $day === 3) return '文化の日';
        if ($month === 11 && $day === 23) return '勤労感謝の日';

        return null;
    }
}
