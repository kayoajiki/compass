<?php

namespace App\Livewire\Astrology\FourPillars;

use Livewire\Component;
use App\Domain\Astrology\Services\MockChartsService;
use App\Domain\Astrology\DTOs\FourPillarsChartDTO;

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
            $dto = $mockService->getFourPillars($this->selectedPersonId);
            $this->chartData = $dto->toArray();
        } catch (\Exception $e) {
            // エラーハンドリング
            $this->chartData = [
                'year' => ['stem' => '甲', 'branch' => '子'],
                'month' => ['stem' => '丙', 'branch' => '寅'],
                'day' => ['stem' => '庚', 'branch' => '午'],
                'hour' => ['stem' => '丁', 'branch' => '亥'],
            ];
        }
        
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.astrology.four-pillars.chart');
    }
}
