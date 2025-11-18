<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RpsMatakuliah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mappingMatakuliah()
    {
        return $this->belongsTo(MappingMatakuliah::class);
    }

    public function rpsDetails()
    {
        return $this->hasMany(RpsDetail::class);
    }
}
