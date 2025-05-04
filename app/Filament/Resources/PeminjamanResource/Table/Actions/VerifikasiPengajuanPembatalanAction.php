<?php
namespace App\Filament\Resources\PeminjamanResource\Tables\Actions;

use App\Models\Barang;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Gate;

class VerifikasiPengajuanPembatalanAction
{
    public static function make(): Action
    {
        return Action::make('verifikasi_pengajuan_pembatalan')
            ->color('success')
            ->hidden(fn($record) => !$record || $record->status_peminjaman !== 'menunggu_pembatalan' || !Gate::allows('verifikasi_pembatalan_peminjaman'))
            ->label('Setuju Pembatalan')
            ->requiresConfirmation()
            ->action(function ($record) {
                 $record->load('detailPeminjaman');

                 $record->update([
                     'status_peminjaman' => 'dibatalkan',
                 ]);
                 foreach ($record->detailPeminjaman as $detail) {
                     $barang = $detail->barang;

                     if($barang){
                         $barang->stok_bagus += $detail->jumlah_masih_bagus;
                         $barang->stok_rusak_ringan += $detail->jumlah_rusak_ringan;
                         $barang->stock = $barang->stok_bagus + $barang->stok_rusak_ringan;
                         $barang->save();
                     }

                     Notification::make()
                         ->title('Pengajuan Dibatalkan')
                         ->success()
                         ->send();

                 }
            });
    }
}
