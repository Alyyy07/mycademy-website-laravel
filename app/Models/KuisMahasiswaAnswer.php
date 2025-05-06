<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuisMahasiswaAnswer extends Model
{
    protected $table = 'kuis_mahasiswa_answers';
    protected $fillable = ['kuis_mahasiswa_id','question_id','option_id'];

    public function kuisMahasiswa()
    {
        return $this->belongsTo(KuisMahasiswa::class);
    }
}
