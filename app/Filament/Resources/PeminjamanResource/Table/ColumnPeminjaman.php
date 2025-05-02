<?php

namespace App\Filament\Resources\PeminjamanResource\Tables;

use App\Models\Peminjaman;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Gate;
class PeminjamanColumn
{
    public static function make(): array
    {
        return [
            TextColumn::make('user.name')
                    ->hidden(!Gate::allows('all_peminjaman'))
                    ->searchable()
                    ->label('Peminjam'),
                ImageColumn::make('detailPeminjaman.barang.foto')
                    ->circular()
                    ->stacked()
                    ->limit(2)
                    ->limitedRemainingText()
                    ->label('Barang'),
                TextColumn::make('tanggal_pinjam')
                    ->date('d F')
                    ->label('Tanggal Peminjaman'),
                TextColumn::make('tanggal_kembali')
                    ->date('d F')
                    ->label('Tanggal Pengembalian'),
                TextColumn::make('status_peminjaman')
                    ->badge()
                    ->formatStateUsing(fn($state): string => str()->headline($state))
                    ->label('Status')
                    ->description(fn(Peminjaman $record): string => $record->ketarangan_ditolak ?: '')
                    ->color(fn(string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        'dikembalikan' => 'primary',
                        'barang_diambil' => 'info',
                    }),
        ];
    }
    
}