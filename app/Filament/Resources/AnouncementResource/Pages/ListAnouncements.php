<?php

namespace App\Filament\Resources\AnouncementResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AnouncementResource;

class ListAnouncements extends ListRecords
{
    protected static string $resource = AnouncementResource::class;
}
