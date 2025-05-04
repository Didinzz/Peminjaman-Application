<?php

namespace App\Filament\Resources\PeminjamanResource\Tables\Actions;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SetujuActoin
{
    public static function make(): Action
    {
        return Action::make('approve')
            ->label('Setuju')
            ->hidden(fn($record) => !$record || $record->status_peminjaman !== 'diajukan' || !Gate::allows('decide_peminjaman'))
            ->action(function (Model $record) {
                $record->update(['status_peminjaman' => 'disetujui']);

                Notification::make()
                    ->title('Peminjaman Disetujui')
                    ->success()
                    ->send();
            })
            ->requiresConfirmation();
    }
}
