<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can update the model's core data (name, birth_date).
     * 核データ（氏名・生年月日）の更新は禁止
     */
    public function updateCoreData(User $user, Profile $profile): bool
    {
        // プロフィールが未完成の場合のみ更新可能
        return $user->id === $profile->user_id && !$profile->is_completed;
    }

    /**
     * Determine whether the user can update the model's birth time.
     * 出生時刻の更新は常に可能（不明から確定への変更）
     */
    public function updateBirthTime(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can update the model's birth place.
     * 出生地の更新は常に可能
     */
    public function updateBirthPlace(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Profile $profile): bool
    {
        return false; // プロフィールは削除不可
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Profile $profile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Profile $profile): bool
    {
        return false;
    }
}
