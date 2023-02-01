<?php

namespace App\Filament\Resources\NoteResource\Pages;

use App\Filament\Resources\NoteResource;
use App\Models\Note;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ManageNotes extends ManageRecords
{
    protected static string $resource = NoteResource::class;

    public function getActions(): array 
    {
        return [
            CreateAction::make()->modalWidth('xl')->icon('heroicon-o-plus'),
        ];
    }
}
