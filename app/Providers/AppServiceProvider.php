<?php

namespace App\Providers;

use App\Models\Akademik\Fakultas;
use App\Models\Akademik\Matakuliah;
use App\Models\Akademik\TahunAjaran;
use App\Models\User;
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
        User::observe(\App\Observers\UserObserver::class);
        TahunAjaran::observe(\App\Observers\TahunAjaranObserver::class);
        Matakuliah::observe(\App\Observers\MatakuliahObserver::class);
        Fakultas::observe(\App\Observers\FakultasObserver::class);
    }
}
