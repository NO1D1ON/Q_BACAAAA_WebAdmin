<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Menambahkan kolom 'title' setelah kolom 'category_id'
            $table->string('title')->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Perintah untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('title');
        });
    }
};