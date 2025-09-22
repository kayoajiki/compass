<?php

namespace App\Services\Ziwei;

class StarAllocator
{
    private array $ziweiSeries;
    private array $tianfuSeries;
    private array $ziweiStartTable;

    public function __construct()
    {
        $this->ziweiSeries = config('ziwei.main_star_rules.ziwei_series');
        $this->tianfuSeries = config('ziwei.main_star_rules.tianfu_series');
        $this->ziweiStartTable = config('ziwei.ziwei_start_table');
    }

    /**
     * 14主星を配置
     */
    public function allocateMainStars(array $palaces, string $fiveElementsJu, int $lunarDay): array
    {
        // 紫微の起点宮を取得
        $ziweiStartPalace = $this->getZiweiStartPalace($fiveElementsJu, $lunarDay);
        
        // 紫微系列（北斗）を逆行配置
        $palaces = $this->allocateZiweiSeries($palaces, $ziweiStartPalace);
        
        // 天府系列（南斗）を順行配置
        $palaces = $this->allocateTianfuSeries($palaces, $ziweiStartPalace);
        
        return $palaces;
    }

    /**
     * 紫微の起点宮を取得
     */
    private function getZiweiStartPalace(string $fiveElementsJu, int $lunarDay): string
    {
        if (!isset($this->ziweiStartTable[$fiveElementsJu])) {
            throw new \InvalidArgumentException("五行局 '{$fiveElementsJu}' の紫微起点表が見つかりません");
        }
        
        $dayTable = $this->ziweiStartTable[$fiveElementsJu];
        
        if (!isset($dayTable[$lunarDay])) {
            throw new \InvalidArgumentException("旧暦日 '{$lunarDay}' の紫微起点が見つかりません");
        }
        
        return $dayTable[$lunarDay];
    }

    /**
     * 紫微系列（北斗）を逆行配置
     */
    private function allocateZiweiSeries(array $palaces, string $ziweiStartPalace): array
    {
        $ziweiIndex = $this->findPalaceIndex($palaces, $ziweiStartPalace);
        
        foreach ($this->ziweiSeries as $starKey => $starInfo) {
            $offset = $starInfo['offset'];
            $targetIndex = ($ziweiIndex - $offset + 12) % 12;
            
            if (!isset($palaces[$targetIndex]['stars'])) {
                $palaces[$targetIndex]['stars'] = [];
            }
            
            $palaces[$targetIndex]['stars'][] = [
                'key' => $starKey,
                'label' => $starInfo['name'],
                'type' => 'main'
            ];
        }
        
        return $palaces;
    }

    /**
     * 天府系列（南斗）を順行配置
     */
    private function allocateTianfuSeries(array $palaces, string $ziweiStartPalace): array
    {
        // 天府は紫微の対宮（6つ先）
        $ziweiIndex = $this->findPalaceIndex($palaces, $ziweiStartPalace);
        $tianfuIndex = ($ziweiIndex + 6) % 12;
        
        foreach ($this->tianfuSeries as $starKey => $starInfo) {
            $offset = $starInfo['offset'];
            $targetIndex = ($tianfuIndex + $offset) % 12;
            
            if (!isset($palaces[$targetIndex]['stars'])) {
                $palaces[$targetIndex]['stars'] = [];
            }
            
            $palaces[$targetIndex]['stars'][] = [
                'key' => $starKey,
                'label' => $starInfo['name'],
                'type' => 'main'
            ];
        }
        
        return $palaces;
    }

    /**
     * 六吉星を配置
     */
    public function allocateLuckyStars(array $palaces, int $lunarMonth, string $yearStem, string $timeBranch): array
    {
        $luckyStarsConfig = config('ziwei.lucky_stars');
        
        // 左輔・右弼（月基準）
        $palaces = $this->allocateMonthBasedStars($palaces, $lunarMonth, ['zuofu', 'youbi']);
        
        // 天魁・天鉞（年干基準）
        $palaces = $this->allocateYearStemBasedStars($palaces, $yearStem, ['tiankui', 'tianyue']);
        
        // 文昌・文曲（時支基準）
        $palaces = $this->allocateTimeBranchBasedStars($palaces, $timeBranch, ['wenchang', 'wenqu']);
        
        return $palaces;
    }

    /**
     * 四煞星を配置
     */
    public function allocateMaleficStars(array $palaces, string $yearBranch, string $timeBranch): array
    {
        // 擎羊・陀羅（年支基準）
        $palaces = $this->allocateYearBranchBasedStars($palaces, $yearBranch, ['qingyang', 'tuoluo']);
        
        // 火星・鈴星（年支グループ×時支）
        $palaces = $this->allocateYearGroupTimeBasedStars($palaces, $yearBranch, $timeBranch, ['huoxing', 'lingxing']);
        
        return $palaces;
    }

    /**
     * 月基準の星を配置
     */
    private function allocateMonthBasedStars(array $palaces, int $month, array $starKeys): array
    {
        $luckyStarsConfig = config('ziwei.lucky_stars');
        
        foreach ($starKeys as $starKey) {
            $config = $luckyStarsConfig[$starKey];
            $basePalace = $config['base_palace'];
            $direction = $config['direction'];
            
            $baseIndex = $this->findPalaceIndex($palaces, $basePalace);
            $offset = $month - 1;
            
            if ($direction === '逆行') {
                $targetIndex = ($baseIndex - $offset + 12) % 12;
            } else {
                $targetIndex = ($baseIndex + $offset) % 12;
            }
            
            if (!isset($palaces[$targetIndex]['stars'])) {
                $palaces[$targetIndex]['stars'] = [];
            }
            
            $palaces[$targetIndex]['stars'][] = [
                'key' => $starKey,
                'label' => $config['name'],
                'type' => 'lucky'
            ];
        }
        
        return $palaces;
    }

    /**
     * 年干基準の星を配置
     */
    private function allocateYearStemBasedStars(array $palaces, string $yearStem, array $starKeys): array
    {
        $luckyStarsConfig = config('ziwei.lucky_stars');
        
        foreach ($starKeys as $starKey) {
            $config = $luckyStarsConfig[$starKey];
            $targetPalace = $config['positions'][$yearStem];
            
            $targetIndex = $this->findPalaceIndex($palaces, $targetPalace);
            
            if (!isset($palaces[$targetIndex]['stars'])) {
                $palaces[$targetIndex]['stars'] = [];
            }
            
            $palaces[$targetIndex]['stars'][] = [
                'key' => $starKey,
                'label' => $config['name'],
                'type' => 'lucky'
            ];
        }
        
        return $palaces;
    }

    /**
     * 時支基準の星を配置
     */
    private function allocateTimeBranchBasedStars(array $palaces, string $timeBranch, array $starKeys): array
    {
        $luckyStarsConfig = config('ziwei.lucky_stars');
        $timeIndex = array_search($timeBranch, ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥']);
        
        foreach ($starKeys as $starKey) {
            $config = $luckyStarsConfig[$starKey];
            $basePalace = $config['base_palace'];
            $direction = $config['direction'];
            
            $baseIndex = $this->findPalaceIndex($palaces, $basePalace);
            
            if ($direction === '逆行') {
                $targetIndex = ($baseIndex - $timeIndex + 12) % 12;
            } else {
                $targetIndex = ($baseIndex + $timeIndex) % 12;
            }
            
            if (!isset($palaces[$targetIndex]['stars'])) {
                $palaces[$targetIndex]['stars'] = [];
            }
            
            $palaces[$targetIndex]['stars'][] = [
                'key' => $starKey,
                'label' => $config['name'],
                'type' => 'lucky'
            ];
        }
        
        return $palaces;
    }

    /**
     * 年支基準の星を配置
     */
    private function allocateYearBranchBasedStars(array $palaces, string $yearBranch, array $starKeys): array
    {
        $maleficStarsConfig = config('ziwei.malefic_stars');
        
        foreach ($starKeys as $starKey) {
            $config = $maleficStarsConfig[$starKey];
            $targetPalace = $config['positions'][$yearBranch];
            
            $targetIndex = $this->findPalaceIndex($palaces, $targetPalace);
            
            if (!isset($palaces[$targetIndex]['stars'])) {
                $palaces[$targetIndex]['stars'] = [];
            }
            
            $palaces[$targetIndex]['stars'][] = [
                'key' => $starKey,
                'label' => $config['name'],
                'type' => 'malefic',
                'note' => '凶'
            ];
        }
        
        return $palaces;
    }

    /**
     * 年支グループ×時支基準の星を配置
     */
    private function allocateYearGroupTimeBasedStars(array $palaces, string $yearBranch, string $timeBranch, array $starKeys): array
    {
        $maleficStarsConfig = config('ziwei.malefic_stars');
        
        // 年支グループを判定
        $yearGroup = $this->getYearBranchGroup($yearBranch);
        $timeIndex = array_search($timeBranch, ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥']);
        
        foreach ($starKeys as $starKey) {
            $config = $maleficStarsConfig[$starKey];
            $groupConfig = $config['groups'][$yearGroup];
            $targetPalace = $groupConfig[$timeIndex];
            
            $targetIndex = $this->findPalaceIndex($palaces, $targetPalace);
            
            if (!isset($palaces[$targetIndex]['stars'])) {
                $palaces[$targetIndex]['stars'] = [];
            }
            
            $palaces[$targetIndex]['stars'][] = [
                'key' => $starKey,
                'label' => $config['name'],
                'type' => 'malefic',
                'note' => '凶'
            ];
        }
        
        return $palaces;
    }

    /**
     * 年支グループを取得
     */
    private function getYearBranchGroup(string $yearBranch): string
    {
        $groups = [
            '申子辰' => ['申', '子', '辰'],
            '寅午戌' => ['寅', '午', '戌'],
            '亥卯未' => ['亥', '卯', '未'],
            '巳酉丑' => ['巳', '酉', '丑']
        ];
        
        foreach ($groups as $groupName => $branches) {
            if (in_array($yearBranch, $branches)) {
                return $groupName;
            }
        }
        
        throw new \InvalidArgumentException("年支 '{$yearBranch}' のグループが見つかりません");
    }

    /**
     * 宮のインデックスを検索
     */
    private function findPalaceIndex(array $palaces, string $zhi): int
    {
        foreach ($palaces as $index => $palace) {
            if ($palace['zhi'] === $zhi) {
                return $index;
            }
        }
        
        throw new \InvalidArgumentException("地支 '{$zhi}' の宮が見つかりません");
    }
}
