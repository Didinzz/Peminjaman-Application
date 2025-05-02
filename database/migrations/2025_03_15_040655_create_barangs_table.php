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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->integer('stock');
            $table->integer('stok_bagus')->default(0)->after('stock');
            $table->integer('stok_rusak_ringan')->default(0);
            $table->integer('stok_rusak_berat')->default(0);
            $table->string('foto');
            $table->enum('kategori_barang', ['Elektronik', 'Non-Elektronik']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
