<?php

namespace App\Filament\Resources\PeminjamanResource\Tables\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;

class BuktiPeminjamanAction
{
    public static function make(): Action
    {
        return Action::make('bukti_peminjaman')
            ->label('Surat')
            ->icon('heroicon-o-document-text')
            ->color('primary')
            ->modalHeading('Lihat Bukti Peminjaman')
            ->url(fn($record) => $record ? Storage::url($record->surat_peminjaman) : '#', true) // Open in new tab
            ->openUrlInNewTab();
    }
}
