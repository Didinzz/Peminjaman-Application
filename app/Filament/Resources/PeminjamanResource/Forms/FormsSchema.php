<?php

use App\Models\Barang;
use Filament\Forms\Components\DatePicker;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class PeminjamanFromSchema{
    public static function make(): array
    {
        return [
            Repeater::make('detailPeminjaman')
            ->label('Barang Dipinjam')
            ->addActionLabel('Tambah Barang')
            ->relationship()
            ->columnSpan(2)
            ->schema([
                Select::make('barang_id')
                    ->reactive()
                    ->relationship(
                        'barang',
                        'nama_barang',
                        modifyQueryUsing: function ($query, $get) {
                            // Ambil semua barang yang sudah dipilih
                            $selectedBarangIds = collect($get('detailPeminjaman'))->pluck('barang_id')->toArray();
        
                            // Filter untuk menampilkan barang yang belum dipilih
                            return $query->where('stock', '>', 0)
                                         ->whereNotIn('id', $selectedBarangIds); // Hindari barang yang sudah dipilih
                        }
                    )
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
                                ->title('jumlah pinjaman melebihi stok')
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
                    ->minDate(now()) // Tidak bisa pilih kemarin
                    ->reactive()
                    ->displayFormat('d F Y')
                    ->native(false)
                    ->suffixIcon('heroicon-o-calendar')
                    ->required(),

                DatePicker::make('tanggal_kembali')
                    ->label('Tanggal Pengembalian')
                    ->minDate(function (callable $get) {
                        $tanggalPinjam = $get('tanggal_pinjam');
                        return $tanggalPinjam ?? now(); // Jika belum pilih tanggal_pinjam, minimal hari ini
                    })
                    ->reactive()
                    ->displayFormat('d F Y')
                    ->native(false)
                    ->suffixIcon('heroicon-o-calendar')
                    ->validationMessages([
                        'after_or_equal' => 'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.',
                    ])
                    ->required(),
                FileUpload::make('surat_peminjaman')
                    ->label('Surat Peminjaman')
                    ->directory('surat-peminjaman')
                    ->required(),
                Textarea::make('keterangan')
                    ->required()
                    ->label('Alasan Peminjaman'),
            ])  
        ];
    }
}
