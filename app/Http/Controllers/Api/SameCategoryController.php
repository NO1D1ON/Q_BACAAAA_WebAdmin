<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category; // Pastikan model Category di-import
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Mengirimkan daftar semua kategori.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil semua kategori dari database
            $categories = Category::orderBy('name', 'asc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Daftar kategori berhasil diambil.',
                'data'    => $categories
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * [FUNGSI KUNCI]
     * Mengirimkan detail satu kategori beserta semua buku di dalamnya.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        try {
            // Cari kategori berdasarkan 'slug'
            // dan langsung ambil relasi 'books' dengan 'with()' (Eager Loading)
            $category = Category::with('books')->where('slug', $slug)->firstOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Detail kategori dan buku berhasil diambil.',
                'data'    => $category
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}