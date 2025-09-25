<?php

namespace App\Services\FourPillars\Luck;

use App\Services\FourPillars\Data\{Sex};
use App\Services\FourPillars\DTOs\Pillar;
use App\Services\FourPillars\Data\{HeavenlyStem, EarthlyBranch, Maps};

class DaiunBuilder
{
    /**
     * 簡易仕様:
     * - 起運年齢は一旦 6歳（Excelの例と同じ体裁）→後で節入り差補正に置換可能
     * - 男性=順行 / 女性=逆行（一般的規則）で 10年刻み8行生成
     * - 大運の干支は「月柱の次」から回すのが通例（詳細はExcel式に合わせて調整可）
     */
    public function build(Pillar $monthPillar, \DateTimeImmutable $birth, Sex $sex): array
    {
        $order60 = Maps::sexagenary();
        
        // 月柱の index を取得
        $idxMonth = null;
        foreach ($order60 as $i => $p) {
            if ($p['stem'] === $monthPillar->stem && $p['branch'] === $monthPillar->branch) {
                $idxMonth = $i;
                break;
            }
        }
        if ($idxMonth === null) $idxMonth = 0;
        
        $forward = $sex === Sex::Male; // 簡易規則
        $rows = [];
        $start = 0;
        $age = 0;
        $age += 6; // 0-6, 6-16, ...
        
        for ($k = 0; $k < 8; $k++) {
            $step = $forward ? ($idxMonth + 1 + $k) : ($idxMonth + 1 - $k + 60);
            $pair = $order60[$step % 60];
            $stem = $pair['stem']->value;
            $branch = $pair['branch']->value;
            
            $rows[] = [
                'start_age' => $age + ($k == 0 ? -6 : ($k - 1) * 10 + 6),
                'end_age' => $age + $k * 10,
                'pillar' => ['stem' => $stem, 'branch' => $branch],
                // tss / twelveStage はFourPillarsService側で日干基準で付与する
            ];
        }
        
        return $rows;
    }
}
