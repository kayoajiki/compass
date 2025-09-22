<?php

namespace App\Services\Ziwei;

class PalaceCalculator
{
    private array $palaceOrder;
    private array $zhiOrder;

    public function __construct()
    {
        $this->palaceOrder = config('ziwei.main_star_rules.palace_order');
        $this->zhiOrder = config('ziwei.main_star_rules.zhi_order');
    }

    /**
     * 命宮を計算
     */
    public function calculateMingPalace(int $lunarMonth, string $timeBranch): string
    {
        // 寅を正月として出生月まで順行
        $monthIndex = $lunarMonth - 1; // 1月=0, 2月=1, ...
        $startIndex = 2; // 寅のインデックス
        
        // 順行で月まで進む
        $monthPalaceIndex = ($startIndex + $monthIndex) % 12;
        
        // そこから出生時まで逆行
        $timeIndex = array_search($timeBranch, $this->zhiOrder);
        $mingPalaceIndex = ($monthPalaceIndex - $timeIndex + 12) % 12;
        
        return $this->zhiOrder[$mingPalaceIndex];
    }

    /**
     * 十二宮の配置を計算
     */
    public function calculatePalaces(string $mingPalace): array
    {
        $mingIndex = array_search($mingPalace, $this->zhiOrder);
        $palaces = [];
        
        for ($i = 0; $i < 12; $i++) {
            $zhiIndex = ($mingIndex + $i) % 12;
            $palaces[] = [
                'zhi' => $this->zhiOrder[$zhiIndex],
                'name' => $this->palaceOrder[$i],
                'index' => $i
            ];
        }
        
        return $palaces;
    }

    /**
     * 宮干を計算（五虎遁）
     */
    public function calculatePalaceStems(string $yearStem, array $palaces): array
    {
        $wuhuDun = config('ziwei.main_star_rules.wuhu_dun');
        
        if (!isset($wuhuDun[$yearStem])) {
            throw new \InvalidArgumentException("年干 '{$yearStem}' の五虎遁が見つかりません");
        }
        
        $stemMap = $wuhuDun[$yearStem];
        
        foreach ($palaces as &$palace) {
            $palace['stem'] = $stemMap[$palace['zhi']] ?? '?';
        }
        
        return $palaces;
    }

    /**
     * 命宮のインデックスを取得
     */
    public function getMingPalaceIndex(string $mingPalace): int
    {
        return array_search($mingPalace, $this->zhiOrder);
    }

    /**
     * 地支のインデックスを取得
     */
    public function getZhiIndex(string $zhi): int
    {
        $index = array_search($zhi, $this->zhiOrder);
        if ($index === false) {
            throw new \InvalidArgumentException("地支 '{$zhi}' が見つかりません");
        }
        return $index;
    }

    /**
     * 地支の順序を取得
     */
    public function getZhiOrder(): array
    {
        return $this->zhiOrder;
    }

    /**
     * 宮名の順序を取得
     */
    public function getPalaceOrder(): array
    {
        return $this->palaceOrder;
    }

    /**
     * 指定した地支から指定した数だけ進んだ地支を取得
     */
    public function getZhiAfter(string $zhi, int $steps, bool $reverse = false): string
    {
        $index = $this->getZhiIndex($zhi);
        $direction = $reverse ? -1 : 1;
        $newIndex = ($index + ($steps * $direction) + 12) % 12;
        
        return $this->zhiOrder[$newIndex];
    }

    /**
     * 十二宮の完全な情報を取得
     */
    public function getCompletePalaces(string $yearStem, int $lunarMonth, string $timeBranch): array
    {
        $mingPalace = $this->calculateMingPalace($lunarMonth, $timeBranch);
        $palaces = $this->calculatePalaces($mingPalace);
        $palaces = $this->calculatePalaceStems($yearStem, $palaces);
        
        return $palaces;
    }
}
