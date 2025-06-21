<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- PASTIKAN IMPORT INI ADA
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
        'is_active'
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
        'saldo' => 'decimal:2'
    ];

    /**
     * --- PERBAIKAN UTAMA: Tambahkan ini ke model Anda ---
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['first_name'];

    /**
     * --- PERBAIKAN UTAMA: Buat accessor untuk 'first_name' ---
     * Get the user's first name.
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => explode(' ', $attributes['nama'])[0],
        );
    }
    
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
        return $this->belongsToMany(Book::class, 'book_user', 'user_id', 'book_id');
    }
}