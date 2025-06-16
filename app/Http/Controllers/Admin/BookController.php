<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk mengelola file

class BookController extends Controller
{
    public function index()
    {
        // Menggunakan with('category') untuk mengambil data relasi (eager loading)
        $books = Book::with('category')->latest()->get();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        // Mengirim data semua kategori ke view untuk ditampilkan di dropdown
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'required|file|mimes:pdf,epub|max:10240',
        ]);

        // Proses upload file cover jika ada
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Proses upload file e-book
        $validated['file_path'] = $request->file('file_path')->store('ebooks', 'public');

        // Ganti nama kolom sesuai migrasi Anda
        $validated['penulis'] = $validated['author'];
        $validated['deskripsi'] = $validated['description'];
        $validated['harga'] = $validated['price'];

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Method edit, update, dan destroy akan sangat mirip, bisa Anda kembangkan
    // ...
}