<?php

namespace App\Domain\Astrology\Services;

class DailyMockService
{
    /**
     * 今日の運勢モックデータを取得
     * 
     * @return array
     */
    public function getTodayFortune(): array
    {
        // 日付を取得
        $date = now()->format('Y-m-d');
        
        // モックデータ（将来的にAIロジックに差し替え）
        $mockData = [
            'date' => $date,
            'total_score' => $this->generateRandomScore(),
            'categories' => [
                'love' => $this->generateRandomCategoryScore(),
                'study' => $this->generateRandomCategoryScore(),
                'money' => $this->generateRandomCategoryScore(),
                'health' => $this->generateRandomCategoryScore(),
                'work' => $this->generateRandomCategoryScore(),
            ]
        ];
        
        return $mockData;
    }
    
    /**
     * ランダムな総合スコアを生成（0-100）
     * 
     * @return int
     */
    private function generateRandomScore(): int
    {
        return rand(30, 95);
    }
    
    /**
     * ランダムなカテゴリスコアを生成（1-5）
     * 
     * @return int
     */
    private function generateRandomCategoryScore(): int
    {
        return rand(1, 5);
    }
    
    /**
     * カテゴリの表示名を取得
     * 
     * @param string $category
     * @return string
     */
    public function getCategoryName(string $category): string
    {
        $names = [
            'love' => '恋愛運',
            'study' => '勉強運',
            'money' => '金運',
            'health' => '健康運',
            'work' => '仕事運',
        ];
        
        return $names[$category] ?? $category;
    }
    
    /**
     * カテゴリのアイコンを取得
     * 
     * @param string $category
     * @return string
     */
    public function getCategoryIcon(string $category): string
    {
        $icons = [
            'love' => '❤️',
            'study' => '📘',
            'money' => '💰',
            'health' => '💪',
            'work' => '💼',
        ];
        
        return $icons[$category] ?? '⭐';
    }
    
    /**
     * スコアに基づくメッセージを取得
     * 
     * @param int $score
     * @return string
     */
    public function getScoreMessage(int $score): string
    {
        if ($score >= 90) {
            return '最高の一日になりそうです！';
        } elseif ($score >= 80) {
            return 'とても良い運気です！';
        } elseif ($score >= 70) {
            return '良い一日になりそうです。';
        } elseif ($score >= 60) {
            return 'まずまずの運気です。';
        } elseif ($score >= 50) {
            return '普通の一日になりそうです。';
        } else {
            return '慎重に過ごすと良いでしょう。';
        }
    }
}
