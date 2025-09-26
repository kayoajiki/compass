<?php

namespace App\Domain\Ai;

use App\Models\User;
use App\Models\UserFeatureTag;
use App\Domain\Features\FeatureTagService;

class ConsultationComposer
{
    private DifyClient $difyClient;
    private FeatureTagService $featureTagService;

    public function __construct(DifyClient $difyClient, FeatureTagService $featureTagService)
    {
        $this->difyClient = $difyClient;
        $this->featureTagService = $featureTagService;
    }

    public function compose(string $question, User $user, string $theme): array
    {
        // タグを取得（なければ抽出）
        $featureTag = UserFeatureTag::where('user_id', $user->id)
            ->where('theme', $theme)
            ->first();

        if (!$featureTag) {
            $featureTag = $this->featureTagService->extractForTheme($user->id, $theme);
        }

        $tags = $featureTag->tags ?? ['あなたの個性と現在の流れを考慮したアドバイス'];

        $inputs = [
            'user_input' => $question,
            'focus_features' => $tags,
            'style' => '自然な鑑定文・見出しなし・全体500〜700字',
            'structure_hint' => '最初の二文で結論→次に根拠→行動提案→励まし。専門用語は禁止。',
        ];

        $response = $this->difyClient->runWorkflow($inputs);

        if (empty($response)) {
            return $this->fallbackDraft($question, $theme);
        }

        return [
            'title' => $response['title'] ?? '鑑定結果',
            'message' => $response['message'] ?? $this->fallbackDraft($question, $theme)['message'],
        ];
    }

    private function fallbackDraft(string $question, string $theme): array
    {
        $themes = [
            'career' => 'キャリア',
            'family' => '家族',
            'money' => 'お金',
            'love' => '恋愛',
        ];

        $themeName = $themes[$theme] ?? '人生';

        return [
            'title' => '鑑定結果',
            'message' => "{$themeName}についてのご相談、ありがとうございます。現在のあなたの状況を考慮すると、まずは一歩ずつ前進することが大切です。焦らずに、自分らしいペースで進んでいけば、きっと良い結果が待っています。今日からできる小さな一歩を大切にしてください。",
        ];
    }
}
