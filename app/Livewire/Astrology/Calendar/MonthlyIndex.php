<?php

namespace App\Livewire\Astrology\Calendar;

use App\Domain\Astrology\Services\RokuyoService;
use App\Domain\Calendar\Services\StemBranchService;
use App\Domain\Calendar\Services\TsuhenseiService;
use App\Domain\Calendar\Services\JuuniunService;
use App\Domain\Calendar\Services\LuckRankService;
use App\Domain\Calendar\Services\JapaneseHolidayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class MonthlyIndex extends Component
{
    public $month;
    public $weeks = [];
    public $personId = null;

    public function mount(Request $request)
    {
        $monthParam = $request->get('month');
        $this->month = $monthParam ? Carbon::parse($monthParam)->startOfMonth() : now()->startOfMonth();
        $this->loadMonth();
    }

    public function loadMonth()
    {
        $rokuyoService = new RokuyoService();
        $stemBranchService = new StemBranchService();
        $tsuhenseiService = new TsuhenseiService();
        $juuniunService = new JuuniunService();
        $luckRankService = new LuckRankService();
        $holidayService = new JapaneseHolidayService();

        $this->weeks = [];
        $today = now()->startOfDay();
        
        // 月の開始日（日曜日に調整）
        $startOfMonth = $this->month->copy()->startOfWeek(Carbon::SUNDAY);
        
        // 月の終了日（土曜日に調整）
        $endOfMonth = $this->month->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        
        $currentDate = $startOfMonth->copy();
        
        while ($currentDate->lte($endOfMonth)) {
            $weekDays = [];
            
            for ($i = 0; $i < 7; $i++) {
                $kanShi = $stemBranchService->getDayKanShi($currentDate);
                $subject = auth()->user();

                $weekDays[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'wday' => $currentDate->dayOfWeek,
                    'is_today' => $currentDate->equalTo($today),
                    'is_current_month' => $currentDate->month === $this->month->month,
                    'holiday' => $holidayService->getDayHoliday($currentDate),
                    'rokuyo' => $rokuyoService->getDayRokuyo($currentDate),
                    'kan' => $kanShi['tenkan'],
                    'shi' => $kanShi['chishi'],
                    'tsuhensei' => $tsuhenseiService->getDayTsuhensei($subject, $currentDate),
                    'juuniun' => $juuniunService->getDayJuuniun($subject, $currentDate),
                    'luck_rank' => $luckRankService->getDayLuckRank($subject, $currentDate),
                ];
                
                $currentDate->addDay();
            }
            
            $this->weeks[] = ['days' => $weekDays];
        }
    }

    public function prevMonth()
    {
        $this->month = $this->month->subMonth();
        $this->loadMonth();
    }

    public function thisMonth()
    {
        $this->month = now()->startOfMonth();
        $this->loadMonth();
    }

    public function nextMonth()
    {
        $this->month = $this->month->addMonth();
        $this->loadMonth();
    }

    public function render()
    {
        $monthData = [
            'month' => $this->month->format('Y-m-01'),
            'weeks' => $this->weeks,
            'person' => [
                'id' => null,
                'name' => 'あなた',
            ],
            'can_switch_person' => auth()->user()->hasActiveSubscription(),
        ];

        return view('livewire.astrology.calendar.monthly-index', compact('monthData'));
    }
}
