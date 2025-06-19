<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Schema; // <-- PERBAIKAN: Import Schema

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // --- PERBAIKAN: Bungkus proses truncate dengan disable/enable foreign key checks ---
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();
        // --- AKHIR PERBAIKAN ---

        $categories = [
            ['name' => 'Novel', 'slug' => 'novel'],
            ['name' => 'Sains', 'slug' => 'sains'],
            ['name' => 'Filsafat', 'slug' => 'filsafat'],
            ['name' => 'Pengembangan Diri', 'slug' => 'pengembangan-diri'],
            ['name' => 'Sejarah', 'slug' => 'sejarah'],
            ['name' => 'Biografi', 'slug' => 'biografi'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}