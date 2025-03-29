<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

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
            'diajukan' => Tab::make('Di Ajukan')
            ->hidden(),
            'disetujui' => Tab::make('Disetujui'),
            'ditolak' => Tab::make('Ditolak'),
            'dikembalikan' => Tab::make('Dikembalikan'),
        ];
    }
}
