<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            $table->string('foto_pengambilan')->nullable()->after('surat_peminjaman');
            $table->string('nama_petugas_pengambilan')->nullable()->after('foto_pengambilan');
            $table->string('nama_petugas_pengembalian')->nullable()->after('foto_pegembalian');
            $table->text('alasan_pembatalan')->nullable()->after('ketarangan_ditolak');
            $table->enum('status_pengembalian', ['tepat_waktu', 'terlambat'])->nullable()->after('nama_petugas_pengembalian');
        });

        DB::statement("ALTER TABLE peminjamen MODIFY status_peminjamen ENUM('diajukan', 'disetujui', 'ditolak', 'barang_diambil', 'menunggu_pembatalan', 'dibatalkan', 'dikembalikan') DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            //
        });
    }
};
