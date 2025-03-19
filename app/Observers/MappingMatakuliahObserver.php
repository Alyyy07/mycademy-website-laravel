<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class MappingMatakuliahObserver
{
    public function created(){
        Cache::forget('mapping_matakuliah');
    }
    public function updated(){
        Cache::forget('mapping_matakuliah');
    }
    public function deleted(){
        Cache::forget('mapping_matakuliah');
    }
}
