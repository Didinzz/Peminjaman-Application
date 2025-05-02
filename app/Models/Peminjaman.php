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
    protected $guarded = [];

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
        static::forceDeleted(function ($peminjaman) {
            //delete file from disk
            Storage::disk('public')->delete($peminjaman->surat_peminjaman);
            // delete foto pengambilan
            if ($peminjaman->foto_pengambilan != null) {
                Storage::disk('public')->delete($peminjaman->foto_pengambilan);
            }
            // delete foto pegembalian
            if ($peminjaman->foto_pegembalian != null) {
                Storage::disk('public')->delete($peminjaman->foto_pegembalian);
            }

            
        });
    }

    
}
