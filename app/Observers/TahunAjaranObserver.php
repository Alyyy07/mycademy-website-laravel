<?php

namespace App\Observers;

use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Cache;

class TahunAjaranObserver
{
    public function created(TahunAjaran $tahunAjaran): void
    {
        Cache::forget('tahun_ajaran');
    }

    public function updated(TahunAjaran $tahunAjaran): void
    {
        Cache::forget('tahun_ajaran');
    }

    public function deleted(TahunAjaran $tahunAjaran): void
    {
        Cache::forget('tahun_ajaran');
    }

    public function restored(TahunAjaran $tahunAjaran): void
    {
        Cache::forget('tahun_ajaran');
    }

    public function forceDeleted(TahunAjaran $tahunAjaran): void
    {
        Cache::forget('tahun_ajaran');
    }
}
