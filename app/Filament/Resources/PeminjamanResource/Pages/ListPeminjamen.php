<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use App\Models\Peminjaman;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;

class ListPeminjamen extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajukan Peminjaman'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make('Semua')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('status_peminjaman', ['diajukan', 'disetujui', 'menunggu_pembatalan'])),
            'Dipinjam' => Tab::make('Dipinjam')
                ->badge(Peminjaman::query()
                    ->when(
                        !Gate::allows('lihat_semua_pengajuan_peminjaman'), // Jika user tidak memiliki izin melihat semua data
                        fn($query) => $query->where('user_id', auth()->id()) // Hanya tampilkan data milik user tersebut
                    )
                    ->where('status_peminjaman', 'barang_diambil')
                    ->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_peminjaman', 'barang_diambil')),
        ];
    }
}
