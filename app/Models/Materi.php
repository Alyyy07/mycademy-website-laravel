<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rpsDetail()
    {
        return $this->belongsTo(RpsDetail::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function discussions()
    {
        return $this->hasMany(DiscussionMessage::class);
    }

    public function materiMahasiswa()
    {
        return $this->hasMany(MateriMahasiswa::class);
    }
}
