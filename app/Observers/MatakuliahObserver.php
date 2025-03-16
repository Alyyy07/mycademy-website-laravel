<?php

namespace App\Observers;

use App\Models\Matakuliah;
use Illuminate\Support\Facades\Cache;

class MatakuliahObserver
{
    /**
     * Handle the Matakuliah "created" event.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return void
     */
    public function created(Matakuliah $matakuliah)
    {
        Cache::forget('matakuliah');
    }

    /**
     * Handle the Matakuliah "updated" event.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return void
     */
    public function updated(Matakuliah $matakuliah)
    {
        Cache::forget('matakuliah');
    }

    /**
     * Handle the Matakuliah "deleted" event.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return void
     */
    public function deleted(Matakuliah $matakuliah)
    {
        Cache::forget('matakuliah');
    }

    /**
     * Handle the Matakuliah "restored" event.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return void
     */
    public function restored(Matakuliah $matakuliah)
    {
        Cache::forget('matakuliah');
    }

    /**
     * Handle the Matakuliah "force deleted" event.
     *
     * @param  \App\Models\Matakuliah  $matakuliah
     * @return void
     */
    public function forceDeleted(Matakuliah $matakuliah)
    {
        Cache::forget('matakuliah');
    }
}
