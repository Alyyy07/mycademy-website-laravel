<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot() : void
    {
        parent::boot();

        // Register the event to deactivate all other academic year when creating new academic year
        static::creating(function ($model) {
            if($model->is_active == '1'){
                $model->deactivateAll();
            }
        });
    }

    public function deactivateAll() : void
    {
        self::where('id', '!=', '0')->update(['is_current' => '0']);
    }

    public static function getActive(): ?array
    {
        $data = self::where('is_active', '1')->first();
        if ($data) {
            return $data->toArray();
        }
        return null;
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
