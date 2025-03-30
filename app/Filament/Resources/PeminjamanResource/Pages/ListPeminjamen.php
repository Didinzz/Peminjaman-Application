<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPeminjamen extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make('Semua')
            ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('status_peminjaman', ['diajukan', 'disetujui'])),
            'Disetujui' => Tab::make('Disetujui')
            ->modifyQueryUsing(fn(Builder $query) => $query->where('status_peminjaman', 'disetujui')),
            'Riwayat' => Tab::make('Riwayat Pengajuan')
            ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('status_peminjaman', ['ditolak', 'dikembalikan'])),
        ];
    }
}
