<?php

namespace App\Services\Ziwei;

use Carbon\Carbon;

class LunarConverter
{
    /**
     * 西暦日時を旧暦・干支・時支に変換
     */
    public function toLunar(Carbon $localTime): LunarDTO
    {
        // 簡易的な旧暦変換（実際の実装ではより精密な計算が必要）
        $lunarDate = $this->convertToLunar($localTime);
        
        // 年干支を計算
        $yearStem = $this->getYearStem($localTime->year);
        $yearBranch = $this->getYearBranch($localTime->year);
        
        // 時支を計算
        $timeBranch = $this->getTimeBranch($localTime->hour, $localTime->minute);
        
        return new LunarDTO(
            year: $lunarDate['year'],
            month: $lunarDate['month'],
            day: $lunarDate['day'],
            yearStem: $yearStem,
            yearBranch: $yearBranch,
            timeBranch: $timeBranch,
            isLeapMonth: $lunarDate['isLeapMonth'] ?? false
        );
    }

    /**
     * 簡易的な旧暦変換（実際の実装では精密な計算が必要）
     */
    private function convertToLunar(Carbon $date): array
    {
        // 簡易実装：実際の旧暦変換は複雑な計算が必要
        // ここでは基本的な変換ロジックを実装
        
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;
        
        // 簡易的な旧暦変換（実際には天文計算が必要）
        $lunarYear = $year;
        $lunarMonth = $month;
        $lunarDay = $day;
        
        // 閏月の判定（簡易版）
        $isLeapMonth = false;
        
        return [
            'year' => $lunarYear,
            'month' => $lunarMonth,
            'day' => $lunarDay,
            'isLeapMonth' => $isLeapMonth
        ];
    }

    /**
     * 年干を取得
     */
    private function getYearStem(int $year): string
    {
        $stems = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];
        return $stems[($year - 4) % 10];
    }

    /**
     * 年支を取得
     */
    private function getYearBranch(int $year): string
    {
        $branches = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
        return $branches[($year - 4) % 12];
    }

    /**
     * 時支を取得
     */
    private function getTimeBranch(int $hour, int $minute): string
    {
        $branches = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
        
        // 子時は23:00-00:59、0:00以降は翌日扱い
        if ($hour == 0) {
            $hour = 24;
        }
        
        // 2時間で1つの時支
        $timeIndex = intval(($hour + 1) / 2) % 12;
        
        return $branches[$timeIndex];
    }

    /**
     * 月干を取得（五虎遁）
     */
    public function getMonthStem(string $yearStem, string $monthBranch): string
    {
        $wuhuDun = config('ziwei.main_star_rules.wuhu_dun');
        
        if (!isset($wuhuDun[$yearStem][$monthBranch])) {
            throw new \InvalidArgumentException("年干 '{$yearStem}' と月支 '{$monthBranch}' の組み合わせが見つかりません");
        }
        
        return $wuhuDun[$yearStem][$monthBranch];
    }

    /**
     * 五行局を取得
     */
    public function getFiveElementsJu(string $yearStem): string
    {
        $fiveElementsJu = config('ziwei.main_star_rules.five_elements_ju');
        
        if (!isset($fiveElementsJu[$yearStem])) {
            throw new \InvalidArgumentException("年干 '{$yearStem}' の五行局が見つかりません");
        }
        
        return $fiveElementsJu[$yearStem];
    }
}

/**
 * 旧暦データのDTO
 */
class LunarDTO
{
    public function __construct(
        public int $year,
        public int $month,
        public int $day,
        public string $yearStem,
        public string $yearBranch,
        public string $timeBranch,
        public bool $isLeapMonth = false
    ) {}

    public function getYearGanzhi(): string
    {
        return $this->yearStem . $this->yearBranch;
    }

    public function getMonthGanzhi(): string
    {
        // 月干は別途計算が必要
        return $this->yearStem . $this->yearBranch; // 簡易実装
    }
}
