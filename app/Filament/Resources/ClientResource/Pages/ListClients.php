<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ClientResource;
use Filament\Pages\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    public function getActions(): array
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus'),
        ];
    }
}
