<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\InvoiceResource;
use App\Models\Payment;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;

class ManageInvoices extends ManageRecords
{
    protected static string $resource = InvoiceResource::class;

    public function getActions(): array
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus'),
        ];
    }
}
