<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Akademik\DataMahasiswa;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Services\ImpersonateManager;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, HasUuids, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => [
                'name' => $value,
                'slug' => Str::slug($value)
            ],
        );
    }
    public function getImpersonator()
    {
        return app(ImpersonateManager::class)->getImpersonator();
    }

    public function canImpersonate()
    {
        return $this->hasRole('super-admin');
    }

    public function matakuliahAsDosen()
    {
        return $this->hasMany(MappingMatakuliah::class, 'dosen_id');
    }

    public function matakuliahAsAdminVerifier()
    {
        return $this->hasMany(MappingMatakuliah::class, 'admin_verifier_id');
    }

    public function materisAsUploader()
    {
        return $this->hasMany(Materi::class, 'uploaded_by');
    }

    public function materisAsVerifier()
    {
        return $this->hasMany(Materi::class, 'verified_by');
    }

    public function mahasiswa(){
        return $this->hasOne(DataMahasiswa::class, 'user_id', 'id');
    }
}
