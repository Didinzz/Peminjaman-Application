<?php

namespace App\Filament\Resources\PeminjamanResource\Tables\Actions;

use App\Models\Barang;
use App\Models\Peminjaman;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DikembalikanAction
{
    public static function make(): Action
    {
        return Action::make('dikembalikan')
            ->label('Pengembalian')
            ->icon('heroicon-s-arrow-path-rounded-square')
            ->color('info')
            ->modalHeading('Konfirmasi Pengembalian')
            ->hidden(fn($record) => !$record || $record->status_peminjaman !== 'barang_diambil' || !Gate::allows('decide_pengembalian_peminjaman'))
            ->form([
                Section::make()
                    ->columns(1)
                    ->schema([
                        // DatePicker::make('tanggal_dikembalikan')
                        //     ->label('Tanggal Dikembalikan')
                        //     ->required(),
                        // FileUpload::make('foto_pegembalian')
                        //     ->image()
                        //     ->label('Foto Pengembalian')
                        //     ->directory('foto-pengembalian')
                        //     ->required(),
                        Repeater::make('detailPeminjaman')
                            ->label('Verifikasi Kondisi Barang')
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        Placeholder::make('barang_nama')
                                            ->label('Nama Barang')
                                            ->content(fn($state, $get) => $get('barang.nama_barang')),

                                        TextInput::make('jumlah_pinjaman')
                                            ->disabled()
                                            ->label('Jumlah Dipinjam'),

                                        TextInput::make('jumlah_masih_bagus')
                                            ->label('Masih Bagus')
                                            ->numeric()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                                self::validateJumlahPengembalian($get, $set, 'jumlah_masih_bagus');
                                            }),

                                        TextInput::make('jumlah_rusak_ringan')
                                            ->label('Rusak Ringan')
                                            ->numeric()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                                self::validateJumlahPengembalian($get, $set, 'jumlah_rusak_ringan');
                                            }),

                                        TextInput::make('jumlah_rusak_berat')
                                            ->label('Rusak Berat')
                                            ->numeric()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                                self::validateJumlahPengembalian($get, $set, 'jumlah_rusak_berat');
                                            }),
                                    ])
                            ])
                            ->default(fn($record) => $record->detailPeminjaman->map(function ($item) {
                                return [
                                    'barang' => $item->barang->toArray(),
                                    'jumlah_pinjaman' => $item->jumlah_pinjaman,
                                ];
                            })->toArray())
                            ->deletable(false)
                            ->addable(false)
                            ->grid(2)
                    ])
            ])
            ->action(function (Peminjaman $record, array $data) {

                // $tanggalDikembalian = \Carbon\Carbon::parse($data['tanggal_dikembalikan']);
                // $tanggalKembali = \Carbon\Carbon::parse($record->tanggal_kembali);

                // $isTerlambat = $tanggalDikembalian->gt($tanggalKembali);

                // simpan udpate data pengembalian
                // $record->update([
                //     'status_peminjaman' => 'dikembalikan',
                //     'tanggal_dikembalikan' => $data['tanggal_dikembalikan'],
                //     'nama_petugas_pengembalian' => auth()->user()->name,
                //     'foto_pegembalian' => $data['foto_pegembalian'],
                //     'status_pengembalian' => $isTerlambat ? 'terlambat' : 'tepat_waktu',
                // ]);

                // Loop melalui detail peminjaman dan kembalikan stok barang
                foreach ($record->detailPeminjaman as $detail) {
                    $barang = Barang::find($detail['barang_id']);
                    dd($detail);
                    // dd($barang->nama_barang);
                    if ($barang) {
                        // $barang->update([
                        //     ' stok_bagus' => $barang->stok_bagus + $detail->jumlah_masih_bagus,
                        //     'stock' => $barang->stock + $detail->jumlah_pinjaman,
                        // ]);
                        // dd($barang->nama_barang, $barang->stok_bagus);
                    }
                }
                // Notifikasi sukses
                // Notification::make()
                //     ->title('Peminjaman Dikembalikan')
                //     ->success()
                //     ->send();

                // notifikasi jika peminjaman terlambat
                // if ($isTerlambat) {
                //     Notification::make()
                //         ->title('Peminjaman Terlambat dikembalikan')
                //         ->warning()
                //         ->send();
                // }
            });
    }

    public static function validateJumlahPengembalian(callable $get, callable $set, string $changedField): void
    {
        $jumlahPinjam = intval($get('jumlah_pinjaman'));
        $jumlahBagus = $get('jumlah_masih_bagus');
        $jumlahRingan = $get('jumlah_rusak_ringan');
        $jumlahBerat = $get('jumlah_rusak_berat');

        // Jangan validasi jika ada field belum diisi
        if ($jumlahBagus === null || $jumlahRingan === null || $jumlahBerat === null) {
            return;
        }

        $totalKembali = intval($jumlahBagus) + intval($jumlahRingan) + intval($jumlahBerat);

        if ($totalKembali > $jumlahPinjam) {
            Notification::make()
                ->title("Jumlah pengembalian ($totalKembali) melebihi jumlah pinjaman ($jumlahPinjam).")
                ->danger()
                ->send();

            // Hanya reset field yang diubah, bukan semua
            $set($changedField, null);
        } elseif ($totalKembali < $jumlahPinjam) {
            Notification::make()
                ->title("Jumlah pengembalian ($totalKembali) masih kurang dari jumlah pinjaman ($jumlahPinjam).")
                ->warning()
                ->send();
            $set($changedField, null);
        }
    }
}
