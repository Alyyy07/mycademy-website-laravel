<?php

namespace App\Models\Akademik;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function matakuliahs()
    {
        return $this->hasMany(Matakuliah::class, 'prodi_id', 'id');
    }

    public function mahasiswas()
    {
        return $this->hasMany(DataMahasiswa::class, 'prodi_id', 'id');
    }
    public function dosens()
    {
        return $this->hasMany(User::class, 'prodi_id', 'id');
    }
}
