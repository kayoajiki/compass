<?php

namespace App\Domain\Features;

class ThemeRules
{
    public static function palacePriority(string $theme): array
    {
        return match ($theme) {
            'career' => ['官祿宮', '遷移宮', '命宮', '財帛宮'],
            'family' => ['夫妻宮', '田宅宮', '父母宮', '福德宮'],
            'money' => ['財帛宮', '遷移宮', '田宅宮', '官祿宮'],
            'love' => ['夫妻宮', '遷移宮', '福德宮', '交友宮'],
            default => ['命宮', '遷移宮', '福德宮', '財帛宮'],
        };
    }
}
