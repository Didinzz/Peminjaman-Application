<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'peminjamen';
    protected $fillable = [
        'nama_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'barang_id',
        'status_peminjaman',
        'jumlah_pinjaman',
        'bukti_peminjaman',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    //add observer
    protected static function booted()
    {
        static::updating(function ($peminjaman) {
            if ($peminjaman->isDirty('bukti_peminjaman')) {
                Storage::disk('public')->delete($peminjaman->getOriginal('bukti_peminjaman'));
            }
        });
        
        //add delete event
        static::deleted(function ($peminjaman) {
            //delete file from disk
            Storage::disk('public')->delete($peminjaman->bukti_peminjaman);
        });
    }
}
