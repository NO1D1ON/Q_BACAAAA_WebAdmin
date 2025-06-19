<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Facades\Schema;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Book::truncate();
        Schema::enableForeignKeyConstraints();

        // Data dummy untuk buku
        $books = [
            // PERBAIKAN: Mengganti kunci 'judul' menjadi 'title' agar sesuai dengan migrasi baru
            [
                'title' => 'Bumi', 'penulis' => 'Tere Liye', 'deskripsi' => 'Deskripsi untuk buku Bumi.', 
                'harga' => 99000, 'rating' => 4.8, 'category_id' => 1, 'cover' => 'public/assets/BukuBeli.png', 'file_path' => 'ebooks/placeholder.epub'
            ],
            [
                'title' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'deskripsi' => 'Deskripsi untuk Filosofi Teras.', 
                'harga' => 85000, 'rating' => 4.9, 'category_id' => 3, 'cover' => 'public/assets/BukuBeli.png', 'file_path' => 'ebooks/placeholder.epub'
            ],
            [
                'title' => 'Atomic Habits', 'penulis' => 'James Clear', 'deskripsi' => 'Deskripsi untuk Atomic Habits.', 
                'harga' => 110000, 'rating' => 4.9, 'category_id' => 4, 'cover' => 'public/assets/BukuBeli.png', 'file_path' => 'ebooks/placeholder.epub'
            ],
            [
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia', 'penulis' => 'Yuval Noah Harari', 'deskripsi' => 'Deskripsi untuk Sapiens.', 
                'harga' => 150000, 'rating' => 4.7, 'category_id' => 5, 'cover' => 'public/assets/BukuBeli.png', 'file_path' => 'ebooks/placeholder.epub'
            ],
             [
                'title' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'deskripsi' => 'Deskripsi untuk Laskar Pelangi.', 
                'harga' => 75000, 'rating' => 4.6, 'category_id' => 1, 'cover' => 'public/assets/BukuBeli.png', 'file_path' => 'ebooks/placeholder.epub'
            ],
             [
                'title' => 'Sebuah Seni untuk Bersikap Bodo Amat', 'penulis' => 'Mark Manson', 'deskripsi' => 'Deskripsi untuk buku ini.', 
                'harga' => 90000, 'rating' => 4.5, 'category_id' => 4, 'cover' => 'public/assets/BukuBeli.png', 'file_path' => 'ebooks/placeholder.epub'
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}