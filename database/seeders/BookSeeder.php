<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'category_id' => 1, // Filsafat
            'penulis' => 'Henry Manampiring',
            'deskripsi' => 'Sebuah buku pengantar filsafat Stoa.',
            'cover' => 'covers/filosofi-teras.jpg',
            'harga' => 80000,
            'rating' => 4.8,
            'file_path' => 'ebooks/filosofi-teras.epub'
        ]);

        Book::create([
            'category_id' => 3, // Pengembangan Diri
            'penulis' => 'James Clear',
            'deskripsi' => 'Cara mudah membangun kebiasaan baik.',
            'cover' => 'covers/atomic-habits.jpg',
            'harga' => 95000,
            'rating' => 4.9,
            'file_path' => 'ebooks/atomic-habits.epub'
        ]);
    }
}