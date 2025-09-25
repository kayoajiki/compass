<?php

namespace App\Services\FourPillars;

use App\Services\FourPillars\Data\{HeavenlyStem, EarthlyBranch, Maps};

class TwelveStageCalculator
{
    /**
     * 規則:
     * 陽干(甲丙戊庚壬) → 長生の支=『亥』から順行
     * 陰干(乙丁己辛癸) → 長生の支=『午』から逆行
     * 以降は [長生,沐浴,冠帯,建禄,帝旺,衰,病,死,墓,絶,胎,養] の並び。
     */
    public function calc(HeavenlyStem $dayStem, EarthlyBranch $branch): string
    {
        $yang = in_array($dayStem->value, ['甲', '丙', '戊', '庚', '壬'], true);
        $stages = Maps::twelveStages();
        $branches = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
        
        if ($yang) {
            $start = '亥'; // 長生
            $startIdx = array_search($start, $branches, true);
            $bIdx = array_search($branch->value, $branches, true);
            $diff = ($bIdx - $startIdx + 12) % 12;
            return $stages[$diff];
        } else {
            $start = '午'; // 長生（陰干は逆行）
            $startIdx = array_search($start, $branches, true);
            $bIdx = array_search($branch->value, $branches, true);
            $diff = ($startIdx - $bIdx + 12) % 12;
            return $stages[$diff];
        }
    }
}
