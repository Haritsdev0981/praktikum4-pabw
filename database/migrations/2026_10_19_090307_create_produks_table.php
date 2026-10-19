<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100); // Maksimal 100 karakter
            $table->enum('kategori', ['sembako', 'minuman', 'rumah_tangga', 'perawatan_diri']);
            $table->unsignedInteger('harga'); // Unsigned memastikan tidak ada nilai negatif
            $table->unsignedInteger('stok');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};