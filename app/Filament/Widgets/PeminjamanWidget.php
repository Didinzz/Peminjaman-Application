<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use function Livewire\before;

class PeminjamanWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total', Peminjaman::count())
                ->description('Jumlah total peminjaman')
                ->color('success')
                ->chart([20, 121, 112, 160]),
            Stat::make('Hari ini', Peminjaman::whereDate('created_at', today())->count())
                ->description('Jumlah peminjaman hari ini')
                ->color('primary')
                ->chart([rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100)]),
            Stat::make('Berlangsung', Peminjaman::where('status_peminjaman', 'sedang_dipinjam')->count())
                ->description('Pinjaman sedang berlangsung')
                ->color('warning')
                ->chart([rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100)]),
        ];
    }
}
