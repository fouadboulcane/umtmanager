<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\CurrencyResource;
use Filament\Pages\Actions\CreateAction;

class ManageCurrencies extends ManageRecords
{
    protected static string $resource = CurrencyResource::class;

    public function getActions(): array
    {
        return [
            // CreateAction::make()
            //     ->slideOver()
            //     ->size('sm')
            //     ->modalWidth('sm'),
            CreateAction::make()
            ->mountUsing(fn () => $this->fillCreateForm())
            ->action(fn (array $arguments) => $this->create($arguments['another'] ?? false))
            ->modalWidth('xl')
            ->icon('heroicon-o-plus')
            // ->modalSubheading('dds')
        ];
    }
}
