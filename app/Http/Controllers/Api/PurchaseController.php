<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification; 
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function buyBook(Request $request, Book $book)
    {
        $user = $request->user();

        // ... (Cek saldo dan kepemilikan buku tetap sama)
        if ($user->saldo < $book->harga) {
            return response()->json(['message' => 'Saldo Anda tidak mencukupi.'], 422);
        }
        if ($user->purchasedBooks()->where('book_id', $book->id)->exists()) {
            return response()->json(['message' => 'Anda sudah memiliki buku ini.'], 422);
        }

        DB::transaction(function () use ($user, $book) {
            // 1. Kurangi saldo & tambahkan ke koleksi
            $user->decrement('saldo', $book->harga);
            $user->purchasedBooks()->attach($book->id);

            // 2. Catat ke tabel transactions
            Transaction::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'order_id' => 'BOOK-'.time().'-'.$book->id,
                'harga_total' => $book->harga,
                'status_pembayaran' => 'success',
                'waktu_transaksi' => now(),
            ]);

            // 3. [TAMBAHAN] Buat notifikasi untuk pengguna
            Notification::create([
                'user_id' => $user->id,
                'type' => 'transaksi',
                'title' => 'Pembelian Berhasil',
                'message' => 'Anda telah berhasil membeli buku "' . $book->title . '". Selamat membaca!',
                'is_read' => false,
            ]);
        });

        return response()->json(['message' => 'Pembelian buku berhasil!']);
    }
}
