<x-filament::page>
    <div class="grid grid-cols-2 lg:grid-cols-2 gap-4">
        <div class="h-[400px]">
            @livewire(\App\Filament\Widgets\KategoriPeminjamanBarangChartWidget::class)
        </div>

        <div class="h-[400px]">
            @livewire(\App\Filament\Widgets\TotalPeminjamanKategoriBarangPieChart::class)
        </div>
    </div>
</x-filament::page>
