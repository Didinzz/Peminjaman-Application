<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'barang_id', 'id');
    }

    protected static function booted()
    {
        static::updating(function ($barang) {
            if ($barang->isDirty('foto')) {
                Storage::disk('public')->delete($barang->getOriginal('foto'));
            }
        });

        //add delete event
        static::deleted(function ($barang) {
            //delete file from disk
            Storage::disk('public')->delete($barang->foto);
        });
    }
}
