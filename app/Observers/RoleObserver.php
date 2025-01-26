<?php

namespace App\Observers;

use App\Models\Roles;
use Illuminate\Support\Facades\Cache;

class RoleObserver
{
    /**
     * Handle the Roles "created" event.
     */
    public function created(Roles $roles): void
    {
        Cache::forget('roles',);
        Cache::forget('roles_with_permissions');
    }

    /**
     * Handle the Roles "updated" event.
     */
    public function updated(Roles $roles): void
    {
        Cache::forget('roles');
        Cache::forget('roles_with_permissions');
    }

    /**
     * Handle the Roles "deleted" event.
     */
    public function deleted(Roles $roles): void
    {
        Cache::forget('roles_with_permissions');
        Cache::forget('roles');
    }

    /**
     * Handle the Roles "restored" event.
     */
    public function restored(Roles $roles): void
    {
        Cache::forget('roles_with_permissions');
        Cache::forget('roles');
    }

    /**
     * Handle the Roles "force deleted" event.
     */
    public function forceDeleted(Roles $roles): void
    {
        Cache::forget('roles_with_permissions');
        Cache::forget('roles');
    }
}
