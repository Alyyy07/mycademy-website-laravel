<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\VerificationMail;
use App\Models\Akademik\TahunAjaran;
use App\Models\MappingMatakuliah;
use App\Models\RpsMatakuliah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->with('roles')->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau Password Salah'
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau Password Salah'
            ], 401);
        }

        if ($user->hasRole('mahasiswa')) {
            return new UserResource($user);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak memiliki akses'
        ], 403);
    }

    // public function loginWithGoogle(Request $request)
    // {
    //     $user = User::where('email', $request->email)->with('roles')->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Email atau Password Salah'
    //         ], 401);
    //     }

    //     if (!Hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Email atau Password Salah'
    //         ], 401);
    //     }

    //     if ($user->hasRole('mahasiswa')) {
    //         $user->email_verified_at = now();
    //         $user->verification_code = null;
    //         $user->save();
    //         return new UserResource($user);
    //     }

    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Anda tidak memiliki akses'
    //     ], 403);
    // }

    public function register(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Membuat pengguna baru
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $verificationCode = rand(100000, 999999);
        $data['verification_code'] = $verificationCode;
        $user = User::create($data);

        return response()->json(['status' => 'success', 'data' => ['email' => $user->email], 'message' => 'Akun anda berhasil dibuat'], 201);
    }


    public function sendVerificationEmail(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Email parameter is missing'], 400);
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->email_verified_at != null) {
                return response()->json(['status' => 'error', 'message' => 'Email anda sudah terverifikasi'], 400);
            }

            // Generate verification code if it is null
            if ($user->verification_code == null) {
                $user->verification_code = rand(100000, 999999); // Generate a random 6 character code
                $user->save();
            }

            $verificationCode = $user->verification_code;

            try {
                // Kirim email verifikasi
                Mail::to($user->email)->send(new VerificationMail($user));

                return response()->json(['status' => 'success', 'message' => 'Kode verifikasi berhasil dikirim ke email Anda', 'data' => ['verificationCode' => $verificationCode]], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => "email:$user->email, kode: $verificationCode, gagal bro :" . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }
    }

    public function verifyEmail(Request $request)
    {
        $email = $request->email;
        $verificationCode = $request->verificationCode;
        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->verification_code == $verificationCode) {
                $user->email_verified_at = now();
                $user->verification_code = null;
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Email berhasil diverifikasi'], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Kode verifikasi salah'], 400);
        }

        return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
    }

    public function getVerificationCode(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $verificationCode = rand(100000, 999999);
            $user->verification_code = $verificationCode;
            $user->save();
            try {

                // Kirim email verifikasi
                Mail::to($user->email)->send(new VerificationMail($user));

                return response()->json(['status' => 'success', 'message' => 'Kode verifikasi berhasil dikirim ke email Anda', 'data' => ['verificationCode' => $verificationCode]], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
    }

    public function getMataKuliah(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        if ($user->hasRole('mahasiswa')) {
            $tahunAjaran = TahunAjaran::getActive();

            $mappings = MappingMatakuliah::with([
                'matakuliah:id,nama_matakuliah,prodi_id',
                'dosen:id,name',
                'rpsMatakuliahs:id,mapping_matakuliah_id',
                'rpsMatakuliahs.rpsDetails:id,rps_matakuliah_id'
            ])
                ->whereHas('matakuliah', function ($q) use ($user) {
                    $q->where('prodi_id', $user->mahasiswa->prodi_id);
                })
                ->where('semester', $user->mahasiswa->semester)
                ->where('tahun_ajaran_id', $tahunAjaran['id'])
                ->get();

            $rpsDetailIds = $mappings->flatMap(function ($mapping) {
                $rpsMatakuliah = $mapping->rpsMatakuliahs;

                return $rpsMatakuliah ? optional($rpsMatakuliah->rpsDetails)->pluck('id') : [];
            })->unique()->values();

            $materis = DB::table('materis')
                ->whereIn('rps_detail_id', $rpsDetailIds)
                ->select('id', 'rps_detail_id')
                ->get();

            $kuis = DB::table('kuisses')
                ->whereIn('rps_detail_id', $rpsDetailIds)
                ->select('id', 'rps_detail_id')
                ->get();

            $materiSelesaiIds = DB::table('materi_mahasiswa')
                ->whereIn('materi_id', $materis->pluck('id'))
                ->where('user_id', $user->id)
                ->pluck('materi_id')
                ->toArray();

            $kuisSelesaiIds = DB::table('kuis_mahasiswa')
                ->whereIn('kuis_id', $kuis->pluck('id'))
                ->where('user_id', $user->id)
                ->pluck('kuis_id')
                ->toArray();

            $data = $mappings->map(function ($mapping) use ($materis, $kuis, $materiSelesaiIds, $kuisSelesaiIds) {
                $rpsDetailIds = optional($mapping->rpsMatakuliahs)->rpsDetails->pluck('id') ?? collect();

                $totalMateri = $materis->whereIn('rps_detail_id', $rpsDetailIds)->count();
                $totalKuis = $kuis->whereIn('rps_detail_id', $rpsDetailIds)->count();

                $materiSelesai = $materis->whereIn('rps_detail_id', $rpsDetailIds)
                    ->whereIn('id', $materiSelesaiIds)
                    ->count();

                $kuisSelesai = $kuis->whereIn('rps_detail_id', $rpsDetailIds)
                    ->whereIn('id', $kuisSelesaiIds)
                    ->count();

                return [
                    'id' => $mapping->id,
                    'nama_matakuliah' => $mapping->matakuliah->nama_matakuliah,
                    'dosen' => $mapping->dosen->name,
                    'total_materi' => $totalMateri,
                    'materi_selesai' => $materiSelesai,
                    'total_kuis' => $totalKuis,
                    'kuis_selesai' => $kuisSelesai,
                ];
            });

            return response()->json(['status' => 'success', 'data' => $data], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Role tidak sesuai'], 403);
    }

    public function getMataKuliahById(Request $request)
    {

        $id = $request->query('id');
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'ID parameter is missing'], 400);
        }
        $mapping = MappingMatakuliah::with([
            'matakuliah:id,nama_matakuliah,prodi_id,deskripsi',
            'dosen:id,name',
            'rpsMatakuliahs:id,mapping_matakuliah_id',
            'rpsMatakuliahs.rpsDetails'
        ])
            ->where('id', $id)
            ->first();
        if (!$mapping) {
            return response()->json(['status' => 'error', 'message' => 'Mapping Matakuliah tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => [
            'id' => $mapping->rpsMatakuliahs()->pluck('id'),
            'nama_matakuliah' => $mapping->matakuliah->nama_matakuliah,
            'deskripsi' => $mapping->matakuliah->deskripsi,
            'rps_details' => $mapping->rpsMatakuliahs->rpsDetails->map(function ($rpsDetail) {
                return [
                    'id' => $rpsDetail->id,
                    'sesi_pertemuan' => $rpsDetail->sesi_pertemuan,
                    'tanggal_pertemuan' => $rpsDetail->tanggal_pertemuan,
                    'tanggal_realisasi' => $rpsDetail->tanggal_realisasi,
                    'close_forum' => $rpsDetail->close_forum,
                    'materi' => $rpsDetail->materi->filter(fn($materi)=> $materi->status === 'verified'),
                    'kuis' => $rpsDetail->kuis->filter(fn($kuis)=> $kuis->status === 'verified'),
                ];
            }),
        ]], 200);
    }

    public function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }
        $user->last_login_at = now();
        $user->save();

        $user->tokens()->delete();
        return response()->json(['status' => 'success', 'message' => 'Berhasil logout'], 200);
    }
}
