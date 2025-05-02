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
        Schema::create('detail_peminjamen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamen', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('stok_tersedia');
            $table->integer('jumlah_pinjaman');
            $table->integer('jumlah_masih_bagus')->nullable()->after('jumlah_pinjaman');
            $table->integer('jumlah_rusak_ringan')->nullable()->after('jumlah_masih_bagus');
            $table->integer('jumlah_rusak_berat')->nullable()->after('jumlah_rusak_ringan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamen');
    }
};
