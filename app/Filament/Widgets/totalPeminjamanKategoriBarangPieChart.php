<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Gate;

class totalPeminjamanKategoriBarangPieChart extends ChartWidget
{
    protected static ?string $heading = 'Perbandingan Peminjaman BMN';
    protected static ?string $maxHeight = '280px';

    protected static ?int $sort = 2;


    protected function getType(): string
    {
        return 'doughnut'; // bisa juga 'pie'
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'responsive' => true,
            'animation' => [
                'animateRotate' => true,   // Animasi rotasi saat load
                'animateScale' => true,    // Animasi scale saat load
                'duration' => 600,
                'easing' => 'easeInOutCubic',
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'display' => false,
                ],
                'x' => [
                    'display' => false,
                ],
            ],
        ];
    }


    protected function getData(): array
    {
        $data = DB::table('detail_peminjamen')
            ->join('peminjamen', 'detail_peminjamen.peminjaman_id', '=', 'peminjamen.id')
            ->join('barangs', 'detail_peminjamen.barang_id', '=', 'barangs.id')
            ->whereYear('peminjamen.tanggal_pemakaian', Carbon::now()->year)
            ->whereIn('peminjamen.status_peminjaman', ['disetujui', 'barang_diambil', 'dikembalikan'])
            ->select(
                'barangs.kategori_barang',
                DB::raw('SUM(detail_peminjamen.jumlah_pinjaman) as total')
            )
            ->groupBy('barangs.kategori_barang')
            ->pluck('total', 'kategori_barang');

        $elektronik = $data['Elektronik'] ?? 0;
        $nonElektronik = $data['Non-Elektronik'] ?? 0;

        return [
            'labels' => ['BMN Elektronik', 'BMN Non Elektronik'],
            'datasets' => [
                [
                    'data' => [$elektronik, $nonElektronik],
                    'backgroundColor' => ['#36A2EB', '#F44336'],
                    'hoverOffset' => 4,
                ]
            ],
        ];
    }
    public static function canView(): bool
    {
        return Gate::allows('lihat_semua_pengajuan_peminjaman');
    }
}
