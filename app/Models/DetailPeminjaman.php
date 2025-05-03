<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class DetailPeminjaman extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'detail_peminjamen';
    protected $guarded = [];


    protected static function booted()
    {
        //saat ada data baru dibuat, update stok barang
        static::created(function ($detailPeminjaman) {
            $barang = Barang::find($detailPeminjaman->barang_id);

            if ($barang) {
                $jumlahPinjam =  $detailPeminjaman->jumlah_pinjaman;

                //    mengambil stok barang dari tabel barang
                $stokBagus = $barang->stok_bagus;
                $stokRusakRingan = $barang->stok_rusak_ringan;

                $sisaPinjam = $jumlahPinjam;

                //  kurangi dari stok_bagus terlebih dahulu
                $kurangiBagus = min($sisaPinjam, $stokBagus);
                $barang->stok_bagus -= $kurangiBagus;
                $detailPeminjaman->jumlah_masih_bagus = $kurangiBagus;
                $sisaPinjam -= $kurangiBagus;

                //  kurangi dari stok_rusak_ringan terlebih dahulu
                $kurangiRusakRingan = min($sisaPinjam, $stokRusakRingan);
                $barang->stok_rusak_ringan -= $kurangiRusakRingan;
                $detailPeminjaman->jumlah_rusak_ringan = $kurangiRusakRingan;
                $sisaPinjam -= $kurangiRusakRingan;

                // update stok di tabel barang dan sisa stok di tabel detail_peminjaman
                $detailPeminjaman->stok_tersedia = $barang->stok_bagus + $barang->stok_rusak_ringan;
                $barang->stock = $barang->stok_bagus + $barang->stok_rusak_ringan;
                $detailPeminjaman->save();
                $barang->save();
            }
        });

        // jika data dihapus, kembalikan stok barang
        static::deleted(function ($detailPeminjaman) {
            $barang = Barang::find($detailPeminjaman->barang_id);
            if ($barang) {
                $barang->stok_bagus += $detailPeminjaman->jumlah_masih_bagus;
                $barang->stok_rusak_ringan += $detailPeminjaman->jumlah_rusak_ringan;
                $jumlahPinjam = $detailPeminjaman->jumlah_pinjaman;

              
                $barang->stock = $jumlahPinjam;
                $barang->save();
            }
        });
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id');
    }



    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
