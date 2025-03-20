<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class RpsMatakuliahObserver
{
    public function created(){
        Cache::forget('rps_matakuliah_with_mapping_matakuliah');
    }
    public function updated(){
        Cache::forget('rps_matakuliah_with_mapping_matakuliah');
    }
    public function deleted(){
        Cache::forget('rps_matakuliah_with_mapping_matakuliah');
    }
}
