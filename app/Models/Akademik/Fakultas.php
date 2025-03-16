<?php

namespace App\Models\Akademik;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function prodis()
    {
        return $this->hasMany(Prodi::class, 'fakultas_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'fakultas_id', 'id');
    }
}
