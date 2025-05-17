<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Contracts\View\View;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected static string $view = 'filament.pages.dashboard';

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make('Tanggal')->schema([
                DatePicker::make('Tanggal Awal'),
                DatePicker::make('Tanggal Akhir'),
            ])
                ->columns(2)
        ]);
    }

    public function getColumns(): int | string | array
    {
        return [
            'md' => 1,
            'xl' => 2,
        ];
    }
}
