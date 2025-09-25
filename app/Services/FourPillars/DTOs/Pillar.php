<?php

namespace App\Services\FourPillars\DTOs;

use App\Services\FourPillars\Data\{HeavenlyStem, EarthlyBranch};

class Pillar
{
    public function __construct(
        public HeavenlyStem $stem,
        public EarthlyBranch $branch,
        /** @var HeavenlyStem[] */
        public array $hiddenStems = [], // 蔵干
        /** @var string[] */
        public array $tss = [], // 通変星（干／蔵干）
        public ?string $stemTss = null, // 天干通変星
        public array $hiddenStemsTss = [], // 蔵干通変星
        public ?string $twelveStage = null // 十二運
    ) {}
}
