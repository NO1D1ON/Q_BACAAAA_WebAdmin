<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
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
    // public function show(Book $book): JsonResponse
    // {
    //     // [PERBAIKAN] Bungkus respons dalam 'data' agar konsisten.
    //     return response()->json(['data' => $book]);
    // }

    public function search(Request $request)
    {
        // 1. Ambil kata kunci dari URL (misal: /api/search?q=bumi)
        $query = $request->input('q');

        // Jika tidak ada kata kunci, kembalikan hasil kosong
        if (!$query) {
            return response()->json([
                'data' => [
                    'match_type' => 'none',
                    'title_match' => null,
                    'author_matches' => [],
                    'category_matches' => [],
                ]
            ]);
        }

        // 2. Inisialisasi variabel hasil
        $titleMatch = null;
        $authorMatches = collect(); // Membuat koleksi kosong
        $categoryMatches = collect();
        $matchType = 'none';

        // 3. Prioritas 1: Cari kecocokan judul buku yang sama persis
        $titleMatch = Book::where('title', 'LIKE', $query)->first();

        if ($titleMatch) {
            $matchType = 'title';
        } else {
            // 4. Jika judul tidak cocok, cari berdasarkan penulis (maksimal 5)
            $authorMatches = Book::where('penulis', 'LIKE', '%' . $query . '%')
                                ->limit(5)
                                ->get();
            
            if ($authorMatches->isNotEmpty()) {
                $matchType = 'author';
            } else {
                // 5. Jika penulis tidak cocok, cari berdasarkan nama kategori
                $category = Category::where('name', 'LIKE', '%' . $query . '%')->first();
                if ($category) {
                    $categoryMatches = Book::where('category_id', $category->id)
                                        ->limit(5)
                                        ->get();
                    
                    if ($categoryMatches->isNotEmpty()) {
                        $matchType = 'category';
                    }
                }
            }
        }

        // 6. Kembalikan hasil dalam format JSON yang sudah kita desain
        return response()->json([
            'data' => [
                'query' => $query,
                'match_type' => $matchType,
                'title_match' => $titleMatch,
                'author_matches' => $authorMatches,
                'category_matches' => $categoryMatches,
            ]
        ]);
    }

    public function show(Request $request, Book $book)
    {
        // 1. Set nilai default, untuk kasus jika pengguna tidak login
        $book->is_favorited_by_user = false;
        $book->is_purchased_by_user = false;

        // 2. Cek apakah ada user yang sedang login (berdasarkan token sanctum)
        if ($user = $request->user('sanctum')) {
            // 3. Cek apakah buku ini ada di dalam daftar favorit user tersebut
            $book->is_favorited_by_user = $user->favorites()->where('book_id', $book->id)->exists();

            // 4. Cek apakah buku ini ada di dalam daftar koleksi (pembelian) user
            $book->is_purchased_by_user = $user->purchasedBooks()->where('book_id', $book->id)->exists();
        }
        // dd($book->toArray());
        // 5. Kembalikan objek buku yang sudah dimodifikasi, dan bungkus dalam 'data'
        return response()->json(['data' => $book]);
    }

    public function getBooksByCategory(Category $category)
    {

        // Berkat Route Model Binding, Laravel otomatis mencari kategori berdasarkan ID.
        // Kita lalu mengambil semua buku yang terhubung dengan kategori tersebut.
        $books = $category->books()->get();

        return response()->json(['data' => $books]);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}