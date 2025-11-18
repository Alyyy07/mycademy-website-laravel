<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RpsDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

     protected $casts = [
        'tanggal_pertemuan'   => 'date',
        'tanggal_pengganti'   => 'date',
        'tanggal_realisasi'   => 'datetime',
        'close_forum'         => 'boolean',
    ];

    public function rpsMatakuliah()
    {
        return $this->belongsTo(RpsMatakuliah::class,'rps_matakuliah_id','id');
    }

    public function materi(){
        return $this->hasMany(Materi::class);
    }
    public function kuis()
    {
        return $this->hasMany(Kuis::class);
    }

    public function nextRpsDetail()
    {
        return self::where('rps_matakuliah_id', $this->rps_matakuliah_id)
            ->where('sesi_pertemuan', '>', $this->sesi_pertemuan)
            ->orderBy('sesi_pertemuan')
            ->first();
    }
}
