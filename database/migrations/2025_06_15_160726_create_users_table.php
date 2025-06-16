<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id (pk)
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->decimal('saldo', 15, 2)->default(0);
            $table->timestamps(); // waktu_pembuatan_akun & waktu_edit_akun
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
