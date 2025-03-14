<?php

namespace App\Providers;

use App\Models\Roles;
use App\Models\Setting\Menus;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

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
        TahunAjaran::observe(\App\Observers\TahunAjaranObserver::class);
    }
}
