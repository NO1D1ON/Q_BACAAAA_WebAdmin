<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'saldo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Mendefinisikan relasi ke tabel 'transactions'
     * Seorang User bisa memiliki banyak Transaction
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    /**
     * Mendefinisikan relasi ke tabel 'top_ups'
     * Seorang User bisa memiliki banyak TopUp
     */
    public function topUps()
    {
        return $this->hasMany(TopUp::class);
    }

    /**
     * Mendefinisikan relasi 'favorites' (many-to-many dengan books)
     * withTimestamps akan otomatis mengelola kolom 'waktu_ditambahkan'
     */
    public function favorites()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'book_id')->withPivot('waktu_ditambahkan');
    }

    /**
     * Mendefinisikan relasi buku yang dibeli (many-to-many dengan books)
     * Pivot table-nya adalah 'book_user'
     */
    public function purchasedBooks()
    {
        return $this->belongsToMany(Book::class, 'book_user', 'user_id', 'book_id')->withPivot('waktu_beli');
    }
}