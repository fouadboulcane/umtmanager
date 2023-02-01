<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\ProjectResource;
use Filament\Pages\Actions\CreateAction;

class ManageProjects extends ManageRecords
{
    protected static string $resource = ProjectResource::class;

    public function getActions(): array
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus'),
        ];
    }
}
