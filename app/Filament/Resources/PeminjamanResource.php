<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Actions\PeminjamanTableActions;
use App\Filament\Resources\PeminjamanResource\Infolists\PeminjamanInfo;
use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\Tables\PeminjamanColumn;
use App\Models\Peminjaman;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;
use PeminjamanFromSchema;

class PeminjamanResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationLabel = 'Pengajuan';

    protected static ?string $label = 'Pengajuan';


    protected static ?string $navigationGroup = 'Management Peminjaman';



    public static function form(Form $form): Form
    {
        return $form->schema(PeminjamanFromSchema::make());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Belum ada pengajuan peminjaman')
            ->emptyStateDescription('Belum ada pengajuan peminjaman yang dilakukan')
            ->columns(PeminjamanColumn::make())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])

            ->actions([PeminjamanTableActions::group(),])
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
            'view' => Pages\ViewPengajuanPeminjaman::route('/{record}'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(
                !Gate::allows('all_peminjaman'), // Jika user tidak memiliki izin melihat semua data
                fn($query) => $query->where('user_id', auth()->id()) // Hanya tampilkan data milik user tersebut
            )
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
            'all',
            'decide_pengembalian',
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(PeminjamanInfo::make());
    }
}
