<?php

namespace App\Filament\Resources\PeminjamanResource\Tables;

use App\Models\Peminjaman;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
            TextColumn::make('created_at')
                ->date('d F Y')
                ->label('Dibuat'),
            TextColumn::make('tanggal_pemakaian')
                ->date('d F Y')
                ->label('Pemakaian'),
            TextColumn::make('tanggal_kembali')
                ->date('d F Y')
                ->label('Pengembalian'),
            TextColumn::make('status_peminjaman')
                ->badge()
                ->formatStateUsing(fn($state): string => str()->headline($state))
                ->label('Status')
                ->description(function(Peminjaman $record): string {
                    $keteranganDitolak = $record->ketarangan_ditolak;
                    $deskripsi = '';
                    $alasanPembatalan = $record->alasan_pembatalan;
                    if($record->status_peminjaman === 'ditolak') {
                        $deskripsi = $keteranganDitolak;
                    } else if($record->status_peminjaman === 'menunggu_pembatalan' || $record->status_peminjaman === 'dibatalkan') {
                        $deskripsi = $alasanPembatalan;
                    }

                    return Str::words($deskripsi, 3, '...');
                })
                ->color(fn(string $state): string => match ($state) {
                    'diajukan' => 'warning',
                    'disetujui' => 'success',
                    'ditolak' => 'danger',
                    'dikembalikan' => 'primary',
                    'barang_diambil' => 'info',
                    'menunggu_pembatalan' => 'warning',
                    'dibatalkan' => 'danger'
                }),
        ];
    }
}
