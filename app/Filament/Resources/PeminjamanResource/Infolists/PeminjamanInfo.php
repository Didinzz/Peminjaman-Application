<?php

namespace App\Filament\Resources\PeminjamanResource\Infolists;

use Filament\Forms\Components\Component;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\Section as ComponentsSection;



class PeminjamanInfo
{
    public static function make(): array
    {
        return [
            RepeatableEntry::make('detailPeminjaman')
                ->grid(2)
                ->label('Barang Dipinjam')
                ->columnSpanFull()
                ->schema([
                    Split::make([
                        Grid::make(2)
                            ->schema([
                                ComponentsGroup::make([
                                    TextEntry::make('barang.nama_barang')
                                        ->label('Nama Barang'),
                                    TextEntry::make('barang.kategori_barang')
                                        ->label('Jenis BMN')
                                        ->formatStateUsing(fn(string $state): string => match ($state) {
                                            'Elektronik' => 'BMN Elektronik',
                                            'Non-Elektronik' => 'BMN Non-Elektronik',
                                        }),
                                    TextEntry::make('jumlah_pinjaman')
                                        ->label('Jumlah Pinjaman'),
                                ]),
                                ImageEntry::make('barang.foto')
                                    ->label('Foto Barang')
                            ])
                    ])
                ]),
            ComponentsSection::make('Peminjaman')
                ->schema([
                    Split::make([
                        Grid::make(3)
                            ->schema([
                                // components group detail peminjaman
                                ComponentsGroup::make([
                                    TextEntry::make('user.name')
                                        ->label('Nama Peminjam'),
                                    TextEntry::make('created_at')
                                        ->since()
                                        ->label('Tanggal Pengajuan'),
                                    TextEntry::make('tanggal_pemakaian')
                                        ->date('d M Y')
                                        ->label('Dipakai Pada'),
                                    TextEntry::make('tanggal_kembali')
                                        ->date('d M Y')
                                        ->label('Rencana Pengembalian'),
                                ]),
                                // compontents group pengambilan
                                ComponentsGroup::make([
                                    TextEntry::make('status_peminjaman')
                                        ->badge()
                                        ->formatStateUsing(fn($state): string => str()->headline($state))
                                        ->color(fn(string $state): string => match ($state) {
                                            'diajukan' => 'warning',
                                            'disetujui' => 'success',
                                            'ditolak' => 'danger',
                                            'dikembalikan' => 'primary',
                                            'barang_diambil' => 'info',
                                            'menunggu_pembatalan' => 'warning',
                                            'dibatalkan' => 'danger',
                                        })
                                        ->label('Status Peminjaman'),
                                    TextEntry::make('nama_petugas_pengambilan')
                                        ->label('Diserahkan Oleh')
                                        ->default('Belum diserahkan'),
                                    ImageEntry::make('foto_pengambilan')
                                        ->hidden(fn($record): bool => !in_array($record->status_peminjaman, ['barang_diambil', 'dikembalikan']))
                                        ->label('Bukti Pengambilan'),
                                ]),
                                // component group pengembalian
                                ComponentsGroup::make([
                                    TextEntry::make('tanggal_dikembalikan')
                                        ->default('Belum dikembalikan')
                                        ->label('Tanggal Dikembalikan'),
                                    TextEntry::make('nama_petugas_pengembalian')
                                        ->default('Belum dikembalikan')
                                        ->label('Diterima Oleh'),
                                    TextEntry::make('status_pengembalian')
                                        ->badge()
                                        ->formatStateUsing(fn($state): string => str()->headline($state))
                                        ->color(fn(string $state): string => match ($state) {
                                            'tepat_waktu' => 'success',
                                            'terlambat' => 'danger',
                                            'Belum dikembalikan' => 'warning',
                                        })
                                        ->default('Belum dikembalikan')
                                        ->label('Status Pengembalian'),
                                    ImageEntry::make('foto_pegembalian')
                                        ->hidden(fn($record): bool => $record->status_peminjaman !== 'dikembalikan')
                                        ->label('Foto Pengembalian')
                                ]),
                            ])
                    ]),
                    ComponentsSection::make('Keterangan Pembatalan')
                        ->hidden(fn($record): bool => !in_array($record->status_peminjaman, ['menunggu_pembatalan', 'dibatalkan']))
                        ->schema([
                            TextEntry::make('alasan_pembatalan')
                                ->hiddenLabel(true)
                        ]),
                    ComponentsSection::make('Ketarangan Ditolak')
                        ->hidden(fn($record): bool => $record->status_peminjaman !== 'ditolak')
                        ->schema([
                            TextEntry::make('ketarangan_ditolak')
                                ->hiddenLabel(true)
                        ]),
                    ComponentsSection::make('Keterangan Peminjaman')
                        ->schema([
                            TextEntry::make('keterangan')
                                ->hiddenLabel(true)

                        ]),
                ])
        ];
    }
}
