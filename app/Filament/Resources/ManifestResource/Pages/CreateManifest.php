<?php

namespace App\Filament\Resources\ManifestResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ManifestResource;
use Illuminate\Support\Facades\Log;

class CreateManifest extends CreateRecord
{
    protected static string $resource = ManifestResource::class;

}
