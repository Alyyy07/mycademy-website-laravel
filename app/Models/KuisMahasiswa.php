<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'kuis_mahasiswa';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }

    public function answers()
{
    return $this->hasMany(KuisMahasiswaAnswer::class);
}
}
