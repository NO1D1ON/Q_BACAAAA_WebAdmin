<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- [1] TAMBAHKAN: Import Storage
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * [2] FUNGSI STORE DIPERBAIKI
     * Menangani penyimpanan kategori baru beserta gambar.
     */
    public function store(Request $request)
    {
        // Validasi input, termasuk file gambar
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        $categoryData = [
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
        ];

        // Cek jika ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Simpan file ke storage/app/public/category_images dan dapatkan path-nya
            $categoryData['image_path'] = $request->file('image')->store('category_images', 'public');
        }

        // Buat kategori baru dengan data yang sudah disiapkan
        Category::create($categoryData);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * [3] FUNGSI UPDATE DIPERBAIKI
     * Menangani pembaruan data kategori, termasuk mengganti gambar.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $categoryData = [
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
        ];

        // Cek jika ada file gambar baru yang diunggah untuk menggantikan yang lama
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            // Simpan gambar baru dan perbarui path-nya
            $categoryData['image_path'] = $request->file('image')->store('category_images', 'public');
        }

        $category->update($categoryData);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * [4] FUNGSI DESTROY DIPERBAIKI
     * Menghapus data kategori dan file gambar terkait.
     */
    public function destroy(Category $category)
    {
        // Hapus file gambar dari storage jika ada
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        
        // Hapus record kategori dari database
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}