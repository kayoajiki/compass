<?php

namespace App\Services\FourPillars;

use App\Services\FourPillars\DTOs\{BuildParams, FourPillarsResult};
use App\Services\FourPillars\Data\{Sex, HeavenlyStem};
use App\Services\FourPillars\Luck\{DaiunBuilder, AnnualLuckBuilder, MonthlyLuckBuilder};
use App\Models\Profile;
use DateTimeImmutable;
use DateTimeZone;

class FourPillarsService
{
    public function __construct(
        private PillarCalculator $pc,
        private TssCalculator $tss,
        private TwelveStageCalculator $ts,
        private FiveElementsCounter $fec,
        private DaiunBuilder $daiun,
        private AnnualLuckBuilder $annual,
        private MonthlyLuckBuilder $monthly,
    ) {}

    public function build(BuildParams $p): FourPillarsResult
    {
        $tz = new DateTimeZone($p->timezone);
        $dt = new DateTimeImmutable($p->birthDate . ' ' . ($p->birthTime ?? '00:00'), $tz);
        
        $day = $this->pc->buildDayPillar($dt, $p->dayPillarCutover);
        $year = $this->pc->buildYearPillar($dt);
        $month = $this->pc->buildMonthPillar($year, $dt);
        $hour = $this->pc->buildHourPillar($day, $p->birthTime ? $dt : null);
        
        // 通変星・十二運付与
        foreach ([$year, $month, $day, $hour] as &$pl) {
            if ($pl) {
                $pl = $this->tss->attach($pl, $day->stem);
                $pl->twelveStage = $this->ts->calc($day->stem, $pl->branch);
            }
        }
        
        $five = $this->fec->count(array_filter([$year, $month, $day, $hour]));
        
        // 大運：月柱を基準に生成 → 各行に通変星/十二運を日干基準で付与
        $daiunRows = $this->daiun->build($month, $dt, $p->sex);
        foreach ($daiunRows as &$r) {
            $r['tss'] = $this->tssName($day->stem->value, $r['pillar']['stem']);
            $r['twelveStage'] = $this->ts->calc($day->stem, \App\Services\FourPillars\Data\EarthlyBranch::from($r['pillar']['branch']));
        }
        
        // 年運・月運（任意範囲指定があれば）
        $annualRows = [];
        if ($p->annualFrom && $p->annualTo) {
            $annualRows = $this->annual->build($p->annualFrom, $p->annualTo);
            foreach ($annualRows as &$r) {
                $r['tss'] = $this->tssName($day->stem->value, $r['pillar']['stem']);
                $r['twelveStage'] = $this->ts->calc($day->stem, \App\Services\FourPillars\Data\EarthlyBranch::from($r['pillar']['branch']));
            }
        }
        
        $monthlyRows = [];
        if ($p->monthlyFrom && $p->monthlyTo) {
            $monthlyRows = $this->monthly->build($p->monthlyFrom, $p->monthlyTo);
            foreach ($monthlyRows as &$r) {
                $r['tss'] = $this->tssName($day->stem->value, $r['pillar']['stem']);
                $r['twelveStage'] = $this->ts->calc($day->stem, \App\Services\FourPillars\Data\EarthlyBranch::from($r['pillar']['branch']));
            }
        }
        
        return new FourPillarsResult($year, $month, $day, $hour, $five, $daiunRows, $annualRows, $monthlyRows);
    }

    /**
     * プロフィール情報から四柱推命の命式を作成
     */
    public function buildFromProfile(Profile $profile): FourPillarsResult
    {
        // プロフィール情報からBuildParamsを作成
        $params = new BuildParams(
            birthDate: $profile->birth_date->format('Y-m-d'),
            birthTime: $profile->birth_time ? $profile->birth_time->format('H:i') : null,
            sex: Sex::from($profile->sex),
            timezone: 'Asia/Tokyo',
            dayPillarCutover: '23:00',
            solarTermSource: 'approx',
            annualFrom: date('Y'),
            annualTo: date('Y') + 10,
            monthlyFrom: date('Y-m'),
            monthlyTo: date('Y-m', strtotime('+12 months'))
        );

        return $this->build($params);
    }

    private function tssName(string $dayStem, string $targetStem): string
    {
        $map = \App\Services\FourPillars\Data\Maps::jushin();
        return $map[$dayStem][$targetStem] ?? '';
    }
}
