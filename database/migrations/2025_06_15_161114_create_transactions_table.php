<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // id (pk)
            $table->foreignId('user_id')->constrained();
            $table->string('order_id')->unique();
            $table->decimal('harga_total', 15, 2);
            $table->string('status_pembayaran')->default('pending'); // cth: pending, success, failed
            $table->timestamp('waktu_transaksi')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};