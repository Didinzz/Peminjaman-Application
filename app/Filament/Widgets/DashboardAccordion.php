<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardAccordion extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-accordion';

    protected static ?int $sort = 3; // agar muncul di atas

    protected int | string | array $columnSpan = 'full'; // lebar penuh

    public static function canView(): bool
    {
        return true; // bisa ditambahkan Gate jika perlu role-based
    }
}
