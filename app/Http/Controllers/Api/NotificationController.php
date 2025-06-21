<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan import Auth

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // [PERBAIKAN UTAMA] Ambil user yang login melalui guard 'sanctum'
        $user = Auth::guard('sanctum')->user();

        // Cek jika tidak ada user yang terotentikasi dengan token yang diberikan
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Jika user ditemukan, ambil notifikasinya
        $notifications = Notification::where('user_id', $user->id)
                                    ->latest() 
                                    ->get();

        return response()->json([
            'data' => $notifications
        ]);
    }
}
