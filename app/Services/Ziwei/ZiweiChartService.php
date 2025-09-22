<?php

namespace App\Services\Ziwei;

use Carbon\Carbon;

class ZiweiChartService
{
    private TimeAdjuster $timeAdjuster;
    private LunarConverter $lunarConverter;
    private PalaceCalculator $palaceCalculator;
    private StarAllocator $starAllocator;
    private TransformApplier $transformApplier;

    public function __construct(
        TimeAdjuster $timeAdjuster,
        LunarConverter $lunarConverter,
        PalaceCalculator $palaceCalculator,
        StarAllocator $starAllocator,
        TransformApplier $transformApplier
    ) {
        $this->timeAdjuster = $timeAdjuster;
        $this->lunarConverter = $lunarConverter;
        $this->palaceCalculator = $palaceCalculator;
        $this->starAllocator = $starAllocator;
        $this->transformApplier = $transformApplier;
    }

    /**
     * 命盤を生成
     */
    public function generateChart(string $date, string $time, string $prefecture): array
    {
        // 入力値を検証
        $this->validateInputs($date, $time, $prefecture);

        // 西暦日時を作成
        $inputTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
        
        // 地方時を補正
        $localTime = $this->timeAdjuster->adjustTime($inputTime, $prefecture);
        
        // 旧暦・干支・時支を算出
        $lunar = $this->lunarConverter->toLunar($localTime);
        
        // 五行局を取得
        $fiveElementsJu = $this->lunarConverter->getFiveElementsJu($lunar->yearStem);
        
        // 命宮を計算
        $mingPalace = $this->palaceCalculator->calculateMingPalace($lunar->month, $lunar->timeBranch);
        
        // 十二宮を計算
        $palaces = $this->palaceCalculator->getCompletePalaces(
            $lunar->yearStem,
            $lunar->month,
            $lunar->timeBranch
        );
        
        // 14主星を配置
        $palaces = $this->starAllocator->allocateMainStars(
            $palaces,
            $fiveElementsJu,
            $lunar->day
        );
        
        // 六吉星を配置
        $palaces = $this->starAllocator->allocateLuckyStars(
            $palaces,
            $lunar->month,
            $lunar->yearStem,
            $lunar->timeBranch
        );
        
        // 四煞星を配置
        $palaces = $this->starAllocator->allocateMaleficStars(
            $palaces,
            $lunar->yearBranch,
            $lunar->timeBranch
        );
        
        // 四化を適用
        $result = $this->transformApplier->applyTransforms($palaces, $lunar->yearStem);
        
        // 結果を整形
        return $this->formatChartResult($result, $lunar, $fiveElementsJu, $mingPalace, $localTime);
    }

    /**
     * 入力値を検証
     */
    private function validateInputs(string $date, string $time, string $prefecture): void
    {
        // 日付の検証
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new \InvalidArgumentException('日付は YYYY-MM-DD 形式で入力してください');
        }

        // 時間の検証
        if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
            throw new \InvalidArgumentException('時間は HH:MM 形式で入力してください');
        }

        // 都道府県の検証
        $availablePrefectures = $this->timeAdjuster->getAvailablePrefectures();
        if (!in_array($prefecture, $availablePrefectures)) {
            throw new \InvalidArgumentException("都道府県 '{$prefecture}' は利用できません");
        }
    }

    /**
     * 結果を整形
     */
    private function formatChartResult(array $result, LunarDTO $lunar, string $fiveElementsJu, string $mingPalace, Carbon $localTime): array
    {
        return [
            'meta' => [
                'input_date' => $localTime->format('Y-m-d'),
                'input_time' => $localTime->format('H:i'),
                'local_date' => $localTime->format('Y-m-d'),
                'local_time' => $localTime->format('H:i'),
                'lunar' => [
                    'year' => $lunar->year,
                    'month' => $lunar->month,
                    'day' => $lunar->day,
                    'year_ganzhi' => $lunar->getYearGanzhi(),
                    'time_branch' => $lunar->timeBranch,
                    'is_leap_month' => $lunar->isLeapMonth
                ],
                'five_elements_ju' => $fiveElementsJu,
                'ming_palace' => $mingPalace
            ],
            'palaces' => $result['palaces'],
            'transforms' => $result['transforms'],
            'statistics' => [
                'total_stars' => $this->countTotalStars($result['palaces']),
                'transform_stats' => $this->transformApplier->getTransformStats($result['palaces']),
                'transform_distribution' => $this->transformApplier->getTransformDistribution($result['palaces'])
            ]
        ];
    }

    /**
     * 星の総数をカウント
     */
    private function countTotalStars(array $palaces): int
    {
        $count = 0;
        foreach ($palaces as $palace) {
            if (isset($palace['stars'])) {
                $count += count($palace['stars']);
            }
        }
        return $count;
    }

    /**
     * 命盤の詳細情報を取得
     */
    public function getChartDetails(array $chart): array
    {
        $details = [
            'basic_info' => $chart['meta'],
            'palace_analysis' => [],
            'star_analysis' => [],
            'transform_analysis' => []
        ];

        // 各宮の分析
        foreach ($chart['palaces'] as $palace) {
            $details['palace_analysis'][] = [
                'name' => $palace['name'],
                'zhi' => $palace['zhi'],
                'stem' => $palace['stem'] ?? '?',
                'star_count' => isset($palace['stars']) ? count($palace['stars']) : 0,
                'main_stars' => $this->getMainStars($palace),
                'lucky_stars' => $this->getLuckyStars($palace),
                'malefic_stars' => $this->getMaleficStars($palace)
            ];
        }

        // 星の分析
        $details['star_analysis'] = $this->analyzeStars($chart['palaces']);

        // 四化の分析
        $details['transform_analysis'] = $this->analyzeTransforms($chart['transforms']);

        return $details;
    }

    /**
     * 主星を取得
     */
    private function getMainStars(array $palace): array
    {
        if (!isset($palace['stars'])) {
            return [];
        }

        return array_filter($palace['stars'], function($star) {
            return $star['type'] === 'main';
        });
    }

    /**
     * 吉星を取得
     */
    private function getLuckyStars(array $palace): array
    {
        if (!isset($palace['stars'])) {
            return [];
        }

        return array_filter($palace['stars'], function($star) {
            return $star['type'] === 'lucky';
        });
    }

    /**
     * 凶星を取得
     */
    private function getMaleficStars(array $palace): array
    {
        if (!isset($palace['stars'])) {
            return [];
        }

        return array_filter($palace['stars'], function($star) {
            return $star['type'] === 'malefic';
        });
    }

    /**
     * 星の分析
     */
    private function analyzeStars(array $palaces): array
    {
        $analysis = [
            'main_stars' => [],
            'lucky_stars' => [],
            'malefic_stars' => []
        ];

        foreach ($palaces as $palace) {
            if (!isset($palace['stars'])) {
                continue;
            }

            foreach ($palace['stars'] as $star) {
                $starInfo = [
                    'name' => $star['label'],
                    'palace' => $palace['name'],
                    'transform' => $star['transform'] ?? null
                ];

                $analysis[$star['type'] . '_stars'][] = $starInfo;
            }
        }

        return $analysis;
    }

    /**
     * 四化の分析
     */
    private function analyzeTransforms(array $transforms): array
    {
        $analysis = [
            '禄' => [],
            '権' => [],
            '科' => [],
            '忌' => []
        ];

        foreach ($transforms as $transform) {
            $analysis[$transform['type']][] = [
                'star' => $transform['star'],
                'palace' => $transform['palace']
            ];
        }

        return $analysis;
    }

    /**
     * 利用可能な都道府県を取得
     */
    public function getAvailablePrefectures(): array
    {
        return $this->timeAdjuster->getAvailablePrefectures();
    }
}
