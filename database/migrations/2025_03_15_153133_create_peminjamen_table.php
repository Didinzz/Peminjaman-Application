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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->foreignId('barang_id')->constrained('barangs', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status_peminjaman', ['diajukan', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');
            $table->integer('jumlah_pinjaman');
            $table->text('keterangan')->nullable();
            $table->string('bukti_peminjaman');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
