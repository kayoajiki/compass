<?php

namespace App\Services\FourPillars;

use App\Services\FourPillars\DTOs\Pillar;
use App\Services\FourPillars\Data\{HeavenlyStem, Maps};

class TssCalculator
{
    private function rel(HeavenlyStem $day, HeavenlyStem $target): string
    {
        $m = Maps::jushin();
        return $m[$day->value][$target->value] ?? '';
    }

    public function attach(Pillar $p, HeavenlyStem $day): Pillar
    {
        // 天干通変星
        $p->stemTss = $this->rel($day, $p->stem);
        
        // 蔵干通変星
        $hiddenStemsTss = [];
        foreach ($p->hiddenStems as $hs) {
            $hiddenStemsTss[] = $this->rel($day, $hs);
        }
        $p->hiddenStemsTss = array_values(array_filter($hiddenStemsTss));
        
        // 従来のtss（後方互換性のため）
        $names = [];
        $names[] = $p->stemTss;
        foreach ($p->hiddenStemsTss as $tss) {
            $names[] = $tss;
        }
        $p->tss = array_values(array_filter($names));
        
        return $p;
    }
}
