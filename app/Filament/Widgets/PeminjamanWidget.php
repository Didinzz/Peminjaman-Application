<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Number;

class PeminjamanWidget extends BaseWidget
{

    use InteractsWithPageFilters;


    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null)
            ? Carbon::parse($this->filters['startDate'])
            : null;

        $endDate = ! is_null($this->filters['endDate'] ?? null)
            ? Carbon::parse($this->filters['endDate'])
            : now();



        // Data Peminjaman berdasarkan tanggal (jika ada filter)
        $totalPeminjaman = Peminjaman::query()
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->count();

        $peminjamanHariIni = Peminjaman::whereDate('created_at', today())->count();

        $sedangDipinjam = Peminjaman::query()
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->where('status_peminjaman', 'barang_diambil')
            ->count();

        $formatNumber = fn(int $number): string =>
        $number < 1000 ? (string) Number::format($number, 0)
            : ($number < 1000000
                ? Number::format($number / 1000, 2) . 'k'
                : Number::format($number / 1000000, 2) . 'm');
        // dd($startDate);

        return [
            Stat::make('Total Peminjaman', $formatNumber($totalPeminjaman))
                ->description('Total seluruh transaksi peminjaman')
                ->descriptionIcon('heroicon-o-archive-box', IconPosition::Before)
                ->color('success'),

            Stat::make('Hari Ini', $formatNumber($peminjamanHariIni))
                ->description('Jumlah peminjaman hari ini')
                ->descriptionIcon('heroicon-o-calendar-days', IconPosition::Before)
                ->color('primary'),

            Stat::make('Sedang Dipinjam', $formatNumber($sedangDipinjam))
                ->description('Peminjaman yang masih berlangsung')
                ->descriptionIcon('heroicon-o-clock', IconPosition::Before)
                ->color('warning'),
        ];
    }

    public static function canView(): bool
    {
        return Gate::allows('lihat_semua_pengajuan_peminjaman');
    }
}
