<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ClientResource\Widgets\ClientStats;

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

    public function getHeaderWidgetsColumns(): int | array
    {
        return [
            'lg' => 5,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ClientStats::class,
        ];
    }
}
