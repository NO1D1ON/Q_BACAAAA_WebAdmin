<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Definisikan kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
    ];
}