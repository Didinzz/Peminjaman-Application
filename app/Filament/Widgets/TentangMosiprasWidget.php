<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TentangMosiprasWidget extends Widget
{
    protected static string $view = 'filament.widgets.tentang-mosipras-widget';

    protected static ?int $sort = 3; // agar muncul di atas

    protected int | string | array $columnSpan = 1; // lebar penuh

    public static function canView(): bool
    {
        return true; // bisa ditambahkan Gate jika perlu role-based
    }
}
