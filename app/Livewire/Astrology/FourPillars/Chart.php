<?php

namespace App\Livewire\Astrology\FourPillars;

use Livewire\Component;
use App\Services\FourPillars\FourPillarsService;
use App\Services\FourPillars\DTOs\BuildParams;
use App\Services\FourPillars\Data\Sex;
use Illuminate\Support\Facades\Auth;

class Chart extends Component
{
    public ?int $selectedPersonId = null;
    public array $chartData = [];
    public array $fiveElementsCount = [];
    public array $daiun = [];
    public array $annual = [];
    public array $monthly = [];
    public bool $isLoading = true;
    public bool $profileIncomplete = false;

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
            $fourPillarsService = app(FourPillarsService::class);
            
            // ユーザーのプロフィールから四柱推命の命式を作成
            $user = Auth::user();
            if ($user && $user->profile && $user->profile->isComplete()) {
                $result = $fourPillarsService->buildFromProfile($user->profile);
                $this->profileIncomplete = false;
            } else {
                // プロフィールが不完全な場合はデモデータを使用
                $this->profileIncomplete = true;
                $this->loadDemoData();
                return;
            }
            
            // データを配列形式に変換
            $this->chartData = [
                'year' => [
                    'stem' => $result->year->stem->value,
                    'branch' => $result->year->branch->value,
                    'hiddenStems' => array_map(fn($x) => $x->value, $result->year->hiddenStems),
                    'stemTss' => $result->year->stemTss,
                    'hiddenStemsTss' => $result->year->hiddenStemsTss,
                    'twelveStage' => $result->year->twelveStage
                ],
                'month' => [
                    'stem' => $result->month->stem->value,
                    'branch' => $result->month->branch->value,
                    'hiddenStems' => array_map(fn($x) => $x->value, $result->month->hiddenStems),
                    'stemTss' => $result->month->stemTss,
                    'hiddenStemsTss' => $result->month->hiddenStemsTss,
                    'twelveStage' => $result->month->twelveStage
                ],
                'day' => [
                    'stem' => $result->day->stem->value,
                    'branch' => $result->day->branch->value,
                    'hiddenStems' => array_map(fn($x) => $x->value, $result->day->hiddenStems),
                    'stemTss' => $result->day->stemTss,
                    'hiddenStemsTss' => $result->day->hiddenStemsTss,
                    'twelveStage' => $result->day->twelveStage
                ],
                'hour' => $result->hour ? [
                    'stem' => $result->hour->stem->value,
                    'branch' => $result->hour->branch->value,
                    'hiddenStems' => array_map(fn($x) => $x->value, $result->hour->hiddenStems),
                    'stemTss' => $result->hour->stemTss,
                    'hiddenStemsTss' => $result->hour->hiddenStemsTss,
                    'twelveStage' => $result->hour->twelveStage
                ] : null
            ];
            
            $this->fiveElementsCount = $result->fiveElementsCount;
            $this->daiun = $result->daiun;
            $this->annual = $result->annual;
            $this->monthly = $result->monthly;
            
        } catch (\Exception $e) {
            // エラーハンドリング - デモデータを使用
            $this->loadDemoData();
        }
        
        $this->isLoading = false;
    }

    private function loadDemoData()
    {
        $fourPillarsService = app(FourPillarsService::class);
        
        $params = new BuildParams(
            birthDate: '1992-05-17',
            birthTime: '15:02',
            sex: Sex::Male,
            annualFrom: date('Y'),
            annualTo: date('Y') + 10,
            monthlyFrom: date('Y-m'),
            monthlyTo: date('Y-m', strtotime('+12 months'))
        );

        $result = $fourPillarsService->build($params);
        
        $this->chartData = [
            'year' => [
                'stem' => $result->year->stem->value,
                'branch' => $result->year->branch->value,
                'hiddenStems' => array_map(fn($x) => $x->value, $result->year->hiddenStems),
                'stemTss' => $result->year->stemTss,
                'hiddenStemsTss' => $result->year->hiddenStemsTss,
                'twelveStage' => $result->year->twelveStage
            ],
            'month' => [
                'stem' => $result->month->stem->value,
                'branch' => $result->month->branch->value,
                'hiddenStems' => array_map(fn($x) => $x->value, $result->month->hiddenStems),
                'stemTss' => $result->month->stemTss,
                'hiddenStemsTss' => $result->month->hiddenStemsTss,
                'twelveStage' => $result->month->twelveStage
            ],
            'day' => [
                'stem' => $result->day->stem->value,
                'branch' => $result->day->branch->value,
                'hiddenStems' => array_map(fn($x) => $x->value, $result->day->hiddenStems),
                'stemTss' => $result->day->stemTss,
                'hiddenStemsTss' => $result->day->hiddenStemsTss,
                'twelveStage' => $result->day->twelveStage
            ],
            'hour' => $result->hour ? [
                'stem' => $result->hour->stem->value,
                'branch' => $result->hour->branch->value,
                'hiddenStems' => array_map(fn($x) => $x->value, $result->hour->hiddenStems),
                'stemTss' => $result->hour->stemTss,
                'hiddenStemsTss' => $result->hour->hiddenStemsTss,
                'twelveStage' => $result->hour->twelveStage
            ] : null
        ];
        
        $this->fiveElementsCount = $result->fiveElementsCount;
        $this->daiun = $result->daiun;
        $this->annual = $result->annual;
        $this->monthly = $result->monthly;
    }

    public function render()
    {
        return view('livewire.astrology.four-pillars.chart');
    }
}
