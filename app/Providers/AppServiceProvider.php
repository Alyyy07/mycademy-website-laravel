<?php

namespace App\Providers;

use App\Models\Roles;
use App\Models\Setting\Menus;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Contracts\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(\App\Observers\UserObserver::class);
        Roles::observe(\App\Observers\RoleObserver::class);
        Menus::observe(\App\Observers\MenuObserver::class);
    }
}
