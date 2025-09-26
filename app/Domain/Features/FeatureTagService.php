<?php

namespace App\Domain\Features;

use App\Models\UserChart;
use App\Models\UserFeatureTag;
use App\Domain\Charts\ChartRepository;
use App\Domain\Features\ThemeRules;

class FeatureTagService
{
    private ChartRepository $chartRepository;

    public function __construct(ChartRepository $chartRepository)
    {
        $this->chartRepository = $chartRepository;
    }

    public function extractForTheme(int $userId, string $theme): UserFeatureTag
    {
        $chart = $this->chartRepository->getByUserId($userId);
        
        if (!$chart) {
            return $this->createFallbackTag($userId, $theme);
        }

        $palacePriority = ThemeRules::palacePriority($theme);
        $candidates = [];

        // 紫微斗数データからタグを抽出
        if ($chart->ziwei) {
            $candidates = array_merge($candidates, $this->extractFromZiwei($chart->ziwei, $palacePriority));
        }

        // 四柱推命データからタグを抽出
        if ($chart->saju) {
            $candidates = array_merge($candidates, $this->extractFromSaju($chart->saju));
        }

        // スコアでソートして上位を採用
        usort($candidates, fn($a, $b) => $b['score'] <=> $a['score']);
        
        $selectedTags = array_slice(array_column($candidates, 'tag'), 0, 2);
        
        if (empty($selectedTags)) {
            $selectedTags = ['あなたの個性と現在の流れを考慮したアドバイス'];
        }

        return UserFeatureTag::updateOrCreate(
            ['user_id' => $userId, 'theme' => $theme],
            [
                'tags' => $selectedTags,
                'sources' => array_column($candidates, 'source'),
                'score' => $candidates[0]['score'] ?? 0.5,
                'refreshed_at' => now(),
            ]
        );
    }

    private function extractFromZiwei(array $ziwei, array $palacePriority): array
    {
        $candidates = [];
        $starsDict = $this->loadStarsDictionary();

        foreach ($palacePriority as $index => $palace) {
            if (isset($ziwei[$palace])) {
                $stars = $ziwei[$palace]['stars'] ?? [];
                foreach ($stars as $star) {
                    if (isset($starsDict[$star])) {
                        foreach ($starsDict[$star] as $tag) {
                            $candidates[] = [
                                'tag' => $tag,
                                'source' => $palace,
                                'score' => 1.0 - ($index * 0.1),
                            ];
                        }
                    }
                }
            }
        }

        return $candidates;
    }

    private function extractFromSaju(array $saju): array
    {
        $candidates = [];
        $tenGodsDict = $this->loadTenGodsDictionary();

        // 当年十神を取得
        $currentYearTenGod = $saju['current_year_ten_god'] ?? null;
        
        if ($currentYearTenGod && isset($tenGodsDict[$currentYearTenGod])) {
            foreach ($tenGodsDict[$currentYearTenGod] as $tag) {
                $candidates[] = [
                    'tag' => $tag,
                    'source' => '四柱推命',
                    'score' => 0.8,
                ];
            }
        }

        return $candidates;
    }

    private function loadStarsDictionary(): array
    {
        $path = resource_path('dictionaries/stars_to_tags.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }
        return [];
    }

    private function loadTenGodsDictionary(): array
    {
        $path = resource_path('dictionaries/ten_gods_to_tags.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }
        return [];
    }

    private function createFallbackTag(int $userId, string $theme): UserFeatureTag
    {
        return UserFeatureTag::updateOrCreate(
            ['user_id' => $userId, 'theme' => $theme],
            [
                'tags' => ['あなたの個性と現在の流れを考慮したアドバイス'],
                'sources' => ['fallback'],
                'score' => 0.5,
                'refreshed_at' => now(),
            ]
        );
    }
}
