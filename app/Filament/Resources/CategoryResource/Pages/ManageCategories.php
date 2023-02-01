<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions\CreateAction;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    public function getActions(): array 
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus'),
        ];
    }
}
