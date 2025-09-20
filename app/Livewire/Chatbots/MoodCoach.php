<?php

namespace App\Livewire\Chatbots;

use App\Domain\Chatbot\Services\ChatbotUsageService;
use App\Domain\Ai\Adapters\DifyClient;
use App\Models\Mood;
use Carbon\Carbon;
use Livewire\Component;

class MoodCoach extends Component
{
    public $moodScore = 3;
    public $memo = '';
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
        
        $this->canUse = $this->usageService->canUse(auth()->id(), 'mood');
        $this->todayUsageCount = $this->usageService->getTodayUsageCount(auth()->id(), 'mood');
    }

    public function submit()
    {
        $this->validate([
            'moodScore' => 'required|integer|min:1|max:5',
            'memo' => 'nullable|string|max:140',
        ]);

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
            
            // 1. Moodテーブルに保存
            $mood = Mood::create([
                'user_id' => auth()->id(),
                'date' => Carbon::today(),
                'mood_score' => $this->moodScore,
                'memo' => $this->memo,
            ]);

            // 2. Dify呼び出し
            $input = [
                'date' => Carbon::today()->format('Y-m-d'),
                'mood_score' => $this->moodScore,
                'memo' => $this->memo,
                'tone' => 'やさしく/前向き/中学生にもわかる',
                'rules' => '不安を煽らない/断定的助言を避ける/最大200字/2段落まで'
            ];

            $result = $this->difyClient->runWorkflow('chat_mood_coach', $input);
            $this->response = $result['text'] ?? '今日もお疲れさまでした。';

            // 3. 利用回数をインクリメント
            $this->usageService->incrementUsage(auth()->id(), 'mood');

            // 4. 制限状態を更新
            $this->checkUsageLimit();

        } catch (\Exception $e) {
            $this->addError('general', '申し訳ございません。接続が混み合っています。数分後にもう一度お試しください。');
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.chatbots.mood-coach');
    }
}
