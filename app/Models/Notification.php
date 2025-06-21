<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * [PERBAIKAN UTAMA] Tambahkan properti $fillable.
     * Ini adalah "izin" yang memberitahu Laravel bahwa kolom-kolom
     * berikut aman untuk diisi secara massal menggunakan metode ::create().
     * Tanpa ini, tidak ada notifikasi yang akan pernah dibuat.
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
    ];

    /**
     * The attributes that should be cast to native types.
     * Ini membantu memastikan 'is_read' selalu diperlakukan sebagai boolean (true/false).
     *
     * @var array
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Mendefinisikan relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
