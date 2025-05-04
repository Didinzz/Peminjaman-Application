<?php

namespace App\Filament\Resources\PeminjamanResource\Actions;

use App\Filament\Resources\PeminjamanResource\Tables\Actions\BarangDiambilAction;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\BuktiPeminjamanAction;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\DikembalikanAction;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\SetujuActoin;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\TolakAction;
use App\Filament\Resources\PeminjamanResource\Tables\Actions\VerifikasiPengajuanPembatalanAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use PengajuanPembatalanAction;

class PeminjamanTableActions
{
    public static function group(): ActionGroup
    {
        return ActionGroup::make([
            ViewAction::make()
                ->label('Detail')
                ->color('sky'),
            BuktiPeminjamanAction::make()
            ->color('indigo'),
            BarangDiambilAction::make()
            ->color('emerald'),
            DikembalikanAction::make()
            ->color('green'),
            SetujuActoin::make()
            ->color('success'),
            TolakAction::make()
            ->color('danger'),
            PengajuanPembatalanAction::make()
            ->color('danger'),
            VerifikasiPengajuanPembatalanAction::make()
        ]);
    }
}
