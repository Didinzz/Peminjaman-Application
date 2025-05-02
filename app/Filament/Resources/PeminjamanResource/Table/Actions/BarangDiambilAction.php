<?php

namespace App\Filament\Resources\PeminjamanResource\Tables\Actions;

use App\Models\Peminjaman;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BarangDiambilAction
{
    public static function make(): Action
    {
        return Action::make('barang_diambil')
            ->label('Pengambilan')
            ->modalHeading('Konfirmasi Pengambilan Barang')
            ->color('info')
            ->hidden(fn($record) => !$record || $record->status_peminjaman !== 'disetujui' || !Gate::allows('decide_pengembalian_peminjaman'))
            ->form([
                Section::make()
                    ->schema([
                        FileUpload::make('foto_pengambilan')
                            ->image()
                            ->label(' Upload Bukti Pengambilan')
                            ->directory('foto-pengambilan')
                            ->required(),
                    ])
            ])
            ->action(function (Peminjaman $record, array $data) {
                $record->update([
                    'status_peminjaman' => 'barang_diambil',
                    'nama_petugas_pengambilan' => auth()->user()->name,
                    'foto_pengambilan' => $data['foto_pengambilan'],
                ]);
            });
    }
}
