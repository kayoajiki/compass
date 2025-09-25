<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use App\Policies\ProfilePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCore extends Component
{
    use WithFileUploads;

    public $profile;
    public $name;
    public $last_name;
    public $first_name;
    public $last_name_kana;
    public $first_name_kana;
    public $birth_date;
    public $birth_time;
    public $birth_hour;
    public $birth_minute;
    public $birth_place_pref;
    public $sex = 'male';
    // longitude_adjust プロパティを削除（自動調整に変更）
    public $is_birth_time_unknown = true;
    public $is_editing = true; // 常に編集可能にする
    public $is_completed = false;

    protected $rules = [
        'last_name' => 'required|string|max:50',
        'first_name' => 'required|string|max:50',
        'last_name_kana' => 'required|string|max:50|regex:/^[ァ-ヶー\s]+$/u',
        'first_name_kana' => 'required|string|max:50|regex:/^[ァ-ヶー\s]+$/u',
        'birth_date' => 'required|date|before:today',
        'birth_hour' => 'nullable|integer|min:0|max:23',
        'birth_minute' => 'nullable|integer|min:0|max:59',
        'birth_place_pref' => 'required|string|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47',
        'sex' => 'required|in:male,female',
    ];

    protected $messages = [
        'last_name.required' => '姓を入力してください。',
        'first_name.required' => '名を入力してください。',
        'last_name_kana.required' => '姓のふりがなを入力してください。',
        'first_name_kana.required' => '名のふりがなを入力してください。',
        'last_name_kana.regex' => '姓のふりがなはカタカナで入力してください。',
        'first_name_kana.regex' => '名のふりがなはカタカナで入力してください。',
        'birth_date.required' => '生年月日を入力してください。',
        'birth_date.before' => '生年月日は今日より前の日付を入力してください。',
        'birth_hour.integer' => '時間は数値で入力してください。',
        'birth_hour.min' => '時間は0以上で入力してください。',
        'birth_hour.max' => '時間は23以下で入力してください。',
        'birth_minute.integer' => '分は数値で入力してください。',
        'birth_minute.min' => '分は0以上で入力してください。',
        'birth_minute.max' => '分は59以下で入力してください。',
        'birth_place_pref.required' => '出生地を選択してください。',
        'birth_place_pref.in' => '有効な都道府県を選択してください。',
        'sex.required' => '性別を選択してください。',
        'sex.in' => '有効な性別を選択してください。',
    ];

    public function mount()
    {
        $this->profile = Auth::user()->profile;
        $this->is_completed = $this->profile ? $this->profile->is_completed : false;
        
        if ($this->profile) {
            $this->name = $this->profile->name;
            $this->birth_date = $this->profile->birth_date?->format('Y-m-d');
            $this->birth_time = $this->profile->birth_time?->format('H:i');
            $this->birth_place_pref = $this->profile->birth_place_pref;
            $this->sex = $this->profile->sex ?? 'male';
            $this->is_birth_time_unknown = $this->profile->isBirthTimeUnknown();
            
            // 出生時刻を時・分に分解
            if ($this->profile->birth_time) {
                $this->birth_hour = $this->profile->birth_time->format('H');
                $this->birth_minute = $this->profile->birth_time->format('i');
            }
            
            // 氏名を姓・名に分解（既存データの場合は分割）
            $this->parseName();
        } else {
            // 新規作成の場合、ユーザー名を初期値に設定
            $this->name = Auth::user()->name;
            $this->parseName();
        }
    }

    public function resetForm()
    {
        $this->resetValidation();
        
        // 元の値に戻す
        if ($this->profile) {
            $this->name = $this->profile->name;
            $this->birth_date = $this->profile->birth_date?->format('Y-m-d');
            $this->birth_time = $this->profile->birth_time?->format('H:i');
            $this->birth_place_pref = $this->profile->birth_place_pref;
            $this->sex = $this->profile->sex ?? 'male';
            $this->is_birth_time_unknown = $this->profile->isBirthTimeUnknown();
            
            // 出生時刻を時・分に分解
            if ($this->profile->birth_time) {
                $this->birth_hour = $this->profile->birth_time->format('H');
                $this->birth_minute = $this->profile->birth_time->format('i');
            } else {
                $this->birth_hour = null;
                $this->birth_minute = null;
            }
            
            // 氏名を姓・名に分解
            $this->parseName();
        } else {
            $this->name = Auth::user()->name;
            $this->birth_date = '';
            $this->birth_time = '';
            $this->birth_place_pref = '';
            $this->is_birth_time_unknown = true;
            $this->birth_hour = null;
            $this->birth_minute = null;
            $this->parseName();
        }
    }

    public function save()
    {
        $this->validate();

        // 氏名を結合
        $this->combineName();

        // 出生時刻を時・分から組み立て
        if ($this->birth_hour !== null && $this->birth_hour !== '' && $this->birth_hour !== 'unknown' &&
            $this->birth_minute !== null && $this->birth_minute !== '' && $this->birth_minute !== 'unknown') {
            $this->birth_time = sprintf('%02d:%02d', $this->birth_hour, $this->birth_minute);
        } else {
            $this->birth_time = null;
        }

        try {
            if ($this->profile) {
                // 既存プロフィールの更新（name/birth_dateは更新不可）
                $updateData = [
                    'birth_time' => $this->birth_time,
                    'birth_place_pref' => $this->birth_place_pref,
                    'sex' => $this->sex,
                ];
                
                // 初回登録時のみname/birth_dateを設定
                if (!$this->is_completed) {
                    $updateData['name'] = $this->name;
                    $updateData['birth_date'] = $this->birth_date;
                }
                
                $this->profile->update($updateData);
            } else {
                // 新規プロフィールの作成
                $this->profile = Profile::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'birth_date' => $this->birth_date,
                    'birth_time' => $this->birth_time,
                    'birth_place_pref' => $this->birth_place_pref,
                    'sex' => $this->sex,
                ]);
            }

            // プロフィール完成フラグを設定
            if ($this->profile->isComplete()) {
                $this->profile->markAsCompleted();
                $this->is_completed = true;
            }

            $this->is_editing = false;
            session()->flash('message', 'プロフィールを保存しました。');
            
        } catch (\Exception $e) {
            $this->addError('general', '保存中にエラーが発生しました。もう一度お試しください。');
        }
    }

    public function getPrefectures()
    {
        return Profile::getPrefectures();
    }

    public function getBirthPlaceName()
    {
        $prefectures = $this->getPrefectures();
        return $prefectures[$this->birth_place_pref] ?? '';
    }

    public function getHourOptions()
    {
        $options = [];
        $options[''] = '時';
        $options['unknown'] = '不明';
        
        for ($hour = 0; $hour < 24; $hour++) {
            $options[$hour] = sprintf('%02d時', $hour);
        }
        
        return $options;
    }

    public function getMinuteOptions()
    {
        $options = [];
        $options[''] = '分';
        $options['unknown'] = '不明';
        
        for ($minute = 0; $minute < 60; $minute++) {
            $options[$minute] = sprintf('%02d分', $minute);
        }
        
        return $options;
    }

    public function canEditCoreData()
    {
        return !$this->is_completed;
    }

    /**
     * 氏名を姓・名に分解
     */
    public function parseName()
    {
        if (empty($this->name)) {
            $this->last_name = '';
            $this->first_name = '';
            $this->last_name_kana = '';
            $this->first_name_kana = '';
            return;
        }

        // 既存のnameフィールドから姓・名を推測（簡単な分割）
        $nameParts = explode(' ', trim($this->name));
        if (count($nameParts) >= 2) {
            $this->last_name = $nameParts[0];
            $this->first_name = implode(' ', array_slice($nameParts, 1));
        } else {
            // 1つの場合は姓として扱う
            $this->last_name = $this->name;
            $this->first_name = '';
        }
        
        // ふりがなは空で初期化
        $this->last_name_kana = '';
        $this->first_name_kana = '';
    }

    /**
     * 姓・名を結合してnameフィールドに設定
     */
    public function combineName()
    {
        $this->name = trim($this->last_name . ' ' . $this->first_name);
    }

    public function render()
    {
        return view('livewire.profile.edit-core');
    }
}
