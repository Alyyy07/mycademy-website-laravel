<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/users', function (Request $request) {
        return UserResource::collection(User::all());
    });

    Route::get('logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
    
        return response()->json(['message' => 'Logged out']);
    });
});

Route::post('login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        $token = $user->createToken('MyCademy')->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
});

Route::post('register', function (Request $request) {
    // Validasi data pengguna
    $request->validate([
        'fullName' => 'required',
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Membuat pengguna baru
    $user = new User();
    $user->name = $request->fullName;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();

    return response()->json(['message' => 'User created'], 201);
});