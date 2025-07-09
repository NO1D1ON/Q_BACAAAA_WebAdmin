<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    /**
     * Mengambil semua kategori.
     */
    public function getCategories(): JsonResponse
    {
        try {
            $categories = Category::select('id', 'name', 'slug', 'image_path')->get();
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diambil.',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil kategori.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil buku populer (berdasarkan rating tertinggi).
     */
    public function getPopularBooks(): JsonResponse
    {
        try {
            $books = Book::orderBy('rating', 'desc')->take(10)->get();
            return response()->json([
                'success' => true,
                'message' => 'Buku populer berhasil diambil.',
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil buku populer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Mengambil buku rekomendasi secara acak dengan performa cepat.
     */
    public function getRecommendedBooks(): JsonResponse
    {
        try {
            // Opsi ini jauh lebih cepat daripada `inRandomOrder()` pada tabel besar.
            $bookIds = Book::pluck('id')->toArray();
            shuffle($bookIds);
            $randomIds = array_slice($bookIds, 0, 10);
            $books = Book::whereIn('id', $randomIds)->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Buku rekomendasi berhasil diambil.',
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil buku rekomendasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil buku terbaru.
     */
    public function getNewBooks(): JsonResponse
    {
        try {
            $books = Book::latest()->take(10)->get();
            return response()->json([
                'success' => true,
                'message' => 'Buku terbaru berhasil diambil.',
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil buku terbaru.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil buku yang sedang tren (logika sama dengan populer).
     */
    public function getTrendingBooks(): JsonResponse
    {
        try {
            $books = Book::orderBy('rating', 'desc')->take(10)->get();
            return response()->json([
                'success' => true,
                'message' => 'Buku trending berhasil diambil.',
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil buku trending.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mencari buku berdasarkan judul, penulis, atau kategori.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->input('q');

            if (!$query) {
                return response()->json([
                    'success' => true,
                    'message' => 'Query pencarian kosong.',
                    'data' => []
                ]);
            }

            $titleMatch = Book::where('title', 'LIKE', $query)->first();
            $authorMatches = collect();
            $categoryMatches = collect();
            $matchType = 'none';

            if ($titleMatch) {
                $matchType = 'title';
            } else {
                $authorMatches = Book::where('penulis', 'LIKE', '%' . $query . '%')->limit(5)->get();
                if ($authorMatches->isNotEmpty()) {
                    $matchType = 'author';
                } else {
                    $category = Category::where('name', 'LIKE', '%' . $query . '%')->first();
                    if ($category) {
                        $categoryMatches = $category->books()->limit(5)->get();
                        if ($categoryMatches->isNotEmpty()) {
                            $matchType = 'category';
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Hasil pencarian untuk "' . $query . '".',
                'data' => [
                    'query' => $query,
                    'match_type' => $matchType,
                    'title_match' => $titleMatch,
                    'author_matches' => $authorMatches,
                    'category_matches' => $categoryMatches,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan pencarian.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail satu buku spesifik, dengan status favorit & pembelian.
     */
    public function show(Request $request, Book $book): JsonResponse
    {
        try {
            $book->is_favorited_by_user = false;
            $book->is_purchased_by_user = false;

            if ($user = $request->user('sanctum')) {
                $book->is_favorited_by_user = $user->favorites()->where('book_id', $book->id)->exists();
                $book->is_purchased_by_user = $user->purchasedBooks()->where('book_id', $book->id)->exists();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Detail buku berhasil diambil.',
                'data' => $book
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail buku.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * [PERBAIKAN] Mengambil semua buku berdasarkan kategori.
     */
    public function getBooksByCategory(Category $category): JsonResponse
    {
        try {
            // Laravel otomatis menemukan kategori via Route Model Binding.
            // Kita tinggal memuat relasi 'books'.
            $books = $category->books;

            return response()->json([
                'success' => true,
                'message' => 'Buku untuk kategori "' . $category->name . '" berhasil diambil.',
                'data' => $books
            ]);
        } catch (\Exception $e) {
            // Catch block ini akan berjalan jika $category tidak ditemukan (error 404)
            // atau jika ada masalah lain.
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil buku berdasarkan kategori.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
