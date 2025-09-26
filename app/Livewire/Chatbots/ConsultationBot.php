<?php

namespace App\Livewire\Chatbots;

use Livewire\Component;
use App\Domain\Ai\ConsultationComposer;
use App\Models\UserFeatureTag;

class ConsultationBot extends Component
{
    public $theme = 'career';
    public $question = '';
    public $isLoading = false;
    public $result = null;
    public $error = null;

    protected $rules = [
        'question' => 'required|string|max:1200',
        'theme' => 'required|in:career,family,money,love',
    ];

    public function render()
    {
        return view('livewire.chatbots.consultation-bot');
    }

    public function askQuestion()
    {
        $this->validate();

        $this->isLoading = true;
        $this->result = null;
        $this->error = null;

        try {
            $composer = app(ConsultationComposer::class);
            $this->result = $composer->compose($this->question, auth()->user(), $this->theme);
        } catch (\Exception $e) {
            $this->error = '申し訳ございません。一時的にエラーが発生しました。しばらく時間をおいて再度お試しください。';
            \Log::error('ConsultationBot Error: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function clearResult()
    {
        $this->result = null;
        $this->error = null;
        $this->question = '';
    }

    public function getThemesProperty()
    {
        return [
            'career' => 'キャリア',
            'family' => '家族',
            'money' => 'お金',
            'love' => '恋愛',
        ];
    }
}