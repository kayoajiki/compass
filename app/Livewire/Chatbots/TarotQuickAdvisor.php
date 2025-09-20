<?php

namespace App\Livewire\Chatbots;

use App\Domain\Chatbot\Services\ChatbotUsageService;
use App\Domain\Ai\Adapters\DifyClient;
use Livewire\Component;

class TarotQuickAdvisor extends Component
{
    public $question = '';
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
        
        $this->canUse = $this->usageService->canUse(auth()->id(), 'tarot');
        $this->todayUsageCount = $this->usageService->getTodayUsageCount(auth()->id(), 'tarot');
    }

    public function submit()
    {
        $this->validate([
            'question' => 'required|string|max:200',
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
            
            // Dify呼び出し
            $input = [
                'question' => $this->question,
                'spread' => 'one_card',
                'style' => 'やさしく具体的/最大200字',
                'output_format' => 'JSON',
                'schema' => [
                    'card' => 'string',
                    'reversed' => 'boolean',
                    'keywords' => 'array',
                    'advice' => 'string'
                ]
            ];

            $result = $this->difyClient->runWorkflow('chat_tarot_quick', $input);
            
            // JSONレスポンスをパース
            if (isset($result['text'])) {
                $data = json_decode($result['text'], true);
                if ($data) {
                    $this->response = $data;
                } else {
                    $this->response = ['advice' => $result['text']];
                }
            } else {
                $this->response = ['advice' => 'タロットがあなたにメッセージを送っています。'];
            }

            // 利用回数をインクリメント
            $this->usageService->incrementUsage(auth()->id(), 'tarot');

            // 制限状態を更新
            $this->checkUsageLimit();

            // 質問をクリア
            $this->question = '';

        } catch (\Exception $e) {
            $this->addError('general', '申し訳ございません。接続が混み合っています。数分後にもう一度お試しください。');
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.chatbots.tarot-quick-advisor');
    }
}
