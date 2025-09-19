<?php

namespace App\Livewire\Astrology\Numerology;

use Livewire\Component;
use App\Domain\Astrology\Services\MockChartsService;
use App\Domain\Astrology\DTOs\NumerologyDTO;

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
            $dto = $mockService->getNumerology($this->selectedPersonId);
            $this->chartData = $dto->toArray();
        } catch (\Exception $e) {
            $this->chartData = [
                'life_path_number' => 7,
                'expression_number' => 3,
                'soul_urge_number' => 9,
                'personal_year' => []
            ];
        }
        
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.astrology.numerology.chart');
    }
}
