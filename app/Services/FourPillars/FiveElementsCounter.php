<?php

namespace App\Services\FourPillars;

use App\Services\FourPillars\DTOs\Pillar;
use App\Services\FourPillars\Data\Maps;

class FiveElementsCounter
{
    /** @param Pillar[] $pillars */
    public function count(array $pillars): array
    {
        $stem = Maps::elementOfStem();
        $br = Maps::elementOfBranch();
        $c = ['木' => 0, '火' => 0, '土' => 0, '金' => 0, '水' => 0];
        
        foreach ($pillars as $p) {
            if (!$p) continue;
            
            $c[$stem[$p->stem->value]]++;
            $c[$br[$p->branch->value]]++;
            foreach ($p->hiddenStems as $hs) {
                $c[$stem[$hs->value]]++; // 本中余の重みは後で調整可
            }
        }
        
        return $c;
    }
}
