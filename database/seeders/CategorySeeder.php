<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Filsafat', 'slug' => 'filsafat']);
        Category::create(['name' => 'Sains Fiksi', 'slug' => 'sains-fiksi']);
        Category::create(['name' => 'Pengembangan Diri', 'slug' => 'pengembangan-diri']);
    }
}