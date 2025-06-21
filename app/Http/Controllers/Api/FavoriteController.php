<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book; // <-- Import model Book

class FavoriteController extends Controller
{
    /**
     * Menambah atau menghapus buku dari daftar favorit pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request, Book $book)
    {
        // 'toggle' adalah fungsi canggih dari Laravel.
        // Ia akan secara otomatis menambah relasi jika belum ada,
        // dan menghapus relasi jika sudah ada. Sangat efisien!
        $user = $request->user();
        $user->favorites()->toggle($book->id);

        return response()->json([
            'message' => 'Status favorit berhasil diubah.'
        ]);
    }
}