<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Mengambil daftar buku yang sudah dibeli oleh pengguna.
     */
    public function purchased(Request $request)
    {
        $purchasedBooks = $request->user()->purchasedBooks()->latest()->get();
        return response()->json(['data' => $purchasedBooks]);
    }

    /**
     * Mengambil daftar buku yang sudah difavoritkan oleh pengguna.
     */
    public function favorites(Request $request)
    {
        $favoriteBooks = $request->user()->favorites()->latest()->get();
        return response()->json(['data' => $favoriteBooks]);
    }
}