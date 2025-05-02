<?php

namespace App\Filament\Resources\PeminjamanResource\Actions;

use App\Filament\Resources\PeminjamanResource\Tables\Actions\BarangDiambilAction;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\BuktiPeminjamanAction;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\DikembalikanAction;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\SetujuActoin;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\TolakAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;

class PeminjamanTableActions
{
    public static function group(): ActionGroup
    {
        return ActionGroup::make([
            ViewAction::make(),
            BuktiPeminjamanAction::make(),
            BarangDiambilAction::make(),
            DikembalikanAction::make(),
            SetujuActoin::make(),
            TolakAction::make()
        ]);
    }
}
