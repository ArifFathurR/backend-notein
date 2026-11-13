<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login User
     */
    public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    $token = $user->createToken('mobile-app')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'data' => [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ],
    ], 200);
}

    public function register (Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        User::create($data);

        return response()->json([
            'message' => "Berhasil melakukan register",
            'data' => $data,
        ],200);
    }

    /**
     * Logout User
     */
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ], 200);
    }

    /**
     * Get Authenticated User
     */
    public function me(Request $request)
    {
        return response()->json([
            'data' => [
                'user' => $request->user(),
            ],
        ], 200);
    }
}