<?php

namespace App\Services\FourPillars\DTOs;

class FourPillarsResult
{
    public function __construct(
        public Pillar $year,
        public Pillar $month,
        public Pillar $day,
        public ?Pillar $hour,
        public array $fiveElementsCount, // ['木'=>n,'火'=>n,'土'=>n,'金'=>n,'水'=>n]
        public array $daiun, // 10年刻み
        public array $annual, // 年運
        public array $monthly // 月運
    ) {}
}
