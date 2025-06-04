<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\VerificationMail;
use App\Models\Akademik\TahunAjaran;
use App\Models\DiscussionMessage;
use App\Models\Kuis;
use App\Models\KuisMahasiswa;
use App\Models\KuisMahasiswaAnswer;
use App\Models\MappingMatakuliah;
use App\Models\Materi;
use App\Models\MateriMahasiswa;
use App\Models\RpsMatakuliah;
use App\Models\User;
use Carbon\Carbon;
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
                'matakuliah:id,nama_matakuliah,deskripsi,prodi_id',
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
                ->select('id', 'rps_detail_id', 'status')
                ->get();

            $kuis = DB::table('kuisses')
                ->whereIn('rps_detail_id', $rpsDetailIds)
                ->select('id', 'rps_detail_id', 'status')
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

                $totalMateri = $materis->whereIn('rps_detail_id', $rpsDetailIds)->where('status', 'verified')->count();
                $totalKuis = $kuis->whereIn('rps_detail_id', $rpsDetailIds)->where('status', 'verified')->count();
                $materiSelesai = $materis->whereIn('rps_detail_id', $rpsDetailIds)
                    ->whereIn('id', $materiSelesaiIds)
                    ->count();

                $kuisSelesai = $kuis->whereIn('rps_detail_id', $rpsDetailIds)
                    ->whereIn('id', $kuisSelesaiIds)
                    ->count();

                return [
                    'id' => $mapping->id,
                    'nama_matakuliah' => $mapping->matakuliah->nama_matakuliah,
                    'deskripsi' => $mapping->matakuliah->deskripsi,
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
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }
        if (!$user->hasRole('mahasiswa')) {
            return response()->json(['status' => 'error', 'message' => 'Role tidak sesuai'], 403);
        }

        $id = $request->query('id');
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'ID parameter is missing'], 400);
        }
        $mapping = MappingMatakuliah::with([
            'matakuliah:id,prodi_id',
            'dosen:id,name',
            'rpsMatakuliahs.rpsDetails:id,rps_matakuliah_id,sesi_pertemuan,tanggal_pertemuan,tanggal_realisasi',
            'rpsMatakuliahs.rpsDetails.materi:id,rps_detail_id,title,tipe_materi,status',
            'rpsMatakuliahs.rpsDetails.kuis:id,rps_detail_id,title,description,status',
            'rpsMatakuliahs.rpsDetails.materi.materiMahasiswa:id,materi_id,user_id',
            'rpsMatakuliahs.rpsDetails.kuis.kuisMahasiswa:id,kuis_id,user_id',
        ])
            ->where('id', $id)
            ->first();
        if (!$mapping) {
            return response()->json(['status' => 'error', 'message' => 'Mapping Matakuliah tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => [
            'id' => $mapping->rpsMatakuliahs()->pluck('id'),
            'rps_details' => $mapping->rpsMatakuliahs->rpsDetails->map(function ($rpsDetail) use ($user) {
                $tglEfektif = ($rpsDetail->status_pengganti === 'approved' && $rpsDetail->tanggal_pengganti)
                    ? $rpsDetail->tanggal_pengganti
                    : $rpsDetail->tanggal_pertemuan;
                return [
                    'id' => $rpsDetail->id,
                    'sesi_pertemuan' => $rpsDetail->sesi_pertemuan,
                    'tanggal_pertemuan' => $tglEfektif,
                    'tanggal_realisasi' => $rpsDetail->tanggal_realisasi,
                    'materi_selesai_all' => $rpsDetail->materi
                        ->filter(fn($materi) => $materi->status === 'verified')
                        ->every(fn($materi) => $materi->materiMahasiswa->where('user_id', $user->id)->count() > 0),
                    'materi' => $rpsDetail->materi
                        ->filter(fn($materi) => $materi->status === 'verified')
                        ->map(function ($materi) use ($user) {
                            return [
                                'id' => $materi->id,
                                'title' => $materi->title,
                                'tipe_materi' => $materi->tipe_materi,
                                'materi_selesai' => $materi->materiMahasiswa->where('user_id', $user->id)->count() ? 1 : 0,
                            ];
                        }),
                    'kuis' => $rpsDetail->kuis
                        ->filter(fn($kuis) => $kuis->status === 'verified')
                        ->map(function ($kuis) use ($user) {
                            return [
                                'id' => $kuis->id,
                                'title' => $kuis->title,
                                'description' => $kuis->description,
                                'kuis_selesai' => $kuis->kuisMahasiswa->where('user_id', $user->id)->count() > 0 ? 1 : 0,
                            ];
                        }),
                ];
            }),
        ]], 200);
    }

    public function getMateri(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        $materi = Materi::with([
            'rpsDetail:id,tanggal_realisasi'
        ])->find($request->query('id'));
        if (!$materi) {
            return response()->json(['status' => 'error', 'message' => 'Materi tidak ditemukan'], 404);
        }

        $materi_selesai = MateriMahasiswa::where('materi_id', $materi->id)
            ->where('user_id', $user->id)
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => array_merge($materi->toArray(), [
                'materi_selesai' => $materi_selesai ? 1 : 0,
                'tanggal_selesai' => $materi_selesai->created_at ?? null,
            ])
        ], 200);
    }

    public function getKuis(Request $request)
    {
        // validasi minimal email dan id
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'id'    => 'required|integer|exists:kuisses,id',
        ]);

        // ambil user
        $user = User::where('email', $request->email)->firstOrFail();

        // ambil kuis beserta soal & opsi
        $kuis = Kuis::with('questions.options')->findOrFail($request->query('id'));
        $rpsDetail = $kuis->rpsDetail;
        $nextRpsDetail = $kuis->rpsDetail->nextRpsDetail();

        // 3. Ambil RpsDetail berikutnya (jika ada), kemudian hitung tanggal efektif next
        $nextRpsDetail = $rpsDetail->nextRpsDetail();
        $tglEfektifNext = null;
        if ($nextRpsDetail) {
            $tglEfektifNext = ($nextRpsDetail->status_pengganti === 'approved' && $nextRpsDetail->tanggal_pengganti)
                ? $nextRpsDetail->tanggal_pengganti
                : $nextRpsDetail->tanggal_pertemuan;
        }

        // cek apakah mahasiswa sudah pernah menyelesaikan
        $km = KuisMahasiswa::with('answers')
            ->where('kuis_id', $kuis->id)
            ->where('user_id', $user->id)
            ->first();

        // bangun struktur data response
        $data = array_merge($kuis->toArray(), [
            'kuis_selesai'    => $km ? 1 : 0,
            'tanggal_selesai' => $km?->updated_at?->toISOString() ?? null,
            'nilai'           => $km?->nilai ?? null,
            'answers'         => $km
                ? $km->answers->map(fn($a) => [
                    'question_id' => $a->question_id,
                    'option_id'   => $a->option_id,
                ])->toArray()
                : [],
            'can_view_history' =>  $tglEfektifNext
                ? Carbon::now()->greaterThanOrEqualTo($tglEfektifNext)
                : false,
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ], 200);
    }


    public function setMateriSelesai(Request $request)
    {
        $request->validate([
            'materi_id' => 'required|exists:materis,id',
            'email' => 'required|email|exists:users,email',
            'skala_pemahaman' => 'required|min:1|max:4',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        $materiMahasiswa = MateriMahasiswa::updateOrCreate(
            ['materi_id' => $request->materi_id, 'user_id' => $user->id],
            ['skala_pemahaman' => $request->skala_pemahaman]
        );
        if (!$materiMahasiswa) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan data'], 500);
        }

        return response()->json(['status' => 'success', 'message' => 'Materi ditandai selesai'], 200);
    }

    public function setKuisSelesai(Request $request)
    {
        $request->validate([
            'kuis_id'    => 'required|exists:kuisses,id',
            'email'      => 'required|email|exists:users,email',
            'nilai'      => 'required|numeric|min:0|max:100',
            'answers'    => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:kuis_questions,id',
            'answers.*.option_id'   => 'required|exists:kuis_options,id',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $km = KuisMahasiswa::updateOrCreate(
            ['kuis_id' => $request->kuis_id, 'user_id' => $user->id],
            ['nilai' => $request->nilai]
        );

        $km->answers()->delete();

        $insert = collect($request->answers)->map(function ($a) use ($km) {
            return [
                'kuis_mahasiswa_id' => $km->id,
                'question_id'       => $a['question_id'],
                'option_id'         => $a['option_id'],
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        })->toArray();
        KuisMahasiswaAnswer::insert($insert);

        return response()->json([
            'status'  => 'success',
            'message' => 'Kuis ditandai selesai',
            'data'    => [
                'kuis_mahasiswa_id' => $km->id,
                'nilai'             => $km->nilai,
            ]
        ], 200);
    }

    public function setMateriSelesaiAll(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'rps_detail_id' => 'required|exists:rps_details,id',
            "skala_pemahaman" => 'required|integer|min:1|max:4',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }
        $materiIds = Materi::where('rps_detail_id', $request->rps_detail_id)
            ->where('status', 'verified')
            ->pluck('id');

        foreach ($materiIds as $materiId) {
            MateriMahasiswa::updateOrCreate(
                ['materi_id' => $materiId, 'user_id' => $user->id],
                ['skala_pemahaman' => 4]
            );
        }

        return response()->json(['status' => 'success', 'message' => 'Semua materi ditandai selesai'], 200);
    }

    public function getForumDiskusi(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }
        $messages = DiscussionMessage::with(['sender.roles', 'materi:id,title'])
            ->where('materi_id', $request->query('id'))
            ->orderBy('created_at', 'asc')
            ->get();

        $formatted = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'name' => $msg->sender->name,
                'photo' => $msg->sender->profile_photo ? url("storage/$msg->sender->profile_photo") : url("storage/image/profile-photo/blank.png"),
                'role' => $msg->sender->roles->first()->name ?? '-',
                'content' => $msg->message,
                'created_at' => $msg->created_at->diffForHumans(),
            ];
        })->toArray();
        $materi = Materi::with('rpsDetail:id,close_forum')->find($request->query('id'));
        $formatted['materi_title'] = $materi->title ?? null;
        $formatted['is_closed'] = $materi->rpsDetail->close_forum;
        return response()->json(['status' => 'success', 'data' => array_merge($formatted, ['author_id' => $user->id])], 200);
    }

    public function sendForumDiskusi(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'materi_id' => 'required|exists:materis,id',
            'message' => 'required|string|max:1000',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        $result = DiscussionMessage::create([
            'sender_id' => $user->id,
            'materi_id' => $request->materi_id,
            'message' => $request->message,
        ]);

        if (!$result) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim pesan'], 500);
        }

        return response()->json(['status' => 'success', 'message' => 'Pesan berhasil dikirim'], 200);
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
