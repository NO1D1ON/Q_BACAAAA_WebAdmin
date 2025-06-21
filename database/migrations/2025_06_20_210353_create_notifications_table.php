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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // [PENTING] Foreign key ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // misal: 'info', 'transaksi', 'promo'
            $table->boolean('is_read')->default(false); // Defaultnya belum dibaca
            $table->timestamps(); // otomatis membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};