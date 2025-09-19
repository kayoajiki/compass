<?php

namespace App\Livewire\Astrology\ZiWei;

use Livewire\Component;
use App\Domain\Astrology\Services\MockChartsService;
use App\Domain\Astrology\DTOs\ZiWeiChartDTO;

class Chart extends Component
{
    public ?int $selectedPersonId = null;
    public array $chartData = [];
    public bool $isLoading = true;

    public function mount()
    {
        $this->loadChartData();
    }

    public function updatedSelectedPersonId()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $this->isLoading = true;
        
        try {
            $mockService = new MockChartsService();
            $dto = $mockService->getZiWei($this->selectedPersonId);
            $this->chartData = $dto->toArray();
        } catch (\Exception $e) {
            // エラーハンドリング
            $this->chartData = [
                'ming_gong' => '命宮',
                'main_star' => '破軍',
                'palaces' => []
            ];
        }
        
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.astrology.zi-wei.chart');
    }
}
