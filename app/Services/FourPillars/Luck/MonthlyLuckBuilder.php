<?php

namespace App\Services\FourPillars\Luck;

use App\Services\FourPillars\Data\{HeavenlyStem, EarthlyBranch, Maps};

class MonthlyLuckBuilder
{
    /** 月運：'YYYY-MM' 範囲で月干支（暫定=寅=正月／暦月割当）。節入りは後でCalendarへ。 */
    public function build(string $fromYm, string $toYm): array
    {
        [$fy, $fm] = array_map('intval', explode('-', $fromYm));
        [$ty, $tm] = array_map('intval', explode('-', $toYm));
        
        $rows = [];
        $y = $fy;
        $m = $fm;
        $stemOrder = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];
        $branchMap = [1 => '丑', 2 => '寅', 3 => '卯', 4 => '辰', 5 => '巳', 6 => '午', 7 => '未', 8 => '申', 9 => '酉', 10 => '戌', 11 => '亥', 12 => '子'];
        $i = 0;
        
        while ($y < $ty || ($y == $ty && $m <= $tm)) {
            $branch = $branchMap[$m];
            // 仮：年干起点からのオフセット（後に年干・節入りで厳密化）
            $stem = $stemOrder[($i) % 10];
            $rows[] = ['ym' => sprintf('%04d-%02d', $y, $m), 'pillar' => ['stem' => $stem, 'branch' => $branch]];
            $i++;
            $m++;
            if ($m == 13) {
                $m = 1;
                $y++;
            }
        }
        
        return $rows;
    }
}
