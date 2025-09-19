<?php

namespace App\Domain\Astrology\Services;

use App\Domain\Astrology\DTOs\FourPillarsChartDTO;
use App\Domain\Astrology\DTOs\ZiWeiChartDTO;
use App\Domain\Astrology\DTOs\WesternChartDTO;
use App\Domain\Astrology\DTOs\NumerologyDTO;

class MockChartsService
{
    public function getFourPillars($userOrPersonId = null): FourPillarsChartDTO
    {
        // モックデータ：四柱推命の干支
        $mockData = [
            'year' => ['stem' => '甲', 'branch' => '子'],
            'month' => ['stem' => '丙', 'branch' => '寅'],
            'day' => ['stem' => '庚', 'branch' => '午'],
            'hour' => ['stem' => '丁', 'branch' => '亥'],
        ];

        return FourPillarsChartDTO::fromArray($mockData);
    }

    public function getZiWei($userOrPersonId = null): ZiWeiChartDTO
    {
        // モックデータ：紫微斗数の12宮
        $mockData = [
            'ming_gong' => '命宮',
            'main_star' => '破軍',
            'palaces' => [
                ['name' => '命宮', 'star' => '破軍'],
                ['name' => '兄弟', 'star' => '七殺'],
                ['name' => '夫妻', 'star' => '天機'],
                ['name' => '子女', 'star' => '紫微'],
                ['name' => '財帛', 'star' => '太陽'],
                ['name' => '疾厄', 'star' => '武曲'],
                ['name' => '遷移', 'star' => '天同'],
                ['name' => '交友', 'star' => '太陰'],
                ['name' => '官禄', 'star' => '貪狼'],
                ['name' => '田宅', 'star' => '巨門'],
                ['name' => '福德', 'star' => '天相'],
                ['name' => '父母', 'star' => '天梁'],
            ]
        ];

        return ZiWeiChartDTO::fromArray($mockData);
    }

    public function getWestern($userOrPersonId = null): WesternChartDTO
    {
        // モックデータ：西洋占星術の主要天体
        $mockData = [
            'planets' => [
                ['name' => '太陽', 'sign' => '牡羊座', 'degree' => '15°32\''],
                ['name' => '月', 'sign' => '双子座', 'degree' => '8°45\''],
                ['name' => '水星', 'sign' => '牡羊座', 'degree' => '22°18\''],
                ['name' => '金星', 'sign' => '牡羊座', 'degree' => '28°56\''],
                ['name' => '火星', 'sign' => '獅子座', 'degree' => '12°07\''],
                ['name' => '木星', 'sign' => '射手座', 'degree' => '3°29\''],
                ['name' => '土星', 'sign' => '水瓶座', 'degree' => '18°41\''],
                ['name' => '天王星', 'sign' => '牡牛座', 'degree' => '25°13\''],
                ['name' => '海王星', 'sign' => '魚座', 'degree' => '7°58\''],
                ['name' => '冥王星', 'sign' => '山羊座', 'degree' => '14°26\''],
            ],
            'houses' => [
                ['house' => '1宮', 'sign' => '牡羊座', 'degree' => '10°'],
                ['house' => '2宮', 'sign' => '牡牛座', 'degree' => '5°'],
                ['house' => '3宮', 'sign' => '双子座', 'degree' => '15°'],
                ['house' => '4宮', 'sign' => '蟹座', 'degree' => '8°'],
                ['house' => '5宮', 'sign' => '獅子座', 'degree' => '20°'],
                ['house' => '6宮', 'sign' => '乙女座', 'degree' => '12°'],
                ['house' => '7宮', 'sign' => '天秤座', 'degree' => '10°'],
                ['house' => '8宮', 'sign' => '蠍座', 'degree' => '5°'],
                ['house' => '9宮', 'sign' => '射手座', 'degree' => '15°'],
                ['house' => '10宮', 'sign' => '山羊座', 'degree' => '8°'],
                ['house' => '11宮', 'sign' => '水瓶座', 'degree' => '20°'],
                ['house' => '12宮', 'sign' => '魚座', 'degree' => '12°'],
            ],
            'aspects' => [
                ['planet1' => '太陽', 'planet2' => '月', 'aspect' => 'スクエア', 'orb' => '3°'],
                ['planet1' => '太陽', 'planet2' => '火星', 'aspect' => 'トライン', 'orb' => '2°'],
                ['planet1' => '月', 'planet2' => '金星', 'aspect' => 'セクスタイル', 'orb' => '1°'],
            ]
        ];

        return WesternChartDTO::fromArray($mockData);
    }

    public function getNumerology($userOrPersonId = null): NumerologyDTO
    {
        // モックデータ：数秘術の基本数値
        $mockData = [
            'life_path_number' => 7,
            'expression_number' => 3,
            'soul_urge_number' => 9,
            'personal_year' => [
                'current_year' => 2024,
                'personal_year_number' => 5,
                'description' => '変化と自由の年'
            ]
        ];

        return NumerologyDTO::fromArray($mockData);
    }
}
