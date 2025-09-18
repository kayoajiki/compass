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
    public $birth_date;
    public $birth_time;
    public $birth_place;
    public $is_birth_time_unknown = true;
    public $is_editing = false;
    public $is_completed = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'birth_date' => 'required|date|before:today',
        'birth_time' => 'nullable|date_format:H:i',
        'birth_place' => 'required|string|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47',
    ];

    protected $messages = [
        'name.required' => '氏名を入力してください。',
        'birth_date.required' => '生年月日を入力してください。',
        'birth_date.before' => '生年月日は今日より前の日付を入力してください。',
        'birth_place.required' => '出生地を選択してください。',
        'birth_place.in' => '有効な都道府県を選択してください。',
    ];

    public function mount()
    {
        $this->profile = Auth::user()->profile;
        $this->is_completed = $this->profile ? $this->profile->is_completed : false;
        
        if ($this->profile) {
            $this->name = $this->profile->name;
            $this->birth_date = $this->profile->birth_date?->format('Y-m-d');
            $this->birth_time = $this->profile->birth_time?->format('H:i');
            $this->birth_place = $this->profile->birth_place;
            $this->is_birth_time_unknown = $this->profile->isBirthTimeUnknown();
        } else {
            // 新規作成の場合、ユーザー名を初期値に設定
            $this->name = Auth::user()->name;
        }
    }

    public function startEditing()
    {
        if ($this->is_completed) {
            // 完成済みの場合、核データの編集は不可
            $this->addError('general', '氏名と生年月日は一度登録すると変更できません。');
            return;
        }

        $this->is_editing = true;
    }

    public function cancelEditing()
    {
        $this->is_editing = false;
        $this->resetValidation();
        
        // 元の値に戻す
        if ($this->profile) {
            $this->name = $this->profile->name;
            $this->birth_date = $this->profile->birth_date?->format('Y-m-d');
            $this->birth_time = $this->profile->birth_time?->format('H:i');
            $this->birth_place = $this->profile->birth_place;
            $this->is_birth_time_unknown = $this->profile->isBirthTimeUnknown();
        } else {
            $this->name = Auth::user()->name;
            $this->birth_date = '';
            $this->birth_time = '';
            $this->birth_place = '';
            $this->is_birth_time_unknown = true;
        }
    }

    public function save()
    {
        $this->validate();

        // 出生時刻が不明の場合はnullに設定
        if ($this->is_birth_time_unknown) {
            $this->birth_time = null;
        }

        try {
            if ($this->profile) {
                // 既存プロフィールの更新
                $this->profile->update([
                    'name' => $this->name,
                    'birth_date' => $this->birth_date,
                    'birth_time' => $this->birth_time,
                    'birth_place' => $this->birth_place,
                ]);
            } else {
                // 新規プロフィールの作成
                $this->profile = Profile::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'birth_date' => $this->birth_date,
                    'birth_time' => $this->birth_time,
                    'birth_place' => $this->birth_place,
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
        return $prefectures[$this->birth_place] ?? '';
    }

    public function canEditCoreData()
    {
        return !$this->is_completed;
    }

    public function render()
    {
        return view('livewire.profile.edit-core');
    }
}
