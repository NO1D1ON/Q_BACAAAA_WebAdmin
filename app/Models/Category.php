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
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'image_path',
    ];

    /**
     * Mendefinisikan relasi ke tabel 'books'
     * Satu Category bisa memiliki banyak Book
     */
    public function books()
    {
        // Argumen kedua ('category_id') adalah nama foreign key di tabel 'books'.
        // Argumen ketiga ('id') adalah nama primary key di tabel 'categories'.
        // Ini adalah pengaturan default, tapi menuliskannya secara eksplisit lebih aman.
        return $this->hasMany(Book::class, 'category_id', 'id');
    }

}