<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kuis_questions';
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }
    public function options()
    {
        return $this->hasMany(KuisOption::class, 'kuis_question_id');
    }
}
