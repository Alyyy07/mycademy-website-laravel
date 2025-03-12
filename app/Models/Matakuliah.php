<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mappingMatakuliahs()
    {
        return $this->hasMany(MappingMatakuliah::class);
    }   
}
