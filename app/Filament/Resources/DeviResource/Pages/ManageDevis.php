<?php

namespace App\Filament\Resources\DeviResource\Pages;

use App\Filament\Resources\DeviResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDevis extends ManageRecords
{
    protected static string $resource = DeviResource::class;

    public function getActions(): array
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus'),
        ];
    }
}
