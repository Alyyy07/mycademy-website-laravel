<?php

namespace App\Providers;

use App\Models\Akademik\Fakultas;
use App\Models\Akademik\Matakuliah;
use App\Models\Akademik\Prodi;
use App\Models\Akademik\TahunAjaran;
use App\Models\MappingMatakuliah;
use App\Models\RpsMatakuliah;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        RedirectIfAuthenticated::redirectUsing(function ($request) {
            return '/dashboard';
        });

        Authenticate::redirectUsing(function ($request) {
            return '/';
        });

        User::observe(\App\Observers\UserObserver::class);
        TahunAjaran::observe(\App\Observers\TahunAjaranObserver::class);
        Matakuliah::observe(\App\Observers\MatakuliahObserver::class);
        Fakultas::observe(\App\Observers\FakultasObserver::class);
        Prodi::observe(\App\Observers\ProdiObserver::class);
        MappingMatakuliah::observe(\App\Observers\MappingMatakuliahObserver::class);
        RpsMatakuliah::observe(\App\Observers\RpsMatakuliahObserver::class);
    }
}
