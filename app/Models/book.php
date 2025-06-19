<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'category_id',
        'penulis',
        'deskripsi',
        'cover',
        'harga',
        'rating',
        'file_path',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'rating' => 'float',
    ];

    /**
     * Mendefinisikan relasi ke tabel 'categories'
     * Satu Book hanya dimiliki oleh satu Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendefinisikan relasi ke users yang membeli buku ini
     */
    public function buyers()
    {
        return $this->belongsToMany(User::class, 'book_user', 'book_id', 'user_id');
    }

    /**
     * Mendefinisikan relasi ke users yang memfavoritkan buku ini
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'book_id', 'user_id');
    }
}