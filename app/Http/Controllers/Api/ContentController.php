<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Mengambil semua kategori.
     */
    public function getCategories()
    {
        return Category::select('id', 'name')->get();
    }

    /**
     * Mengambil buku populer (contoh: berdasarkan rating tertinggi).
     */
    public function getPopularBooks()
    {
        return Book::orderBy('rating', 'desc')->take(5)->get();
    }
    
    /**
     * Mengambil buku rekomendasi (contoh: acak).
     */
    public function getRecommendedBooks()
    {
        return Book::inRandomOrder()->take(5)->get();
    }

    /**
     * Mengambil buku terbaru.
     */
    public function getNewBooks()
    {
        return Book::latest()->take(5)->get();
    }

    /**
     * Mengambil buku yang sedang tren (contoh: kita samakan dengan populer).
     */
    public function getTrendingBooks()
    {
        return $this->getPopularBooks();
    }

    /**
     * ---- FUNGSI BARU YANG DITAMBAHKAN ----
     * Menampilkan detail satu buku spesifik.
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Book $book)
    {
        // Berkat Route Model Binding, Laravel otomatis mencari buku berdasarkan ID.
        // Jika tidak ditemukan, ia otomatis akan menghasilkan 404.
        return response()->json($book);
    }
}
