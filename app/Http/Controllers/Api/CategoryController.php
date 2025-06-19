<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // ... (fungsi index() dan create() tetap sama) ...
    public function index() { /* ... */ }
    public function create() { /* ... */ }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            // Tambahkan validasi untuk gambar
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $categoryData = [
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
        ];

        // Jika ada file gambar yang di-upload, proses dan simpan path-nya
        if ($request->hasFile('image')) {
            $categoryData['image_path'] = $request->file('image')->store('category_images', 'public');
        }

        Category::create($categoryData);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
    
    // ... (fungsi edit() tetap sama) ...
    public function edit(Category $category) { /* ... */ }

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

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            // Simpan gambar baru
            $categoryData['image_path'] = $request->file('image')->store('category_images', 'public');
        }

        $category->update($categoryData);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Hapus juga gambar dari storage saat kategori dihapus
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}