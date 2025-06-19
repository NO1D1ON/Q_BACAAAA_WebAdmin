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
        'order_id',
        'harga_total',
        'status_pembayaran',
        'waktu_transaksi',
    ];

    /**
     * Mendefinisikan relasi ke model User.
     * Sebuah Transaction dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}