<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot(): void
    {
        parent::boot();

        // Saat membuat data baru, jika is_active = 1, maka nonaktifkan tahun ajaran lain
        static::creating(function ($model) {
            if ($model->is_active == '1') {
                $model->deactivateAll();
            }
        });

        // Saat memperbarui data, jika is_active diubah ke 1, maka nonaktifkan tahun ajaran lain
        static::updating(function ($model) {
            if ($model->is_active == '1') {
                $model->deactivateAll();
            }
        });
    }

    /**
     * Menonaktifkan semua tahun ajaran kecuali yang sedang diaktifkan
     */
    public function deactivateAll(): void
    {
        self::where('id', '!=', $this->id)->update(['is_active' => '0']);
    }

    /**
     * Mengambil tahun ajaran yang sedang aktif
     */
    public static function getActive(): ?array
    {
        $data = self::where('is_active', '1')->first();
        return $data ? $data->toArray() : null;
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
