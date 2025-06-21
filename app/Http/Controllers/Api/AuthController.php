<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Biarkan hashing otomatis dari Model User yang bekerja
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Cari pengguna di tabel 'users' berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 3. Periksa apakah pengguna ada DAN passwordnya cocok
        // Ini adalah implementasi manual dari apa yang kita buktikan di investigasi
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Jika pengguna tidak ada ATAU password tidak cocok, kirim error
            return response()->json([
                'message' => 'Email atau Password salah'
            ], 401);
        }

        // 4. Jika berhasil, buat token dan kirim response sukses
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function user(Request $request)
    {
        // [PERBAIKAN] Gunakan Auth::guard('sanctum') untuk konsistensi
        return response()->json([
            'data' => Auth::guard('sanctum')->user()
        ]);
    }

    public function logout(Request $request)
    {
        // Perintah ini akan menghapus token yang digunakan untuk otentikasi,
        // sehingga token tersebut tidak bisa digunakan lagi.
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Email tidak terdaftar.'], 404);
        }

        // Mengirim email reset password menggunakan sistem bawaan Laravel
        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Tautan reset password telah dikirim ke email Anda!']);
        }

        // Jika karena suatu hal gagal
        return response()->json(['message' => 'Gagal mengirim tautan reset password.'], 500);
    }

    public function changePassword(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        // 2. Cek apakah password lama cocok
        if (!Hash::check($request->old_password, $request->user()->password)) {
            return response()->json([
                'message' => 'Password lama Anda tidak cocok.'
            ], 422); // 422: Unprocessable Entity
        }

        // 3. Jika cocok, update dengan password baru
        $request->user()->update([
            'password' => $request->new_password // Model User akan otomatis hash password ini
        ]);

        // 4. Beri respons sukses
        return response()->json([
            'message' => 'Password berhasil diperbarui!'
        ]);
    }
}
