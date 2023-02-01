<?php

namespace App\Filament\Resources\TaskResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\TaskResource;
use Filament\Pages\Actions\CreateAction;

class ManageTasks extends ManageRecords
{
    protected static string $resource = TaskResource::class;

    public function getActions(): array
    {
        return [
            CreateAction::make()
            ->modalWidth('xl')
            ->icon('heroicon-o-plus')
        ];
    }
}
