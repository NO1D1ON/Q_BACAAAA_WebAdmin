<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\JsonResponse; // [PERBAIKAN] Tambahkan import untuk JsonResponse

class ContentController extends Controller
{
    /**
     * Mengambil semua kategori dengan format JSON yang konsisten.
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::select('id', 'name', 'image_path')->get();
        // [PERBAIKAN] Selalu bungkus respons dalam format standar.
        return response()->json(['data' => $categories]);
    }

    /**
     * Mengambil buku populer (berdasarkan rating tertinggi).
     */
    public function getPopularBooks(): JsonResponse
    {
        $books = Book::orderBy('rating', 'desc')->take(5)->get();
        return response()->json(['data' => $books]);
    }
    
    /**
     * [PERBAIKAN PERFORMA KRITIS]
     * Mengambil buku rekomendasi dengan cara yang jauh lebih cepat.
     */
    public function getRecommendedBooks(): JsonResponse
    {
        // Hapus penggunaan `inRandomOrder()` yang sangat lambat.
        // Opsi 1: Ambil buku terbaru sebagai "rekomendasi" (Sangat Cepat)
        // $books = Book::latest()->take(5)->get();

        // Opsi 2: Jika tetap ingin acak dengan cara yang cepat
        
        $bookIds = Book::pluck('id')->toArray(); // Ambil semua ID
        shuffle($bookIds); // Acak urutan ID di level PHP (bukan database)
        $randomIds = array_slice($bookIds, 0, 5); // Ambil 5 ID pertama
        $books = Book::whereIn('id', $randomIds)->get(); // Ambil buku berdasarkan 5 ID acak
        

        return response()->json(['data' => $books]);
    }

    /**
     * Mengambil buku terbaru.
     */
    public function getNewBooks(): JsonResponse
    {
        $books = Book::latest()->take(5)->get();
        return response()->json(['data' => $books]);
    }

    /**
     * Mengambil buku yang sedang tren.
     */
    public function getTrendingBooks(): JsonResponse
    {
        // Daripada memanggil fungsi lain, kita duplikasi logikanya agar jelas
        // dan konsisten mengembalikan JsonResponse.
        $books = Book::orderBy('rating', 'desc')->take(5)->get();
        return response()->json(['data' => $books]);
    }

    /**
     * Menampilkan detail satu buku spesifik.
     */
    public function show(Book $book): JsonResponse
    {
        // [PERBAIKAN] Bungkus respons dalam 'data' agar konsisten.
        return response()->json(['data' => $book]);
    }
}