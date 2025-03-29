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
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status_peminjaman',
        'keterangan',
        'surat_peminjaman',
        'foto_pengembalian',
        'tanggal_dikembalikan',
        'keterangan_dikembalikan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    

    public function detailPeminjaman(){
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    //add observer
    protected static function booted()
    {
        static::updating(function ($peminjaman) {
            if ($peminjaman->isDirty('surat_peminjaman')) {
                Storage::disk('public')->delete($peminjaman->getOriginal('surat_peminjaman'));
            }
        });
        
        //add delete event
        static::deleted(function ($peminjaman) {
            //delete file from disk
            Storage::disk('public')->delete($peminjaman->surat_peminjaman);
        });
    }

    
}
