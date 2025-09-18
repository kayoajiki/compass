<?php

namespace App\Livewire\Dashboard;

use App\Domain\Astrology\Services\DailyMockService;
use Livewire\Component;

class DailyFortune extends Component
{
    public $fortuneData = [];
    public $isLoading = true;
    
    protected $dailyMockService;
    
    public function boot(DailyMockService $dailyMockService)
    {
        $this->dailyMockService = $dailyMockService;
    }
    
    public function mount()
    {
        $this->loadFortuneData();
    }
    
    public function loadFortuneData()
    {
        $this->isLoading = true;
        
        try {
            $this->fortuneData = $this->dailyMockService->getTodayFortune();
        } catch (\Exception $e) {
            // エラー時はデフォルトデータを設定
            $this->fortuneData = [
                'date' => now()->format('Y-m-d'),
                'total_score' => 50,
                'categories' => [
                    'love' => 3,
                    'study' => 3,
                    'money' => 3,
                    'health' => 3,
                    'work' => 3,
                ]
            ];
        }
        
        $this->isLoading = false;
    }
    
    public function getCategoryName($category)
    {
        return $this->dailyMockService->getCategoryName($category);
    }
    
    public function getCategoryIcon($category)
    {
        return $this->dailyMockService->getCategoryIcon($category);
    }
    
    public function getScoreMessage()
    {
        return $this->dailyMockService->getScoreMessage($this->fortuneData['total_score'] ?? 50);
    }
    
    public function render()
    {
        return view('livewire.dashboard.daily-fortune');
    }
}
