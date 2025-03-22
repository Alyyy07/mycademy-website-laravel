<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RpsDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rpsMatakuliah()
    {
        return $this->belongsTo(RpsMatakuliah::class,'rps_id','id');
    }
}
