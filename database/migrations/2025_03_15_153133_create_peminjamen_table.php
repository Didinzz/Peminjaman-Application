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
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status_peminjaman', ['diajukan', 'disetujui', 'ditolak', 'dikembalikan'])->default('diajukan');
            $table->text('keterangan')->nullable();
            $table->string('surat_peminjaman');
            $table->string('foto_pegembalian')->nullable();
            $table->date('tanggal_dikembalikan')->nullable();
            $table->string('ketarangan_ditolak')->nullable();
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
