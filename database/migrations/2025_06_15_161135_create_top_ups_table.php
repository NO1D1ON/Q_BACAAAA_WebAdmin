<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('top_ups', function (Blueprint $table) {
            $table->id(); // id (pk)
            $table->foreignId('user_id')->constrained();
            $table->decimal('nominal', 15, 2);
            $table->string('status')->default('pending'); // cth: pending, success, failed
            $table->timestamp('waktu_permintaan_topup')->useCurrent();
            $table->timestamp('waktu_validasi_topup')->nullable();
            // $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('top_ups');
    }
};