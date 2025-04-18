<?php

namespace App\Models\Akademik;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMahasiswa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
