<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PaymentResource;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
