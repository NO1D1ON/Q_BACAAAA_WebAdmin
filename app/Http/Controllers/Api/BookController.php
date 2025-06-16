<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // Fungsi untuk mengambil semua buku
    public function index()
    {
        // 'with' digunakan agar data kategori ikut terambil bersama buku
        $books = Book::with('category')->latest()->get();
        return response()->json($books);
    }

    // Fungsi untuk mengambil 1 buku spesifik berdasarkan ID
    public function show($id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($book);
    }
}