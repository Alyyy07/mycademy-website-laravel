<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class FakultasObserver
{
    public function created($fakultas)
    {
        Cache::forget('fakultas');
    }

    public function updated($fakultas)
    {
        Cache::forget('fakultas');
    }

    public function deleted($fakultas)
    {
        Cache::forget('fakultas');
    }
}
