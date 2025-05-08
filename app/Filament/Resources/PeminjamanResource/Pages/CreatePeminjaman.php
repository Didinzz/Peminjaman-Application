<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Validation\ValidationException;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePeminjaman extends CreateRecord
{
    protected static string $resource = PeminjamanResource::class;
    protected static ?string $title = 'Ajukan Peminjaman';

    protected static bool $canCreateAnother = false;


    protected static string  $label = 'Tambah Peminjaman';

   protected function getCreateFormAction(): Action
   {
       return parent::getCreateFormAction()
           ->label('Ajukan');
   }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'Peminjaman berhasil diajukan';
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = auth()->id();
        $data['user_id'] = $userId;
        return $data;
    }

}
