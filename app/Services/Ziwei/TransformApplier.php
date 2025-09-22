<?php

namespace App\Services\Ziwei;

class TransformApplier
{
    private array $transformRules;

    public function __construct()
    {
        $this->transformRules = config('ziwei.year_stem_transforms');
    }

    /**
     * 四化を適用
     */
    public function applyTransforms(array $palaces, string $yearStem): array
    {
        if (!isset($this->transformRules[$yearStem])) {
            throw new \InvalidArgumentException("年干 '{$yearStem}' の四化規則が見つかりません");
        }

        $transforms = $this->transformRules[$yearStem];
        $transformList = [];

        // 各宮の星に四化を適用
        foreach ($palaces as &$palace) {
            if (!isset($palace['stars'])) {
                continue;
            }

            foreach ($palace['stars'] as &$star) {
                $starName = $star['label'];
                
                // 四化の種類を確認
                foreach ($transforms as $transformType => $transformStar) {
                    if ($starName === $transformStar) {
                        $star['transform'] = $transformType;
                        $transformList[] = [
                            'star' => $star['key'],
                            'type' => $transformType,
                            'palace' => $palace['name']
                        ];
                    }
                }
            }
        }

        return [
            'palaces' => $palaces,
            'transforms' => $transformList
        ];
    }

    /**
     * 年干から四化の星を取得
     */
    public function getTransformStars(string $yearStem): array
    {
        if (!isset($this->transformRules[$yearStem])) {
            throw new \InvalidArgumentException("年干 '{$yearStem}' の四化規則が見つかりません");
        }

        return $this->transformRules[$yearStem];
    }

    /**
     * 特定の星の四化を取得
     */
    public function getStarTransform(string $yearStem, string $starName): ?string
    {
        $transforms = $this->getTransformStars($yearStem);
        
        foreach ($transforms as $transformType => $transformStar) {
            if ($starName === $transformStar) {
                return $transformType;
            }
        }
        
        return null;
    }

    /**
     * 四化の色を取得
     */
    public function getTransformColor(string $transformType): string
    {
        $colors = [
            '禄' => 'green',
            '権' => 'purple',
            '科' => 'blue',
            '忌' => 'red'
        ];

        return $colors[$transformType] ?? 'gray';
    }

    /**
     * 四化の表示ラベルを取得
     */
    public function getTransformLabel(string $transformType): string
    {
        $labels = [
            '禄' => '禄',
            '権' => '権',
            '科' => '科',
            '忌' => '忌'
        ];

        return $labels[$transformType] ?? $transformType;
    }

    /**
     * 四化の詳細情報を取得
     */
    public function getTransformInfo(string $transformType): array
    {
        $info = [
            '禄' => [
                'name' => '禄',
                'color' => 'green',
                'meaning' => '財運・才能',
                'description' => '財運や才能を表す吉化'
            ],
            '権' => [
                'name' => '権',
                'color' => 'purple',
                'meaning' => '権力・地位',
                'description' => '権力や地位を表す吉化'
            ],
            '科' => [
                'name' => '科',
                'color' => 'blue',
                'meaning' => '名声・学問',
                'description' => '名声や学問を表す吉化'
            ],
            '忌' => [
                'name' => '忌',
                'color' => 'red',
                'meaning' => '障害・困難',
                'description' => '障害や困難を表す凶化'
            ]
        ];

        return $info[$transformType] ?? [
            'name' => $transformType,
            'color' => 'gray',
            'meaning' => '不明',
            'description' => '不明な四化'
        ];
    }

    /**
     * 四化の統計を取得
     */
    public function getTransformStats(array $palaces): array
    {
        $stats = [
            '禄' => 0,
            '権' => 0,
            '科' => 0,
            '忌' => 0
        ];

        foreach ($palaces as $palace) {
            if (!isset($palace['stars'])) {
                continue;
            }

            foreach ($palace['stars'] as $star) {
                if (isset($star['transform'])) {
                    $stats[$star['transform']]++;
                }
            }
        }

        return $stats;
    }

    /**
     * 四化の分布を取得
     */
    public function getTransformDistribution(array $palaces): array
    {
        $distribution = [];

        foreach ($palaces as $palace) {
            $palaceName = $palace['name'];
            $distribution[$palaceName] = [
                '禄' => 0,
                '権' => 0,
                '科' => 0,
                '忌' => 0
            ];

            if (!isset($palace['stars'])) {
                continue;
            }

            foreach ($palace['stars'] as $star) {
                if (isset($star['transform'])) {
                    $distribution[$palaceName][$star['transform']]++;
                }
            }
        }

        return $distribution;
    }
}
