<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification; // Pastikan import ini ada

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // [PENGAMAN TAMBAHAN] Cek jika user tidak ditemukan
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        // Ambil notifikasi berdasarkan ID user yang sedang login
        $notifications = Notification::where('user_id', $user->id)
                                    ->latest()
                                    ->get();
        
        return response()->json([
            'data' => $notifications
        ]);
    }
}