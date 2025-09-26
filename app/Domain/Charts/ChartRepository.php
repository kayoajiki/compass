<?php

namespace App\Domain\Charts;

interface ChartRepository
{
    public function getByUserId(int $userId): ?UserChart;
}
