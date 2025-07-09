<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TopUp;

class TransactionController extends Controller
{
    /**
     * Mengambil riwayat transaksi untuk pengguna yang sedang login.
     * Menggabungkan data pembelian dan top up.
     */
    public function history(Request $request)
    {
        $user = $request->user();

        // 1. Ambil data pembelian buku
        $purchases = Transaction::with('book:id,title') // Ambil judul buku
            ->where('user_id', $user->id)
            ->whereNotNull('book_id') // Hanya ambil transaksi pembelian
            ->get()
            ->map(function ($transaction) {
                return [
                    'type' => 'Pembelian',
                    'description' => $transaction->book->title ?? 'Buku Dihapus',
                    'display_date' => $transaction->waktu_transaksi,
                    // Harga selalu negatif untuk pembelian
                    'display_amount' => -$transaction->harga_total,
                ];
            });

        // 2. Ambil data top up yang sukses
        $topUps = TopUp::where('user_id', $user->id)
            ->where('status', 'success')
            ->get()
            ->map(function ($topup) {
                return [
                    'type' => 'Top Up',
                    'description' => 'Isi Ulang Saldo',
                    'display_date' => $topup->waktu_permintaan_topup,
                     // Nominal selalu positif untuk top up
                    'display_amount' => $topup->nominal,
                ];
            });

        // 3. Gabungkan dan urutkan
        $allTransactions = $purchases->merge($topUps)->sortByDesc('display_date');

        // 4. Kembalikan sebagai JSON
        return response()->json([
            'data' => $allTransactions->values()->all() // values()->all() untuk mereset key array
        ]);
    }
}