<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PaymentResource;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
}
