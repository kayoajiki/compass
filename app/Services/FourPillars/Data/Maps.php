<?php

namespace App\Services\FourPillars\Data;

final class Maps
{
    /** 60干支（stem, branch のタプル） */
    public static function sexagenary(): array
    {
        static $cache;
        if ($cache) return $cache;
        
        $stems = HeavenlyStem::cases();
        $branches = EarthlyBranch::cases();
        
        for ($i = 0; $i < 60; $i++) {
            $out[] = ['stem' => $stems[$i % 10], 'branch' => $branches[$i % 12]];
        }
        
        return $cache = $out;
    }

    /** 地支→蔵干（上／中／余） */
    public static function hiddenStemsByBranch(): array
    {
        return [
            '子' => [HeavenlyStem::Gui],
            '丑' => [HeavenlyStem::Ji, HeavenlyStem::Gui, HeavenlyStem::Xin],
            '寅' => [HeavenlyStem::Jia, HeavenlyStem::Bing, HeavenlyStem::Wu],
            '卯' => [HeavenlyStem::Yi],
            '辰' => [HeavenlyStem::Wu, HeavenlyStem::Yi, HeavenlyStem::Gui],
            '巳' => [HeavenlyStem::Bing, HeavenlyStem::Wu, HeavenlyStem::Geng],
            '午' => [HeavenlyStem::Ding, HeavenlyStem::Ji],
            '未' => [HeavenlyStem::Ji, HeavenlyStem::Yi, HeavenlyStem::Ding],
            '申' => [HeavenlyStem::Geng, HeavenlyStem::Ren, HeavenlyStem::Wu],
            '酉' => [HeavenlyStem::Xin],
            '戌' => [HeavenlyStem::Wu, HeavenlyStem::Xin, HeavenlyStem::Ding],
            '亥' => [HeavenlyStem::Ren, HeavenlyStem::Jia],
        ];
    }

    /** 五行（干／支） */
    public static function elementOfStem(): array
    {
        return [
            '甲' => '木', '乙' => '木', '丙' => '火', '丁' => '火', '戊' => '土', '己' => '土',
            '庚' => '金', '辛' => '金', '壬' => '水', '癸' => '水',
        ];
    }

    public static function elementOfBranch(): array
    {
        return [
            '子' => '水', '丑' => '土', '寅' => '木', '卯' => '木', '辰' => '土', '巳' => '火',
            '午' => '火', '未' => '土', '申' => '金', '酉' => '金', '戌' => '土', '亥' => '水',
        ];
    }

    /** 十神（=通変星）: 日干×対象干 → 通変名 */
    public static function jushin(): array
    {
        return [
            '甲' => ['甲' => '比肩', '乙' => '劫財', '丙' => '食神', '丁' => '傷官', '戊' => '偏財', '己' => '正財', '庚' => '偏官', '辛' => '正官', '壬' => '偏印', '癸' => '印綬'],
            '乙' => ['甲' => '劫財', '乙' => '比肩', '丙' => '傷官', '丁' => '食神', '戊' => '正財', '己' => '偏財', '庚' => '正官', '辛' => '偏官', '壬' => '印綬', '癸' => '偏印'],
            '丙' => ['甲' => '偏印', '乙' => '印綬', '丙' => '比肩', '丁' => '劫財', '戊' => '食神', '己' => '傷官', '庚' => '偏財', '辛' => '正財', '壬' => '偏官', '癸' => '正官'],
            '丁' => ['甲' => '印綬', '乙' => '偏印', '丙' => '劫財', '丁' => '比肩', '戊' => '傷官', '己' => '食神', '庚' => '正財', '辛' => '偏財', '壬' => '正官', '癸' => '偏官'],
            '戊' => ['甲' => '偏官', '乙' => '正官', '丙' => '偏印', '丁' => '印綬', '戊' => '比肩', '己' => '劫財', '庚' => '食神', '辛' => '傷官', '壬' => '偏財', '癸' => '正財'],
            '己' => ['甲' => '正官', '乙' => '偏官', '丙' => '印綬', '丁' => '偏印', '戊' => '劫財', '己' => '比肩', '庚' => '傷官', '辛' => '食神', '壬' => '正財', '癸' => '偏財'],
            '庚' => ['甲' => '偏財', '乙' => '正財', '丙' => '偏官', '丁' => '正官', '戊' => '偏印', '己' => '印綬', '庚' => '比肩', '辛' => '劫財', '壬' => '食神', '癸' => '傷官'],
            '辛' => ['甲' => '正財', '乙' => '偏財', '丙' => '正官', '丁' => '偏官', '戊' => '印綬', '己' => '偏印', '庚' => '劫財', '辛' => '比肩', '壬' => '傷官', '癸' => '食神'],
            '壬' => ['甲' => '食神', '乙' => '傷官', '丙' => '偏財', '丁' => '正財', '戊' => '偏官', '己' => '正官', '庚' => '偏印', '辛' => '印綬', '壬' => '比肩', '癸' => '劫財'],
            '癸' => ['甲' => '傷官', '乙' => '食神', '丙' => '正財', '丁' => '偏財', '戊' => '正官', '己' => '偏官', '庚' => '印綬', '辛' => '偏印', '壬' => '劫財', '癸' => '比肩'],
        ];
    }

    /**
     * 時干テーブル（標準規則）:
     * 子の時干は「日干グループ」により 5通り → 各時刻で十干を順送り。
     * グループ: [甲己]=甲, [乙庚]=丙, [丙辛]=戊, [丁壬]=庚, [戊癸]=壬 が子の起点。
     */
    public static function hourStartByDayStem(): array
    {
        return [
            '甲' => '甲', '己' => '甲',
            '乙' => '丙', '庚' => '丙',
            '丙' => '戊', '辛' => '戊',
            '丁' => '庚', '壬' => '庚',
            '戊' => '壬', '癸' => '壬',
        ];
    }

    /** 十二運（長生→養の順） */
    public static function twelveStages(): array
    {
        return ['長生', '沐浴', '冠帯', '建禄', '帝旺', '衰', '病', '死', '墓', '絶', '胎', '養'];
    }
}
