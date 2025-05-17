<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Contracts\View\View;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form | null
    {

        return $form->schema([
            Section::make()->schema([
                DatePicker::make('startDate')
                    ->maxDate(fn(Get $get) => $get('endDate') ?: now())
                    ->label('Tanggal Awal'),
                DatePicker::make('endDate')
                    ->maxDate(fn(Get $get) => $get('endDate') ?: now())
                    ->minDate(fn(Get $get) => $get('startDate') ?: now())
                    ->maxDate(now())
                    ->label('Tanggal Akhir'),
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
