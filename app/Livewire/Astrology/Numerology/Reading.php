<?php

namespace App\Livewire\Astrology\Numerology;

use Livewire\Component;
use App\Domain\Ai\Services\MockReadingsService;

class Reading extends Component
{
    public ?int $selectedPersonId = null;
    public array $chartData = [];
    public array $readingData = [];
    public bool $isLoading = true;
    public bool $isSubscriber = false;

    public function mount()
    {
        $this->isSubscriber = auth()->user()?->hasActiveSubscription() ?? false;
        // デバッグ用：常にfalseに設定してnote風UIを確認
        $this->isSubscriber = false;
        $this->loadData();
    }

    public function updatedSelectedPersonId()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->isLoading = true;
        
        try {
            $mockChartsService = new \App\Domain\Astrology\Services\MockChartsService();
            $mockReadingsService = new MockReadingsService();
            
            $chartDto = $mockChartsService->getNumerology($this->selectedPersonId);
            $this->chartData = $chartDto->toArray();
            $this->readingData = $mockReadingsService->getNumerologyReading();
        } catch (\Exception $e) {
            $this->chartData = [];
            $this->readingData = [];
        }
        
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.astrology.numerology.reading');
    }
}
