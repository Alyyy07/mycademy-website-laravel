<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\VerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
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

        if ($user->hasRole('siswa')) {
            return new UserResource($user);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak memiliki akses'
        ], 403);
    }

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

    public function logout(User $user)
    {
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }
        $user->tokens()->delete();

        return response()->json(['status' => 'success', 'message' => 'Berhasil logout'], 200);
    }
}
