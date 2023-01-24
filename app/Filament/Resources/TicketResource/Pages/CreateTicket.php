<?php

namespace App\Filament\Resources\TicketResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TicketResource;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;
}
