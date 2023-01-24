<?php

namespace App\Filament\Resources\TicketResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TicketResource;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;
}
