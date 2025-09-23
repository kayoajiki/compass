<?php

namespace App\Livewire\Astrology\Numerology;

use Livewire\Component;
use App\Domain\Astrology\Services\MockChartsService;
use App\Domain\Astrology\DTOs\NumerologyDTO;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            // 実際のプロフィールデータから過去数、ライフパスナンバー、未来数、パーソナルイヤーを計算
            $pastNumber = $this->calculatePastNumber();
            $lifePathNumber = $this->calculateLifePathNumber();
            $futureNumber = $this->calculateFutureNumber();
            $personalYearNumber = $this->calculatePersonalYearNumber();
            
            
            $mockService = new MockChartsService();
            $dto = $mockService->getNumerology($this->selectedPersonId);
            $chartData = $dto->toArray();
            
            // 過去数、ライフパスナンバー、未来数、パーソナルイヤーを実際の計算結果で上書き
            $chartData['past_number'] = $pastNumber;
            $chartData['life_path_number'] = $lifePathNumber;
            $chartData['future_number'] = $futureNumber;
            
            // パーソナルイヤーの年数と数値を設定
            if (isset($chartData['personal_year'])) {
                $chartData['personal_year']['current_year'] = date('Y');
                $chartData['personal_year']['personal_year_number'] = $personalYearNumber;
            }
            
            $this->chartData = $chartData;
        } catch (\Exception $e) {
            $this->chartData = [
                'past_number' => 7,
                'life_path_number' => 3,
                'future_number' => 9,
                'personal_year' => [
                    'current_year' => date('Y'),
                    'personal_year_number' => 5,
                    'description' => '変化と自由の年'
                ]
            ];
        }
        
        $this->isLoading = false;
    }
    
    /**
     * 過去数を計算する
     * 生年月日の日付部分を一桁になるまで足し算
     * 11・22・33の場合はそのまま返す
     */
    private function calculatePastNumber(): int
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        if (!$profile || !$profile->birth_date) {
            return 7; // デフォルト値
        }
        
        $birthDate = $profile->birth_date;
        $day = $birthDate->day;
        
        // 過去数の計算ロジック
        $pastNumber = $this->reduceToSingleDigit($day);
        
        return $pastNumber;
    }
    
    /**
     * ライフパスナンバーを計算する
     * 生年月日の全ての数字を一桁になるまで足し算
     * 11・22・33の場合はそのまま返す
     */
    private function calculateLifePathNumber(): int
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        if (!$profile || !$profile->birth_date) {
            return 3; // デフォルト値
        }
        
        $birthDate = $profile->birth_date;
        
        // 年月日の全ての数字を取得
        $year = $birthDate->year;
        $month = $birthDate->month;
        $day = $birthDate->day;
        
        // 全ての数字を足し算
        $totalSum = $this->sumAllDigits($year) + $this->sumAllDigits($month) + $this->sumAllDigits($day);
        
        // 一桁になるまで足し算
        $lifePathNumber = $this->reduceToSingleDigit($totalSum);
        
        return $lifePathNumber;
    }
    
    /**
     * 数値の全ての桁を足し算する
     */
    private function sumAllDigits(int $number): int
    {
        $sum = 0;
        while ($number > 0) {
            $sum += $number % 10;
            $number = intval($number / 10);
        }
        return $sum;
    }
    
    /**
     * 未来数を計算する
     * 生年月日の月と日の数字を一桁になるまで足し算
     * 11・22・33の場合はそのまま返す
     */
    private function calculateFutureNumber(): int
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        if (!$profile || !$profile->birth_date) {
            return 9; // デフォルト値
        }
        
        $birthDate = $profile->birth_date;
        
        // 月と日の数字を取得
        $month = $birthDate->month;
        $day = $birthDate->day;
        
        // 月と日の全ての数字を足し算
        $totalSum = $this->sumAllDigits($month) + $this->sumAllDigits($day);
        
        // 一桁になるまで足し算
        $futureNumber = $this->reduceToSingleDigit($totalSum);
        
        return $futureNumber;
    }
    
    /**
     * 数値を一桁になるまで足し算する
     * 11・22・33の場合はそのまま返す
     */
    private function reduceToSingleDigit(int $number): int
    {
        // 11・22・33はそのまま返す
        if (in_array($number, [11, 22, 33])) {
            return $number;
        }
        
        // 一桁になるまで足し算
        while ($number > 9) {
            $sum = 0;
            while ($number > 0) {
                $sum += $number % 10;
                $number = intval($number / 10);
            }
            $number = $sum;
            
            // 途中で11・22・33になった場合はそのまま返す
            if (in_array($number, [11, 22, 33])) {
                return $number;
            }
        }
        
        return $number;
    }
    
    /**
     * パーソナルイヤーを計算する
     * 現在の西暦と生年月日を一桁になるまで足し算
     * 誕生日を迎えていない場合は前年の西暦を使用
     * 11・22・33の場合はそのまま返す
     */
    private function calculatePersonalYearNumber(): int
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        if (!$profile || !$profile->birth_date) {
            return 5; // デフォルト値
        }
        
        $birthDate = $profile->birth_date;
        $today = Carbon::today();
        
        // 今年の誕生日を計算
        $thisYearBirthday = Carbon::create(date('Y'), $birthDate->month, $birthDate->day);
        
        // 誕生日を迎えているかチェック
        $currentYear = $today->year;
        if ($today->lt($thisYearBirthday)) {
            // まだ誕生日を迎えていない場合は前年を使用
            $currentYear = $today->year - 1;
        }
        
        // 現在の西暦と生年月日の全ての数字を足し算
        $yearSum = $this->sumAllDigits($currentYear);
        $monthSum = $this->sumAllDigits($birthDate->month);
        $daySum = $this->sumAllDigits($birthDate->day);
        
        $totalSum = $yearSum + $monthSum + $daySum;
        
        
        // 一桁になるまで足し算
        $personalYearNumber = $this->reduceToSingleDigit($totalSum);
        
        return $personalYearNumber;
    }

    public function render()
    {
        return view('livewire.astrology.numerology.chart');
    }
}
