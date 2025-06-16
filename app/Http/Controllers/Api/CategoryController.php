<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Fungsi untuk mengambil semua kategori
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}