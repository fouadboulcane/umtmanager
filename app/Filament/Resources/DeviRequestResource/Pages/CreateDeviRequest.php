<?php

namespace App\Filament\Resources\DeviRequestResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DeviRequestResource;
use Illuminate\Support\Facades\Log;

class CreateDeviRequest extends CreateRecord
{
    protected static string $resource = DeviRequestResource::class;

    protected function beforeValidate(): void
    {
        Log::info($this->data);
    }

}
