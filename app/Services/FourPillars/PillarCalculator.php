<?php

namespace App\Services\FourPillars;

use App\Services\FourPillars\DTOs\Pillar;
use App\Services\FourPillars\Data\{HeavenlyStem, EarthlyBranch, Maps};
use DateTimeImmutable;

class PillarCalculator
{
    /** ▼JDNから日柱index（0..59）: 基準日を 1984-02-02 を甲子として実装してもOK */
    private function sexagenaryIndexFromDate(DateTimeImmutable $dt): int
    {
        // TODO: Excelの基準と合うよう destiny と同じ基準日を採用
        // ひとまず簡易：修正ユリウス日(MJD)ベースで 60剰余
        $jdn = $dt->getTimestamp() / 86400 + 2440588; // Unix timestamp to JDN
        return ($jdn % 60 + 60) % 60;
    }

    /** 日柱（切替 23:00） */
    public function buildDayPillar(DateTimeImmutable $dt, string $cutover = '23:00'): Pillar
    {
        [$h, $m] = array_map('intval', explode(':', $cutover));
        if ((int)$dt->format('H') < $h || ((int)$dt->format('H') == $h && (int)$dt->format('i') < $m)) {
            $dt = $dt->modify('-1 day');
        }
        
        $idx = $this->sexagenaryIndexFromDate($dt);
        $pair = Maps::sexagenary()[$idx];
        $hidden = Maps::hiddenStemsByBranch()[$pair['branch']->value] ?? [];
        
        return new Pillar($pair['stem'], $pair['branch'], $hidden);
    }

    /** 年柱（立春基準：暫定は暦年で算出→後で節気に差替） */
    public function buildYearPillar(DateTimeImmutable $dt): Pillar
    {
        $base = new DateTimeImmutable($dt->format('Y') . '-01-01 ' . $dt->format('H:i'), $dt->getTimezone());
        $idx = $this->sexagenaryIndexFromDate($base); // 暫定
        $pair = Maps::sexagenary()[$idx];
        $hidden = Maps::hiddenStemsByBranch()[$pair['branch']->value] ?? [];
        
        return new Pillar($pair['stem'], $pair['branch'], $hidden);
    }

    /** 月柱（寅月起点：暫定。節入りで後日補正） */
    public function buildMonthPillar(Pillar $year, DateTimeImmutable $dt): Pillar
    {
        $month = (int)$dt->format('n'); // 1..12
        $branches = [
            1 => '丑', 2 => '寅', 3 => '卯', 4 => '辰', 5 => '巳', 6 => '午',
            7 => '未', 8 => '申', 9 => '酉', 10 => '戌', 11 => '亥', 12 => '子'
        ];
        $branch = EarthlyBranch::from($branches[$month]);
        
        // 月干は年干に月次オフセットを加算（Excel式を移植）
        $yearStem = $year->stem->value;
        $stemOrder = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];
        $yIndex = array_search($yearStem, $stemOrder, true);
        $offset = [1 => 11, 2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 => 5, 8 => 6, 9 => 7, 10 => 8, 11 => 9, 12 => 10][$month];
        $stem = HeavenlyStem::from($stemOrder[($yIndex + $offset) % 10]);
        
        $hidden = Maps::hiddenStemsByBranch()[$branch->value] ?? [];
        
        return new Pillar($stem, $branch, $hidden);
    }

    /** 時柱：日干グループの子起点 → 2時間毎に干を+1 */
    public function buildHourPillar(Pillar $day, ?DateTimeImmutable $dt): ?Pillar
    {
        if (!$dt) return null;
        
        $h = (int)$dt->format('H');
        $slots = [
            [23, 1, '子'], [1, 3, '丑'], [3, 5, '寅'], [5, 7, '卯'], [7, 9, '辰'], [7, 9, '辰'],
            [9, 11, '巳'], [11, 13, '午'], [13, 15, '未'], [15, 17, '申'], [17, 19, '酉'], [19, 21, '戌'], [21, 23, '亥']
        ];
        
        foreach ($slots as [$s, $e, $b]) {
            $in = ($s >= $e) ? ($h >= $s || $h < $e) : ($h >= $s && $h < $e);
            if ($in) {
                $branch = EarthlyBranch::from($b);
                break;
            }
        }
        
        $start = Maps::hourStartByDayStem()[$day->stem->value]; // 子の起点干
        $order = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];
        $idxStart = array_search($start, $order, true);
        $branchOrder = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
        $pos = array_search($branch->value, $branchOrder, true);
        $stem = HeavenlyStem::from($order[($idxStart + $pos) % 10]);
        
        $hidden = Maps::hiddenStemsByBranch()[$branch->value] ?? [];
        
        return new Pillar($stem, $branch, $hidden);
    }
}
