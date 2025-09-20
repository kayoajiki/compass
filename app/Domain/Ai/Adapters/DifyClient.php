<?php

namespace App\Domain\Ai\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DifyClient
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('fortune.ai.dify.base_url') ?? 'https://api.dify.ai';
        $this->apiKey = config('fortune.ai.dify.api_key') ?? 'mock-key';
    }

    /**
     * Run a workflow on Dify
     *
     * @param string $appCode
     * @param array $input
     * @return array
     * @throws \Exception
     */
    public function runWorkflow(string $appCode, array $input): array
    {
        try {
            // MVPでは実際のDify呼び出しの代わりにモックレスポンスを返す
            return $this->getMockResponse($appCode, $input);
            
            /*
            // 実際のDify呼び出し（将来実装時）
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/v1/workflows/run', [
                'inputs' => $input,
                'response_mode' => 'blocking',
                'user' => 'user-' . auth()->id(),
            ]);

            if ($response->failed()) {
                throw new \Exception('Dify API request failed: ' . $response->body());
            }

            $data = $response->json();
            return $data['data'] ?? ['text' => '申し訳ございません。接続エラーが発生しました。'];
            */
        } catch (\Exception $e) {
            Log::error('Dify workflow error: ' . $e->getMessage());
            return ['text' => '申し訳ございません。接続が混み合っています。数分後にもう一度お試しください。'];
        }
    }

    /**
     * Get mock response for MVP
     *
     * @param string $appCode
     * @param array $input
     * @return array
     */
    private function getMockResponse(string $appCode, array $input): array
    {
        switch ($appCode) {
            case 'chat_mood_coach':
                return $this->getMoodCoachMockResponse($input);
            case 'chat_tarot_quick':
                return $this->getTarotMockResponse($input);
            case 'chat_strength_booster':
                return $this->getStrengthMockResponse($input);
            default:
                return ['text' => 'こんにちは！今日も素晴らしい一日になりますように。'];
        }
    }

    private function getMoodCoachMockResponse(array $input): array
    {
        $moodScore = $input['mood_score'] ?? 3;
        $memo = $input['memo'] ?? '';

        $responses = [
            1 => '今日は少し疲れているようですね。無理をせず、ゆっくりと休んでください。小さな一歩でも、あなたは十分頑張っています。',
            2 => '今日は思うようにいかないこともあるかもしれませんね。でも、それは成長の証拠です。明日はきっと良い一日になりますよ。',
            3 => '今日は平穏な一日だったようですね。日常の中にも小さな幸せがたくさんあります。今日の出来事を大切にしてください。',
            4 => '今日は良い調子のようですね！その前向きな気持ちを大切にして、素晴らしい一日を過ごしてください。',
            5 => '今日は最高の一日だったようですね！その笑顔とエネルギーを周りの人にも分けてあげてください。'
        ];

        $baseResponse = $responses[$moodScore] ?? $responses[3];
        
        if (!empty($memo)) {
            $baseResponse .= "\n\n「' . $memo . '」について教えてくれてありがとうございます。";
        }

        return ['text' => $baseResponse];
    }

    private function getTarotMockResponse(array $input): array
    {
        $question = $input['question'] ?? '';
        
        $cards = [
            'The Fool' => ['reversed' => false, 'keywords' => ['新開始', '冒険', '可能性'], 'advice' => '新しい挑戦をする時です。純粋な気持ちで一歩を踏み出してください。'],
            'The Magician' => ['reversed' => false, 'keywords' => ['創造力', '意志', '能力'], 'advice' => 'あなたには必要な能力がすべて備わっています。自信を持って行動してください。'],
            'The Sun' => ['reversed' => false, 'keywords' => ['成功', '喜び', '活力'], 'advice' => '明るい未来が待っています。前向きな気持ちを大切にしてください。'],
            'The Moon' => ['reversed' => true, 'keywords' => ['直感', '不安', '曖昧'], 'advice' => '直感を大切にしながらも、現実的な判断も忘れずに。'],
            'The Star' => ['reversed' => false, 'keywords' => ['希望', '癒し', '導き'], 'advice' => '希望の光があなたを照らしています。困難も乗り越えられるでしょう。']
        ];

        $selectedCard = array_rand($cards);
        $cardData = $cards[$selectedCard];

        return [
            'card' => $selectedCard,
            'reversed' => $cardData['reversed'],
            'keywords' => $cardData['keywords'],
            'advice' => $cardData['advice']
        ];
    }

    private function getStrengthMockResponse(array $input): array
    {
        $birthDate = $input['profile']['birth_date'] ?? '1990-01-01';
        $month = (int) date('m', strtotime($birthDate));
        
        $strengths = [
            '今日の強み',
            'あなたの魅力',
            '隠れた才能',
            '特別な力',
            '内なる光'
        ];

        $actions = [
            'まずは深呼吸をして、今の気持ちを大切にしてみましょう。',
            '今日は小さな親切を一つしてみてください。',
            '自分を褒める言葉を三つ見つけてみましょう。',
            '新しいことにチャレンジする勇気を持ってみてください。',
            '周りの人に感謝の気持ちを伝えてみましょう。'
        ];

        $selectedStrength = $strengths[$month % count($strengths)];
        $selectedAction = $actions[$month % count($actions)];

        $body = match($month % 5) {
            0 => 'あなたの優しさと理解力は、周りの人を安心させる特別な力を持っています。',
            1 => 'あなたの創造性と直感力は、新しい可能性を切り開く鍵となります。',
            2 => 'あなたの誠実さと責任感は、信頼関係を築く強固な基盤です。',
            3 => 'あなたの好奇心と学習意欲は、常に成長し続ける原動力です。',
            4 => 'あなたの協調性と調整力は、チームを成功に導く重要な要素です。',
        };

        return [
            'title' => $selectedStrength,
            'body' => $body,
            'action' => $selectedAction
        ];
    }
}
