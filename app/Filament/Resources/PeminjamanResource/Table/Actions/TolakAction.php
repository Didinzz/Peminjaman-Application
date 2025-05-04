<?php

namespace App\Filament\Resources\PeminjamanResource\Tables\Actions;

use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TolakAction
{
    public static function make(): Action
    {
        return Action::make('tolak')
            ->label('Tolak')
            ->hidden(fn($record) => !$record || $record->status_peminjaman !== 'diajukan' || !Gate::allows('decide_peminjaman'))
            ->modalHeading('Konfirmasi Tolak Peminjaman')
            ->form([
                Textarea::make('ketarangan_ditolak')
                    ->label('Alasan Penolakan')
                    ->required()
            ])
            ->action(function (Model $record, array $data) {
                // simpan update data penolakan
                $record->update([
                    'status_peminjaman' => 'ditolak',
                    'ketarangan_ditolak' => $data['ketarangan_ditolak']
                ]);

                // Loop melalui detail peminjaman dan kembalikan stok barang
                foreach ($record->detailPeminjaman as $detail) {
                    $barang = $detail->barang;
                    if ($barang) {
                        $barang->stok_bagus += $detail->jumlah_masih_bagus;
                        $barang->stok_rusak_ringan += $detail->jumlah_rusak_ringan;
                        $barang->stock = $barang->stok_bagus + $barang->stok_rusak_ringan;
                        $barang->save();
                    }
                }

                Notification::make()
                    ->title('Pengajuan Ditolaks')
                    ->success()
                    ->send();
            });
    }
}
