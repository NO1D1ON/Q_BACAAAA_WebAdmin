<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Memproses pembelian sebuah buku oleh pengguna yang terautentikasi.
     */
    public function buyBook(Request $request, Book $book)
    {
        $user = Auth::user();

        // 1. Periksa apakah pengguna sudah memiliki buku ini
        if ($user->purchasedBooks()->where('book_id', $book->id)->exists()) {
            return response()->json(['message' => 'Anda sudah memiliki buku ini.'], 409); // 409 Conflict
        }

        // --- PERBAIKAN FINAL: Lakukan casting eksplisit ke float saat membandingkan ---
        // Ini memastikan PHP membandingkan nilai sebagai angka, bukan teks.
        if ((float) $user->saldo < (float) $book->harga) {
            return response()->json([
                'message' => 'Saldo Anda tidak mencukupi.',
                'saldo_user' => (float) $user->saldo,
                'harga_buku' => (float) $book->harga
            ], 402); // 402 Payment Required
        }

        // 3. Gunakan Transaksi Database untuk memastikan semua operasi berhasil
        try {
            DB::transaction(function () use ($user, $book) {
                // Kurangi saldo pengguna
                $user->decrement('saldo', $book->harga);

                // Buat catatan transaksi
                Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => 'BOOK-'.time().'-'.$book->id, // Contoh Order ID unik
                    'harga_total' => $book->harga,
                    'status_pembayaran' => 'success',
                    'waktu_transaksi' => now(),
                ]);

                // Berikan akses buku kepada pengguna (tambahkan ke tabel pivot)
                $user->purchasedBooks()->attach($book->id);
            });
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error server
            return response()->json(['message' => 'Terjadi kesalahan saat memproses transaksi.', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Pembelian buku berhasil!', 'book_title' => $book->title]);
    }
}
