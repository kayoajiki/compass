<?php

namespace App\Livewire\Astrology\Western;

use Livewire\Component;
use App\Domain\Astrology\Services\MockChartsService;
use App\Domain\Astrology\DTOs\WesternChartDTO;

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
            $dto = $mockService->getWestern($this->selectedPersonId);
            $this->chartData = $dto->toArray();
        } catch (\Exception $e) {
            $this->chartData = [
                'planets' => [],
                'houses' => [],
                'aspects' => []
            ];
        }
        
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.astrology.western.chart');
    }
}
