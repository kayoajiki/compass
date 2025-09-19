<?php

namespace App\Observers;

use App\Models\Profile;

class ProfileObserver
{
    /**
     * Handle the Profile "creating" event.
     */
    public function creating(Profile $profile): void
    {
        // 出生地が設定されている場合、経度補正を自動計算
        if ($profile->birth_place_pref) {
            $profile->longitude_adjust = $profile->calculateLongitudeAdjustment();
        }
    }

    /**
     * Handle the Profile "updating" event.
     */
    public function updating(Profile $profile): void
    {
        // 出生地が変更された場合、経度補正を再計算
        if ($profile->isDirty('birth_place_pref')) {
            $profile->longitude_adjust = $profile->calculateLongitudeAdjustment();
        }
    }

    /**
     * Handle the Profile "created" event.
     */
    public function created(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "updated" event.
     */
    public function updated(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "deleted" event.
     */
    public function deleted(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "restored" event.
     */
    public function restored(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "force deleted" event.
     */
    public function forceDeleted(Profile $profile): void
    {
        //
    }
}
