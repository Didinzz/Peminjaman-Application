<?php

// app/Filament/Pages/ChartsPage.php

use Filament\Pages\Page;

class ChartsPage extends Page
{
    protected static ?string $navigationLabel = 'Charts';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.chart';
}
