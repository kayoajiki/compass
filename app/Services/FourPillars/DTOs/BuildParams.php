<?php

namespace App\Services\FourPillars\DTOs;

use App\Services\FourPillars\Data\Sex;

class BuildParams
{
    public function __construct(
        public string $birthDate, // 'YYYY-MM-DD'
        public ?string $birthTime, // 'HH:MM' or null
        public Sex $sex,
        public string $timezone = 'Asia/Tokyo',
        public string $dayPillarCutover = '23:00', // 祖乃果さん仕様
        public string $solarTermSource = 'approx', // api|approx
        public ?int $annualFrom = null, // 例: 2025
        public ?int $annualTo = null, // 例: 2036
        public ?string $monthlyFrom = null, // 'YYYY-MM'
        public ?string $monthlyTo = null // 'YYYY-MM'
    ) {}
}
