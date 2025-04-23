<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscussionMessage extends Model
{
    protected $fillable = [
        'materi_id',
        'sender_id',
        'message',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
