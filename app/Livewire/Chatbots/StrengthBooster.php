<?php

namespace App\Livewire\Chatbots;

use App\Domain\Chatbot\Services\ChatbotUsageService;
use App\Domain\Ai\Adapters\DifyClient;
use Carbon\Carbon;
use Livewire\Component;

class StrengthBooster extends Component
{
    public $response = '';
    public $isLoading = false;
    public $canUse = true;
    public $todayUsageCount = 0;

    private ChatbotUsageService $usageService;
    private DifyClient $difyClient;

    public function boot()
    {
        $this->usageService = app(ChatbotUsageService::class);
        $this->difyClient = app(DifyClient::class);
    }

    public function mount()
    {
        $this->checkUsageLimit();
    }

    private function checkUsageLimit()
    {
        if (!auth()->check()) {
            $this->canUse = false;
            $this->todayUsageCount = 0;
            return;
        }
        
        $this->canUse = $this->usageService->canUse(auth()->id(), 'strength');
        $this->todayUsageCount = $this->usageService->getTodayUsageCount(auth()->id(), 'strength');
    }

    public function getStrengths()
    {
        // 利用制限チェック
        if (!$this->canUse) {
            $this->addError('general', '今日の利用回数上限に達しました。サブスク登録で無制限にご利用いただけます。');
            return;
        }

        $this->isLoading = true;

        try {
            if (!auth()->check()) {
                $this->addError('general', 'ログインが必要です。');
                return;
            }
            
            $user = auth()->user();
            $profile = $user->profile;

            // プロフィール情報を準備
            $profileData = [
                'initial' => $user->name ? substr($user->name, 0, 1) . '.S.' : 'A.S.',
                'birth_date' => $profile?->birth_date?->format('Y-m-d') ?? '1990-01-01',
            ];

            // 命式情報（モック）
            $features = [
                'four_pillars' => '比肩強/食神あり',
                'ziwei' => '紫微/天相',
                'western' => '太陽水瓶/月牡牛'
            ];

            // Dify呼び出し
            $input = [
                'profile' => $profileData,
                'features' => $features,
                'rules' => '事実ベースでポジティブ/お世辞だけにしない/150-180字/見出し＋本文',
                'day' => Carbon::today()->format('Y-m-d')
            ];

            $result = $this->difyClient->runWorkflow('chat_strength_booster', $input);
            
            // レスポンスをパース
            if (isset($result['text'])) {
                $data = json_decode($result['text'], true);
                if ($data) {
                    $this->response = $data;
                } else {
                    $this->response = [
                        'title' => '今日の強み',
                        'body' => $result['text'],
                        'action' => '今日も頑張りましょう！'
                    ];
                }
            } else {
                $this->response = [
                    'title' => '今日の強み',
                    'body' => 'あなたには素晴らしい可能性があります。',
                    'action' => '自信を持って前進しましょう！'
                ];
            }

            // 利用回数をインクリメント
            $this->usageService->incrementUsage(auth()->id(), 'strength');

            // 制限状態を更新
            $this->checkUsageLimit();

        } catch (\Exception $e) {
            $this->addError('general', '申し訳ございません。接続が混み合っています。数分後にもう一度お試しください。');
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.chatbots.strength-booster');
    }
}
