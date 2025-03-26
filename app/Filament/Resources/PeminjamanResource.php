<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Barang;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pengajuan';

    protected static ?string $label = 'Pengajuan';


    protected static ?string $navigationGroup = 'Management Peminjaman';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('barang_id')
                    ->live()
                    ->afterStateUpdated(function (string $context, $state, callable $set) {
                        $stockTersedia = Barang::find($state);
                        if ($stockTersedia) {
                            $set('stock_tersedia', $stockTersedia->stock);
                        }
                    })
                    ->label('Barang')
                    ->required()
                    ->relationship('barang', 'name'),
                TextInput::make('stock_tersedia')
                    ->disabled()
                    ->label('Stock Tersedia'),
                TextInput::make('jumlah_pinjaman')
                    ->label('Jumlah Pinjaman')
                    ->required(),
                DatePicker::make('tanggal_pinjam')
                    ->label('Tanggal Peminjaman')
                    ->required(),
                DatePicker::make('tanggal_kembali')
                    ->label('Tanggal Pengembalian')
                    ->required(),
                FileUpload::make('bukti_peminjaman')
                    ->label('Bukti Peminjaman')
                    ->directory('buktiPeminjaman')
                    ->required(),
                Textarea::make('keterangan')
                    ->columnSpan(2)
                    ->label('Alasan Peminjaman'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_pinjam')
                    ->date('d F')
                    ->label('Tanggal Peminjaman'),
                TextColumn::make('tanggal_kembali')
                    ->date('d F')
                    ->label('Tanggal Pengembalian'),
                TextColumn::make('barang.name')
                    ->label('Barang'),
                TextColumn::make('status_peminjaman')
                    ->badge()
                    ->formatStateUsing(fn($state): string => str()->headline($state))
                    ->label('Status')
                    ->color(fn(string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    }),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])

            ->actions([
                Action::make('approve')
                    ->label('Setuju')
                    ->color('success')
                    ->hidden(fn(Model $record) => $record->status_peminjaman !== 'diajukan')
                    ->action(function (Model $record) {
                        $record->update(['status_peminjaman' => 'disetujui']);

                        Notification::make()
                            ->title('Peminjaman Disetujui')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
                Action::make('tolak')
                    ->label('Tolak')
                    ->color('danger')
                    ->hidden(fn(Model $record) => $record->status_peminjaman !== 'diajukan')
                    ->action(function (Model $record) {
                        $record->update(['status_peminjaman' => 'ditolak']);

                        Notification::make()
                            ->title('Peminjaman Ditolak')
                            ->danger()
                            ->send();
                    })
                    ->requiresConfirmation(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
