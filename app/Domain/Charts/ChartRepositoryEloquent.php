<?php

namespace App\Domain\Charts;

use App\Models\UserChart;

class ChartRepositoryEloquent implements ChartRepository
{
    public function getByUserId(int $userId): ?UserChart
    {
        return UserChart::where('user_id', $userId)->first();
    }
}
