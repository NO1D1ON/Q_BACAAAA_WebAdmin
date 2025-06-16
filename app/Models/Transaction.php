<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Karena nama kolom waktu transaksi tidak standar (bukan created_at/updated_at)
    // kita matikan fitur timestamp otomatis dari Eloquent.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'harga_total',
        'status_pembayaran',
        'waktu_transaksi',
    ];

    /**
     * Mendefinisikan relasi ke tabel 'users'
     * Satu Transaction hanya dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}