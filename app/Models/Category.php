<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'image_path'];


    /**
     * [PERBAIKAN UTAMA] Pastikan fungsi ini ada dan benar.
     * Mendefinisikan relasi "satu ke banyak" (One to Many).
     * Satu Kategori bisa memiliki banyak Buku.
     */
    public function books()
    {
        // Perintah ini akan mencari semua model Book
        // yang memiliki 'category_id' sama dengan 'id' dari kategori ini.
        return $this->hasMany(Book::class, 'category_id', 'id');
    }
}
