<?php

namespace App\Observers;

use App\Models\Akademik\Prodi;
use Illuminate\Support\Facades\Cache;

class ProdiObserver
{
    public function created(Prodi $prodi)
    {
        Cache::forget('prodi_with_fakultas');
    }

    public function updated(Prodi $prodi)
    {
        Cache::forget('prodi_with_fakultas');
    }

    public function deleted(Prodi $prodi)
    {
        Cache::forget('prodi_with_fakultas');
    }
}
