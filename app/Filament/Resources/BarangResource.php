<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Doctrine\DBAL\Schema\Index;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    protected static ?string $navigationGroup = 'Management Barang';

    protected static ?string $navigationLabel = 'Barang';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tambah Barang')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->required(),
                        TextInput::make('stok_bagus')
                            ->label('Stok Bagus')
                            ->numeric()
                            ->required(),
                        TextInput::make('stok_rusak_ringan')
                            ->numeric()
                            ->label('Stok Rusak Ringan')
                            ->required(),
                        TextInput::make('stok_rusak_berat')
                            ->numeric()
                            ->label('Stok Rusak Berat')
                            ->required(),
                        Select::make('kategori_barang')
                            ->label('Jenis Barang Milik Negara (BMN)')
                            ->options([
                                'Elektronik' => 'BMN Elektronik',
                                'Non-Elektronik' => 'BMN Non-Elektronik',
                            ])
                            ->required(),
                        FileUpload::make('foto')
                            ->columnSpan(2)
                            ->image()
                            ->label('Foto Barang')
                            ->directory('foto-barang')
                            ->required(),

                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto Barang'),
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('stock')
                    ->label('Stok Tersedia')
                    ->sortable(),
                TextColumn::make('stok_bagus')
                    ->label('Masih bagus')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('stok_rusak_ringan')
                    ->label('Masih Bisa Dipakai')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('stok_rusak_berat')
                    ->label('Tidak bisa dipakai')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('kategori_barang')
                    ->label('Jenis BMN'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada barang')
            ->emptyStateDescription('Silahkan menambahkan data barang terelbih dahulu');
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
