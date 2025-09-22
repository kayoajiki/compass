<?php

namespace App\Services\Ziwei;

use Carbon\Carbon;

class TimeAdjuster
{
    private array $prefectures;

    public function __construct()
    {
        $this->prefectures = config('ziwei.prefectures');
    }

    /**
     * 都道府県の経度に基づいて地方時を補正する
     */
    public function adjustTime(Carbon $inputTime, string $prefecture): Carbon
    {
        if (!isset($this->prefectures[$prefecture])) {
            throw new \InvalidArgumentException("都道府県 '{$prefecture}' が見つかりません");
        }

        $longitude = $this->prefectures[$prefecture];
        
        // 経度補正: (経度 - 135) × 4分
        $adjustmentMinutes = round(($longitude - 135) * 4);
        
        // サマータイム期間（1948-1951）の追加補正
        if ($this->isSummerTimePeriod($inputTime)) {
            $adjustmentMinutes += 60;
        }

        return $inputTime->copy()->addMinutes($adjustmentMinutes);
    }

    /**
     * サマータイム期間かどうかを判定
     */
    private function isSummerTimePeriod(Carbon $date): bool
    {
        $year = $date->year;
        
        // 1948-1951年のサマータイム期間
        if ($year >= 1948 && $year <= 1951) {
            // 5月第1日曜日から9月第2土曜日まで
            $mayFirstSunday = $this->getFirstSundayOfMonth($year, 5);
            $septemberSecondSaturday = $this->getSecondSaturdayOfMonth($year, 9);
            
            return $date->gte($mayFirstSunday) && $date->lte($septemberSecondSaturday);
        }
        
        return false;
    }

    /**
     * 指定月の第1日曜日を取得
     */
    private function getFirstSundayOfMonth(int $year, int $month): Carbon
    {
        $firstDay = Carbon::create($year, $month, 1);
        $dayOfWeek = $firstDay->dayOfWeek;
        $daysToAdd = $dayOfWeek === 0 ? 0 : 7 - $dayOfWeek;
        
        return $firstDay->addDays($daysToAdd);
    }

    /**
     * 指定月の第2土曜日を取得
     */
    private function getSecondSaturdayOfMonth(int $year, int $month): Carbon
    {
        $firstDay = Carbon::create($year, $month, 1);
        $dayOfWeek = $firstDay->dayOfWeek;
        $daysToAdd = $dayOfWeek === 6 ? 7 : (6 - $dayOfWeek) % 7 + 7;
        
        return $firstDay->addDays($daysToAdd);
    }

    /**
     * 都道府県の経度を取得
     */
    public function getLongitude(string $prefecture): float
    {
        if (!isset($this->prefectures[$prefecture])) {
            throw new \InvalidArgumentException("都道府県 '{$prefecture}' が見つかりません");
        }
        
        return $this->prefectures[$prefecture];
    }

    /**
     * 利用可能な都道府県リストを取得
     */
    public function getAvailablePrefectures(): array
    {
        return array_keys($this->prefectures);
    }
}
