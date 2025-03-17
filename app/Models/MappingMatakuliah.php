<?php

namespace App\Models;

use App\Models\Akademik\Matakuliah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingMatakuliah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }
    public function dosen()
    {
        return $this->belongsTo(User::class,'dosen_id');
    }
    public function admin_verifier()
    {
        return $this->belongsTo(User::class,'admin_verifier_id');
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }
}
