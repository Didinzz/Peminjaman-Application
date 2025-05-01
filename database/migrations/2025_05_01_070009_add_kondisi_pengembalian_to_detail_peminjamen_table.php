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
        Schema::table('detail_peminjamen', function (Blueprint $table) {
            $table->integer('jumlah_masih_bagus')->nullable()->after('jumlah_pinjaman');
            $table->integer('jumlah_rusak_ringan')->nullable()->after('jumlah_masih_bagus');
            $table->integer('jumlah_rusak_berat')->nullable()->after('jumlah_rusak_ringan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_peminjamen', function (Blueprint $table) {
            //
        });
    }
};
