<?php

namespace App\Filament\Resources\PeminjamanResource\Infolists;

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
                                        ->label('Tipe Barang'),
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
                        Grid::make(2)
                            ->schema([
                                ComponentsGroup::make([
                                    TextEntry::make('user.name')
                                        ->label('Nama Peminjam'),
                                    TextEntry::make('tanggal_pinjam')
                                        ->date('d M Y')
                                        ->label('Tanggal Peminjaman'),
                                    TextEntry::make('tanggal_kembali')
                                        ->date('d M Y')
                                        ->label('Tanggal Pengembalian'),
                                ]),
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
                                        })
                                        ->label('Status Peminjaman'),
                                    TextEntry::make('tanggal_dikembalikan')
                                        ->default('Belum dikembalikan')
                                        ->label('Tanggal Dikembalikan'),
                                    ImageEntry::make('foto_pegembalian')
                                        ->hidden(fn($record): bool => $record->status_peminjaman !== 'dikembalikan')
                                        ->label('Foto Pengembalian')
                                ]),
                            ])
                    ]),
                    ComponentsSection::make('Alasan Peminjaman')
                        ->schema([
                            TextEntry::make('keterangan')
                        ])
                ])
        ];
    }
}
