<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Number;


class PeminjamWidget extends BaseWidget
{

    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $userId = auth()->id();
        // Ambil filter tanggal dari filter form (misal via Livewire/Filament Table Filters)
        $startDate = !is_null($this->filters['startDate'] ?? null)
            ? Carbon::parse($this->filters['startDate'])
            : null;

        $endDate = !is_null($this->filters['endDate'] ?? null)
            ? Carbon::parse($this->filters['endDate'])
            : now();

        // Fungsi format angka (misal 1.2k, 1.3m)
        $formatNumber = fn(int $number): string =>
        $number < 1000 ? (string) Number::format($number, 0)
            : ($number < 1000000
                ? Number::format($number / 1000, 2) . 'k'
                : Number::format($number / 1000000, 2) . 'm');

        // Total Peminjaman oleh user dalam rentang tanggal
        $total = DB::table('peminjamen')
            ->where('user_id', $userId)
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->count();

        // Barang sedang dipinjam oleh user
        $sedangDipinjam = DB::table('peminjamen')
            ->where('user_id', $userId)
            ->where('status_peminjaman', 'barang_diambil')
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->count();

        // Peminjaman menunggu verifikasi oleh user
        $menungguVerifikasi = DB::table('peminjamen')
            ->where('user_id', $userId)
            ->where('status_peminjaman', 'diajukan')
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->count();

        return [
            Stat::make('Total Pengajuan', $formatNumber($total))
                ->description('Jumlah semua pengajuan')
                ->color('primary'),
            Stat::make('Menunggu verifikasi', $formatNumber($menungguVerifikasi))
                ->description('Menunggu verifikasi pengajuan')
                ->color('success'),

            Stat::make('Sedang Dipinjam', $formatNumber($sedangDipinjam))
                ->description('Barang yang belum dikembalikan')
                ->color('warning'),

        ];
    }

    public static function canView(): bool
    {
        return !Gate::allows('lihat_semua_pengajuan_peminjaman');
    }
}
