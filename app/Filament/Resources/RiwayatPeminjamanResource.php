<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Infolists\PeminjamanInfo;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\BuktiPeminjamanAction;
use App\Filament\Resources\PeminjamanResource\Tables\PeminjamanColumn;
use App\Filament\Resources\RiwayatPeminjamanResource\Pages;
use App\Filament\Resources\RiwayatPeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Tables\Actions\ActionGroup;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;

class RiwayatPeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationGroup = 'Management Peminjaman';
    protected static ?string $label = 'Riwayat Peminjaman';
    protected static ?string $navigationLabel = 'Riwayat';
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Belum ada riwayat peminjaman')
            ->emptyStateDescription('Anda belum melakukan mengajukan peminjaman sama sekali')
            ->columns(PeminjamanColumn::make())
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                    ->color('green')
                    ->label('Detail'),
                BuktiPeminjamanAction::make()
                ->label('Bukti Peminjaman')
                ->color('indigo'),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->before(function ($records) {
                            $records->load('detailPeminjaman');

                            foreach ($records as $record) {
                                // validasi pengembalian ketika status peminjaman itu ditolak, dikembalikan, dibatalkan
                                if (!in_array($record->status_peminjaman, ['ditolak', 'dikembalikan', 'dibatalkan'])) {
                                    // Sekarang kamu bisa akses relasi
                                    foreach ($record->detailPeminjaman as $detail) {
                                        $barang = $detail->barang;
                                        if ($barang) {
                                            $barang->stok_bagus += $detail->jumlah_masih_bagus;
                                            $barang->stok_rusak_ringan += $detail->jumlah_rusak_ringan;
                                            $barang->stock = $barang->stok_bagus + $barang->stok_rusak_ringan;
                                            $barang->save();
                                        }
                                    }
                                }
                            }
                        }),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status_peminjaman', ['ditolak', 'dikembalikan', 'dibatalkan'])
            ->when(
                !Gate::allows('lihat_semua_pengajuan_peminjaman'), // Jika user tidak memiliki izin melihat semua data
                fn($query) => $query->where('user_id', auth()->id()) // Hanya tampilkan data milik user tersebut
            )
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
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
            'index' => Pages\ListRiwayatPeminjamen::route('/'),
            'view' => Pages\ViewRiwayatPeminjaman::route('/{record}'),

            // 'create' => Pages\CreateRiwayatPeminjaman::route('/create'),
            // 'edit' => Pages\EditRiwayatPeminjaman::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(PeminjamanInfo::make());
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'create',
            'edit',
            'delete',
        ];
    }
}
