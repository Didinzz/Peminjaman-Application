<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Barang;
use App\Models\Peminjaman;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PeminjamanResource extends Resource implements HasShieldPermissions
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
                Repeater::make('detailPeminjaman')
                    ->label('Barang Dipinjam')
                    ->addActionLabel('Tambah Barang')
                    ->relationship()
                    ->columnSpan(2)
                    ->schema([
                        Select::make('barang_id')
                            ->reactive()
                            ->relationship('barang', 'nama_barang')
                            ->afterStateUpdated(function (string $context, $state, callable $set) {
                                $barang = Barang::find($state);
                                if ($barang) {
                                    $set('stok_tersedia', $barang->stock);
                                    $set('jumlah_pinjaman', null);
                                }
                            })
                            ->label('Barang')
                            ->required(),
                        TextInput::make('stok_tersedia')
                            ->disabled()
                            ->label('Stok Tersedia'),
                        TextInput::make('jumlah_pinjaman')
                            ->label('Jumlah Pinjaman')
                            ->required()
                            ->numeric()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $stockTersedia = $get('stok_tersedia');

                                if ($state > $stockTersedia) {
                                    $set('jumlah_pinjaman', $stockTersedia);
                                    Notification::make()
                                        ->title('Jumlah Pinjaman Melebihi Stok Tersedia')
                                        ->danger()
                                        ->send();
                                }
                            }),
                    ])
                    ->columns(3),
                Section::make('Detail Pengajuan')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('tanggal_pinjam')
                            ->label('Tanggal Peminjaman')
                            ->required(),
                        DatePicker::make('tanggal_kembali')
                            ->label('Tanggal Pengembalian')
                            ->afterOrEqual('tanggal_pinjam')
                            ->validationMessages(['after_or_equal' => 'Tanggal pengembalian harus setelah tanggal peminjaman.'])
                            ->required(),
                        FileUpload::make('surat_peminjaman')
                            ->label('Surat Peminjaman')
                            ->directory('surat-peminjaman')
                            ->required(),
                        Textarea::make('keterangan')
                            ->required()
                            ->label('Alasan Peminjaman'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Peminjaman::where('status_peminjaman', 'diajukan'))
            ->emptyStateHeading('Belum ada pengajuan peminjaman')
            ->emptyStateDescription('Belum ada pengajuan peminjaman yang dilakukan')
            ->columns([
                TextColumn::make('user.name')
                    ->hidden(!Gate::allows('decide_peminjaman'))
                    ->searchable()
                    ->label('Peminjam'),

                TextColumn::make('jumlah_pinjaman')
                    ->label('Jumlah Pinjaman'),

                TextColumn::make('tanggal_pinjam')
                    ->date('d F')
                    ->label('Tanggal Peminjaman'),

                TextColumn::make('tanggal_kembali')
                    ->date('d F')
                    ->label('Tanggal Pengembalian'),

                TextColumn::make('barang_dipinjam') // Menampilkan banyak barang dalam satu kolom
                    ->label('Barang Dipinjam')
                    ->formatStateUsing(fn($record) => $record->detailPeminjaman->pluck('barang.nama_barang')->join(', ')),

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
                ActionGroup::make([
                    Action::make('bukti_peminjaman')
                        ->label('Surat')
                        // ->color('info')
                        ->icon('heroicon-o-eye')
                        ->modalHeading('Lihat Bukti Peminjaman')
                        ->hidden(fn(Peminjaman $record) => !$record->surat_peminjaman)
                        ->url(fn(Peminjaman $record) => Storage::url($record->surat_peminjaman), true) // Open in new tab
                        ->openUrlInNewTab(),
                    Action::make('approve')
                        ->label('Setuju')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->hidden(
                            fn(Peminjaman $record) =>
                            $record->status_peminjaman !== 'diajukan' || !Gate::allows('decide_peminjaman')
                        )
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
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->hidden(fn(Model $record) => $record->status_peminjaman !== 'diajukan' || !Gate::allows('decide_peminjaman'))
                        ->action(function (Model $record) {
                            $record->update(['status_peminjaman' => 'ditolak']);

                            Notification::make()
                                ->title('Peminjaman Ditolak')
                                ->danger()
                                ->send();
                        })
                        ->requiresConfirmation(),

                    // Tables\Actions\EditAction::make(),
                ])

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

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'decide',
        ];
    }
}
