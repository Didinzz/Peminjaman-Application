<?php

use App\Models\Peminjaman;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class PengajuanPembatalanAction
{
    public static function make(): Action
    {
        return Action::make('pengajuan_pembatalan')
            ->label('Batalkan')
            ->modalHeading('Pengajuan Pembatalan')
            ->hidden(
                fn($record) => !$record
                    || !in_array($record->status_peminjaman, ['diajukan', 'disetujui'])
                    // || !Gate::allows('decide_peminjaman')
            )
            ->form([
                Section::make()
                    ->schema([
                        Textarea::make('alasan_pembatalan')
                            ->label('Alasan Pembatalan')
                            ->required(),
                    ])
            ])
            ->action(function (Peminjaman $record, array $data) {
                // simpan update data penolakan
                $record->update([
                    'status_peminjaman' => 'menunggu_pembatalan',
                    'alasan_pembatalan' => $data['alasan_pembatalan']
                ]);

                Notification::make()
                    ->title('Pembatalan Diajukan')
                    ->success()
                    ->send();
            });
    }
}
