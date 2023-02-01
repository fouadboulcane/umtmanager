<?php

namespace App\Filament\Resources\AnouncementResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\AnouncementResource;
use Filament\Pages\Actions\CreateAction;

class ManageAnouncements extends ManageRecords
{
    protected static string $resource = AnouncementResource::class;

    public function getActions(): array
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus'),
        ];
    }
}
