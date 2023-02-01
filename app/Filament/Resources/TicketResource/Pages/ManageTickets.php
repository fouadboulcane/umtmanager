<?php

namespace App\Filament\Resources\TicketResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\TicketResource;
use Filament\Pages\Actions\CreateAction;

class ManageTickets extends ManageRecords
{
    protected static string $resource = TicketResource::class;

    public function getActions(): array 
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus')
        ];
    }
}
