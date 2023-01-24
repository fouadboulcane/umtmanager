<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ClientResource;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    // public function getFormTabLabel(): ?string
    // {
    //     return null;
    // }
}
