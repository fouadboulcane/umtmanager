<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\InvoiceResource;
use Filament\Pages\Actions\CreateAction;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
