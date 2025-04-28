<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kuisses';

    public function rpsDetail()
    {
        return $this->belongsTo(RpsDetail::class, 'rps_detail_id');
    }
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    public function questions()
    {
        return $this->hasMany(KuisQuestion::class, 'kuis_id');
    }

    public function kuisMahasiswa()
    {
        return $this->hasMany(KuisMahasiswa::class, 'kuis_id');
    }
}
