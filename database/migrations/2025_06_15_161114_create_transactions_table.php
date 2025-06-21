<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // [PERBAIKAN] Tambahkan kolom foreign key untuk buku
            // Dibuat nullable() karena transaksi Top Up tidak memiliki book_id.
            $table->foreignId('book_id')->nullable()->constrained('books')->onDelete('set null');

            $table->string('order_id')->unique();
            $table->decimal('harga_total', 15, 2);
            $table->string('status_pembayaran')->default('pending');
            $table->timestamp('waktu_transaksi')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
