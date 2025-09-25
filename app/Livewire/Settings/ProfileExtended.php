<?php

namespace App\Livewire\Settings;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProfileExtended extends Component
{
    // 基本情報
    public string $name = '';
    public string $email = '';

    // 四柱推命用情報
    public ?string $birth_date = null;
    public ?string $birth_time = null;
    public string $birth_place_pref = '';
    public string $sex = 'male';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        // プロフィール情報があれば読み込み
        if ($user->profile) {
            $this->birth_date = $user->profile->birth_date?->format('Y-m-d');
            $this->birth_time = $user->profile->birth_time?->format('H:i');
            $this->birth_place_pref = $user->profile->birth_place_pref ?? '';
            $this->sex = $user->profile->sex ?? 'male';
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'birth_date' => ['required', 'date', 'before:today'],
            'birth_time' => ['nullable', 'date_format:H:i'],
            'birth_place_pref' => ['required', 'string', 'size:2'],
            'sex' => ['required', 'in:male,female'],
        ]);

        // ユーザー基本情報を更新
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // プロフィール情報を更新または作成
        $profileData = [
            'name' => $validated['name'],
            'birth_date' => $validated['birth_date'],
            'birth_time' => $validated['birth_time'],
            'birth_place_pref' => $validated['birth_place_pref'],
            'sex' => $validated['sex'],
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        // プロフィール完成フラグを更新
        $user->profile->markAsCompleted();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    /**
     * 都道府県のリストを取得
     */
    public function getPrefectures(): array
    {
        return Profile::getPrefectures();
    }
}