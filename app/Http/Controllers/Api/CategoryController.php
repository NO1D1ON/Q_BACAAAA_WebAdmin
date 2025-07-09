<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Mengirimkan daftar semua kategori.
     * Endpoint ini akan dipanggil oleh halaman utama Flutter.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::orderBy('name', 'asc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Daftar kategori berhasil diambil.',
                'data'    => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mengirimkan detail satu kategori beserta semua buku di dalamnya.
     * Endpoint ini dipanggil saat user memilih salah satu kategori.
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug): JsonResponse
    {
        try {
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
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
            ], 500);
        }
    }
}