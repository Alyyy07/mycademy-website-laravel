<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisOption extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kuis_options';
    public function kuisQuestion()
    {
        return $this->belongsTo(KuisQuestion::class, 'kuis_question_id');
    }
}
