<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'book_id', // Pastikan kolom ini ada di migrasi Anda
        'order_id',
        'harga_total',
        'status_pembayaran',
        'waktu_transaksi',
    ];

    /**
     * Mendefinisikan relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * [PERBAIKAN UTAMA] Tambahkan fungsi relasi ini.
     * Mendefinisikan relasi ke model Book.
     * Satu Transaksi pembelian hanya untuk satu Buku.
     */
    public function book()
    {
        // Asumsi di tabel 'transactions' ada kolom 'book_id'
        return $this->belongsTo(Book::class, 'book_id');
    }
}
