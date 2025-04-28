<?php

namespace App\Http\Resources;

use App\Models\Akademik\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $collects = User::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (is_null($this->email_verified_at)) {
            return [
                'email' => $this->email,
            ];
        }
        $token = $this->createToken('MyCademy')->plainTextToken;
        return [
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->image ? url("storage/$this->image") : url("storage/image/profile-photo/blank.png"),
            'token' => $token,
            'tahun_ajaran'=> TahunAjaran::getActive()['tahun_ajaran'],
        ];
    }

    public function with($request): array
    {
        if (is_null($this->email_verified_at)) {
            return [
                'status' => 'verify',
                'message' => 'Email belum diverifikasi',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'User berhasil login',
        ];
    }
}