<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class KategoriPeminjamanBarangChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '500px';

    protected static ?string $heading = 'Grafik Peminjaman Jenis Barang';
    protected static bool $isLazy = true;

    


    protected function getOptions(): array
    {
        return [
            // 'maintainAspectRatio' => false,
            // 'responsive' => true,
            'height' => 500,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
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
            ->whereIn('peminjamen.status_peminjaman', ['dibatalkan', 'dikembalikan', 'barang_diambil'])
            ->select(
                DB::raw('MONTH(peminjamen.tanggal_pemakaian) as bulan'),
                'barangs.kategori_barang',
                DB::raw('SUM(detail_peminjamen.jumlah_pinjaman) as total')
            )
            ->groupBy('bulan', 'barangs.kategori_barang')
            ->get();

        // Siapkan array 12 bulan untuk masing-masing kategori
        $elektronik = array_fill(1, 12, 0);
        $nonelektronik = array_fill(1, 12, 0);

        foreach ($data as $item) {
            if ($item->kategori_barang === 'Elektronik') {
                $elektronik[$item->bulan] = (int) $item->total;
            } else {
                $nonelektronik[$item->bulan] = (int) $item->total;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'BMN Elektronik',
                    'data' => array_values($elektronik),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
                [
                    'label' => 'BMN Non Elektronik',
                    'data' => array_values($nonelektronik),
                    'backgroundColor' => '#F44336',
                    'borderColor' => '#F44336',
                ]
            ],
            'labels' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
