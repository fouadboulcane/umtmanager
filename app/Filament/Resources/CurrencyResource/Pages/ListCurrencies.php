<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CurrencyResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Actions\DeleteAction;

class ListCurrencies extends ListRecords
{
    protected static string $resource = CurrencyResource::class;

}
