<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;

    protected static ?string $title = 'Tambah Barang';

    protected static bool $canCreateAnother = false;


    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return 'Barang Berhasil Ditambahkan';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['stock'] = (int)$data['stok_bagus'] + (int)$data['stok_rusak_ringan'];
        return $data;
    }
}
