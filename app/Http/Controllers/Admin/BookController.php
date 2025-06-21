<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category')->latest()->get();
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'required|file|mimes:pdf,epub|max:10240',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $bookData = [
            'title' => $validatedData['title'],
            'penulis' => $validatedData['author'],
            'deskripsi' => $validatedData['description'],
            'harga' => $validatedData['price'],
            'category_id' => $validatedData['category_id'],
            'rating' => $validatedData['rating'] ?? 0,
        ];

        if ($request->hasFile('cover')) {
            $bookData['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('file_path')) {
            $bookData['file_path'] = $request->file('file_path')->store('ebooks', 'public');
        }

        Book::create($bookData);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * --- FUNGSI BARU UNTUK MENAMPILKAN HALAMAN EDIT ---
     * Display the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        // Mengirim data buku yang akan diedit dan daftar kategori ke view
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * --- FUNGSI BARU UNTUK MEMPROSES UPDATE ---
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'nullable|file|mimes:pdf,epub|max:10240', // Dibuat nullable, mungkin admin hanya ingin ganti data teks
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $bookData = [
            'title' => $validatedData['title'],
            'penulis' => $validatedData['author'],
            'deskripsi' => $validatedData['description'],
            'harga' => $validatedData['price'],
            'category_id' => $validatedData['category_id'],
            'rating' => $validatedData['rating'] ?? $book->rating,
        ];
        
        // Cek jika ada file cover baru yang diupload
        if ($request->hasFile('cover')) {
            // Hapus file cover lama jika ada
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            // Simpan file baru
            $bookData['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Cek jika ada file e-book baru yang diupload
        if ($request->hasFile('file_path')) {
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $bookData['file_path'] = $request->file('file_path')->store('ebooks', 'public');
        }

        $book->update($bookData);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * --- FUNGSI BARU UNTUK MENGHAPUS BUKU ---
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Hapus file dari storage sebelum menghapus record dari database
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
