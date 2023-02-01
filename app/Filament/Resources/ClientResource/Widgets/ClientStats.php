<?php

namespace App\Filament\Resources\ClientResource\Widgets;

use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ClientStats extends BaseWidget
{
    public ?Client $record = null;

    protected function getCards(): array
    {
        return [
            Card::make('Projects', $this->record->projects->count()),
            Card::make('Invoice Amount', $this->record->invoiceAmount()),
            Card::make('Paid Amount', $this->record->paidAmount()),
            Card::make('Unpaid Amount', $this->record->unpaidAmount()),
            // Card::make('Product Inventory', Product::sum('qty')),
            // Card::make('Average price', number_format(Product::avg('price'), 2)),
        ];
    }
}
