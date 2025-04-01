<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjamen';
    protected $guarded = [];


    protected static function booted()
    {
        //saat ada data baru dibuat, update stok barang
        static::created(function ($detailPeminjaman) {
            $barang = Barang::find($detailPeminjaman->barang_id);

            if($barang){
                $barang->stock -= $detailPeminjaman->jumlah_pinjaman;
                $detailPeminjaman->stok_tersedia = $barang->stock;
                $detailPeminjaman->save();
                $barang->save();
            }
        });

        // jika data dihapus, kembalikan stok barang
        static::deleted(function ($detailPeminjaman) {
            $barang = Barang::find($detailPeminjaman->barang_id);

            if($barang){
                $barang->stock += $detailPeminjaman->jumlah_pinjaman;
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
