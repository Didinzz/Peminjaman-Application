<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;

class LaporanPeminjaman extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-printer';

    protected static string $view = 'filament.pages.laporan-peminjaman';
    protected static ?string $navigationGroup = 'Management Peminjaman';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Cetak Laporan';


    public ?array $data = [];
    public ?string $pdfUrl = null;
    public bool $showPdfPlaceholder = true;

    public function mount(): void
    {
        $this->form->fill([
            'tanggal_mulai' => now()->startOfMonth()->format('Y-m-d'),
            'tanggal_selesai' => now()->format('Y-m-d'),
            'jenis_barang' => 'bmn_elektronik', // Contoh default
            'nama_petugas' => 'petugas_a',     // Contoh default
            'nama_kepala_sekolah' => '', // Biarkan kosong atau isi default
        ]);

        // Panggil generatePdfUrl sekali saat mount untuk memuat PDF awal berdasarkan default
        $this->generatePdfUrl();
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    DatePicker::make('tanggal_mulai')
                        ->label('Dari Tanggal')
                        ->reactive() // Membuat field ini reaktif
                        ->afterStateUpdated(fn() => $this->generatePdfUrl()), // Panggil method saat state berubah
                    DatePicker::make('tanggal_selesai')
                        ->label('Sampai Tanggal')
                        ->reactive()
                        ->afterStateUpdated(fn() => $this->generatePdfUrl()),
                ]),
            Grid::make(3)
                ->schema([
                    Select::make('jenis_barang')
                        ->label('Jenis Barang')
                        ->options([
                            'bmn_elektronik' => 'BMN Elektronik',
                            'bmn_non_elektronik' => 'BMN Non Elektronik',
                        ])
                        ->reactive()
                        ->afterStateUpdated(fn() => $this->generatePdfUrl()),
                    Select::make('nama_petugas')
                        ->label('Nama Petugas')
                        ->options(function () {
                            return User::role('petugas')
                                ->pluck('name', 'id')
                                ->all();
                        })
                        ->reactive()
                        ->afterStateUpdated(fn() => $this->generatePdfUrl()),
                    TextInput::make('nama_kepala_sekolah')
                        ->label('Nama Kepala Sekolah')
                        ->placeholder('Masukkan nama kepala sekolah')
                        ->live(debounce: 500) // live() dengan debounce untuk text input
                        ->afterStateUpdated(fn() => $this->generatePdfUrl()),
                ]),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data') // Mengikat data form ke properti $data
            ->columns(1); // Layout utama form adalah 1 kolom, Grid di dalam schema akan mengatur sub-layout
    }

    public function submitReport(): void
    {
        // Ambil data dari form yang sudah divalidasi
        $formData = $this->form->getState();



        Log::info('Form Laporan Disubmit:', $formData); // Untuk debugging, cek di storage/logs/laravel.log

        Notification::make()
            ->title('Permintaan Laporan Diterima')
            ->body('Data formulir: ' . json_encode($formData))
            ->success()
            ->send();
    }

    public function generatePdfUrl(): void
    {
        $currentFormData = $this->form->getState();

        if (empty($currentFormData['tanggal_mulai']) || empty($currentFormData['tanggal_selesai']) || empty($currentFormData['nama_kepala_sekolah'])) {
            $this->pdfUrl = null;
            $this->showPdfPlaceholder = true;
            return;
        }

        $this->pdfUrl = route('report.stream.peminjaman', $currentFormData);
        $this->showPdfPlaceholder = false;

    }
}
