<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TransactionResource; // Akan kita buat di langkah 3

class TransactionController extends Controller
{
    /**
     * Mengambil riwayat transaksi untuk pengguna yang sedang login.
     */
    public function history(Request $request)
    {
        $user = Auth::user();

        // Ambil transaksi, urutkan dari yang terbaru, dan paginasi
        $transactions = $user->transactions()
                              ->latest() // sama dengan ->orderBy('created_at', 'desc')
                              ->paginate(20); // Ambil 20 data per halaman

        // Kembalikan data menggunakan API Resource untuk format yang bersih
        return TransactionResource::collection($transactions);
    }
}