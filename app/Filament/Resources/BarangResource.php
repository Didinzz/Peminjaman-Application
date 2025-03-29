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
                    TextInput::make('stock')
                        ->label('Stok Tersedia')
                        ->required(),
                    FileUpload::make('foto')
                        ->image()
                        ->label('Foto Barang')
                        ->directory('foto-barang')
                        ->required(),
                    Select::make('kategori_barang')
                        ->options([
                            'Elektronik' => 'Elektronik',
                            'Non-Elektronik' => 'Non-Elektronik',
                        ])
                        ->required()
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
                TextColumn::make('kategori_barang')
                    ->label('Kategori Barang')
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
