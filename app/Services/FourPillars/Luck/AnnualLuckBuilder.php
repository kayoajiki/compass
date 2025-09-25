<?php

namespace App\Services\FourPillars\Luck;

use App\Services\FourPillars\Data\{HeavenlyStem, EarthlyBranch, Maps};

class AnnualLuckBuilder
{
    /** 年運：from..to の各年の干支（暫定=暦年。立春基準は後でCalendarへ切替） */
    public function build(int $fromYear, int $toYear): array
    {
        $rows = [];
        $baseIdx = 0; // TODO: 年干支の基準年indexに合わせて正式化
        
        for ($y = $fromYear; $y <= $toYear; $y++) {
            $idx = ($baseIdx + ($y - $fromYear)) % 60;
            $p = Maps::sexagenary()[$idx];
            $rows[] = [
                'year' => $y,
                'pillar' => ['stem' => $p['stem']->value, 'branch' => $p['branch']->value],
            ];
        }
        
        return $rows;
    }
}
