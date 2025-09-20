<?php

namespace App\Livewire\Dashboard;

use App\Domain\Astrology\Services\RokuyoService;
use App\Domain\Calendar\Services\StemBranchService;
use App\Domain\Calendar\Services\TsuhenseiService;
use App\Domain\Calendar\Services\JuuniunService;
use App\Domain\Calendar\Services\LuckRankService;
use App\Domain\Calendar\Services\JapaneseHolidayService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class WeeklyCalendar extends Component
{
    public $weekStart;
    public $days = [];
    public $personId = null;

    public function mount()
    {
        $this->weekStart = now()->startOfWeek(Carbon::SUNDAY);
        $this->loadWeek();
    }

    public function loadWeek()
    {
        $rokuyoService = new RokuyoService();
        $stemBranchService = new StemBranchService();
        $tsuhenseiService = new TsuhenseiService();
        $juuniunService = new JuuniunService();
        $luckRankService = new LuckRankService();
        $holidayService = new JapaneseHolidayService();

        $this->days = [];
        $today = now()->startOfDay();

        for ($i = 0; $i < 7; $i++) {
            $date = $this->weekStart->copy()->addDays($i);
            
            $kanShi = $stemBranchService->getDayKanShi($date);
            $subject = auth()->user();

            $this->days[] = [
                'date' => $date->format('Y-m-d'),
                'wday' => $date->dayOfWeek,
                'is_today' => $date->equalTo($today),
                'holiday' => $holidayService->getDayHoliday($date),
                'rokuyo' => $rokuyoService->getDayRokuyo($date),
                'kan' => $kanShi['tenkan'],
                'shi' => $kanShi['chishi'],
                'tsuhensei' => $tsuhenseiService->getDayTsuhensei($subject, $date),
                'juuniun' => $juuniunService->getDayJuuniun($subject, $date),
                'luck_rank' => $luckRankService->getDayLuckRank($subject, $date),
            ];
        }
    }

    public function prevWeek()
    {
        $this->weekStart = $this->weekStart->subWeek();
        $this->loadWeek();
    }

    public function nextWeek()
    {
        $this->weekStart = $this->weekStart->addWeek();
        $this->loadWeek();
    }

    public function toMonthly()
    {
        return redirect()->route('calendar', ['month' => $this->weekStart->format('Y-m')]);
    }

    public function render()
    {
        $weekData = [
            'start' => $this->weekStart->format('Y-m-d'),
            'end' => $this->weekStart->copy()->addDays(6)->format('Y-m-d'),
            'days' => $this->days,
            'person' => [
                'id' => null,
                'name' => 'あなた',
            ],
            'can_switch_person' => auth()->user()->hasActiveSubscription(),
        ];

        return view('livewire.dashboard.weekly-calendar', compact('weekData'));
    }
}
