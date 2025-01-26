<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the user "created" event.
     */
    public function created(User $user): void
    {
        Cache::forget('users_with_roles');
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(User $user): void
    {
        Cache::forget('users_with_roles');
    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(User $user): void
    {
        Cache::forget('users_with_roles');
    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(User $user): void
    {
        Cache::forget('users_with_roles');
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        Cache::forget('users_with_roles');
    }
}
